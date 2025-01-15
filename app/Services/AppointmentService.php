<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\TimeSlot;
use App\Models\Appointment;
use App\Events\AppointmentCreated;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentReminderMail;
use App\Mail\AppointmentNotificationMail;

class AppointmentService
{
    // A function to check that the appointment is in the future
    private function isAppointmentInPast($appointmentDate)
    {
        $appointmentStart = strtotime($appointmentDate);
        if ($appointmentStart < time()) {
            return [
                'success' => false,
                'message' => 'An appointment cannot be booked in the past.'
            ];
        }
        return ['success' => true];
    }

    // A function to check the doctor's time availability
    private function isDoctorAvailable($doctorId, $appointmentDate)
    {
        $appointmentStart = strtotime($appointmentDate);
        $dayOfWeek = date('w', $appointmentStart);
        $timeSlot = TimeSlot::where('doctor_id', $doctorId)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->whereRaw('TIME(?) BETWEEN start_time AND end_time', [date('H:i:s', $appointmentStart)])
            ->first();

        if (!$timeSlot) {
            return [
                'success' => false,
                'message' => 'The scheduled time is not compatible with doctors appointments.'
            ];
        }

        return [
            'success' => true,
            'timeSlot' => $timeSlot,
            'appointmentStart' => $appointmentStart
        ];
    }

    // A function to check for overlapping dates
    private function isAppointmentOverlapping($doctorId, $appointmentStart, $appointmentEnd, $appointmentId = null)
    {
        $query = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'scheduled')
            ->where(function ($query) use ($appointmentStart, $appointmentEnd) {
                $query
                    ->whereBetween('appointment_date', [
                        date('Y-m-d H:i:s', $appointmentStart),
                        date('Y-m-d H:i:s', $appointmentEnd - 1)
                    ])
                    ->orWhereRaw('DATE_ADD(appointment_date, INTERVAL ? SECOND) > ? AND appointment_date <= ?', [
                        $appointmentEnd - $appointmentStart,
                        date('Y-m-d H:i:s', $appointmentStart),
                        date('Y-m-d H:i:s', $appointmentStart)
                    ]);
            });

        if ($appointmentId) {
            $query->where('id', '!=', $appointmentId);
        }

        $overlapExists = $query->exists();

        if ($overlapExists) {
            return [
                'success' => false,
                'message' => 'There is an overlapping appointment with the scheduled '
            ];
        }

        return ['success' => true];
    }

    // A function to create or update an appointment
    private function createOrUpdateAppointment($appointmentId, $patientId, $doctorId, $appointmentDate, $status, $notes)
    {
        $validationResult = $this->isAppointmentInPast($appointmentDate);
        if (!$validationResult['success']) {
            return $validationResult;
        }

        // Check the doctor's time availability
        $availabilityResult = $this->isDoctorAvailable($doctorId, $appointmentDate);
        if (!$availabilityResult['success']) {
            return $availabilityResult;
        }

        $timeSlot = $availabilityResult['timeSlot'];
        $appointmentStart = $availabilityResult['appointmentStart'];
        $slotDuration = $timeSlot->slot_duration * 60;
        $appointmentEnd = $appointmentStart + $slotDuration;

        // Check for overlapping appointments
        $overlapResult = $this->isAppointmentOverlapping($doctorId, $appointmentStart, $appointmentEnd, $appointmentId);
        if (!$overlapResult['success']) {
            return $overlapResult;
        }

        // Determine status based on who is creating the appointment
        // Assume `$status` is passed from the controller (e.g., 'pending' for patient, 'scheduled' for others)
        if (!$appointmentId && $status === 'pending') {
            // When creating a new appointment by the patient, the status is 'pending'
            $status = 'pending'; // You can override this based on business logic
        } else {
            // When updating or a non-patient creates the appointment, set status to 'scheduled'
            if (!$appointmentId) {
                $status = 'scheduled'; // Default to 'scheduled' for admin/doctor creation
            }
        }
        if ($appointmentId) {
            // If the appointment already exists, we update it
            $appointment = Appointment::findOrFail($appointmentId);
            $appointment->update([
                'patient_id' => $patientId,
                'doctor_id' => $doctorId,
                'appointment_date' => date('Y-m-d H:i:s', $appointmentStart),
                'status' => $status,
                'notes' => $notes
            ]);
        } else {
            // If the appointment is new, we create it
            $appointment = Appointment::create([
                'patient_id' => $patientId,
                'doctor_id' => $doctorId,
                'appointment_date' => date('Y-m-d H:i:s', $appointmentStart),
                'status' => $status,
                'notes' => $notes
            ]);
        }
        $patientEmail = $appointment->patient->user->email;
        Mail::to($patientEmail)->send(new AppointmentNotificationMail($appointment));
        return [
            'success' => true,
            'appointment' => $appointment
        ];
    }

    // Function for booking an appointment
    public function bookAppointment($patientId, $doctorId, $appointmentDate, $status = null, $notes = null)
    {
        if (is_null($status)) {
            $currentUser = auth()->user();

            if ($currentUser->hasRole('patient')) {
                $status = 'pending';
            } else {
                $status = 'scheduled';
            }
        }
        return $this->createOrUpdateAppointment(null, $patientId, $doctorId, $appointmentDate, $status, $notes);
    }


    // A function to update the appointment
    public function updateAppointment($appointmentId, $patientId, $doctorId, $appointmentDate, $status, $notes)
    {
        return $this->createOrUpdateAppointment($appointmentId, $patientId, $doctorId, $appointmentDate, $status, $notes);
    }

    //A function that displays the available times for each doctor on a specific date
    public function getAvailableSlots($doctorId, $date)
    {
        $dayOfWeek = Carbon::parse($date)->dayOfWeek;
        // Retrieve the time slot details for the specified doctor and day of the week
        $timeSlot = TimeSlot::where('doctor_id', $doctorId)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true) // Only get available slots
            ->first();

        // If no time slot is found for the given doctor and day, return an empty array
        if (!$timeSlot) {
            return [];
        }

        // Parse the start and end time from the time slot
        $startTime = Carbon::parse($timeSlot->start_time); // Start time as a Carbon object
        $endTime = Carbon::parse($timeSlot->end_time); // End time as a Carbon object
        $slotDuration = $timeSlot->slot_duration; // Duration of each time slot in minutes

        // Initialize an array to hold all available time slots
        $allSlots = [];
        // Loop through the available time slots from start time to end time
        while ($startTime->lt($endTime)) {
            $allSlots[] = $startTime->format('H:i'); // Add the current time slot to the array
            $startTime->addMinutes($slotDuration); // Increment start time by the slot duration
        }

        // Retrieve all appointments for the given doctor on the specified date
        $appointments = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $date) // Filter by the exact date
            ->whereIn('status', ['scheduled', 'completed']) // Exclude cancelled appointments
            ->get();

        // Map the appointments to their respective start times (in HH:mm format)
        $bookedSlots = $appointments->map(function ($appointment) {
            return Carbon::parse($appointment->appointment_date)->format('H:i');
        })->toArray();

        // Find the available slots by excluding the booked slots from all slots
        $availableSlots = array_diff($allSlots, $bookedSlots);

        // Return the available slots (resetting the array keys)
        return array_values($availableSlots);
    }
}
