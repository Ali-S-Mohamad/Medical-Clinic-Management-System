<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\TimeSlot;
use App\Models\Appointment;
use App\Events\AppointmentCreated;

class AppointmentService
{
    // A function that performs the reservation logic
    public function bookAppointment($patientId, $doctorId, $appointmentDate)
    {
        $appointmentStart = strtotime($appointmentDate);

        // Verify that the appointment is not in the past
        if ($appointmentStart < time()) {
            return [
                'success' => false,
                'message' => 'Cannot book an appointment in the past.'
            ];
        }

        // Retrieve the doctor's time slot for the specified day and time
        $dayOfWeek = date('w', $appointmentStart);
        $timeSlot = TimeSlot::where('doctor_id', $doctorId)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', 1)
            ->whereRaw('TIME(?) BETWEEN start_time AND end_time', [date('H:i:s', $appointmentStart)])
            ->first();

        if (!$timeSlot) {
            return [
                'success' => false,
                'message' => 'The selected time does not fall within the doctor\'s available time slots.'
            ];
        }

        // Ensure the appointment start time is not equal to the end time of the time slot
        if (date('H:i:s', $appointmentStart) === $timeSlot->end_time) {
            return [
                'success' => false,
                'message' => 'Cannot book an appointment at the end of the doctor\'s working hours.'
            ];
        }

        $slotDuration = $timeSlot->slot_duration * 60; // Convert duration to seconds
        $appointmentEnd = $appointmentStart + $slotDuration;

        // Check for overlapping appointments (scheduled status only)
        $overlapExists = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'scheduled') // Only consider scheduled appointments
            ->where(function ($query) use ($appointmentStart, $appointmentEnd) {
                $query
                    // Case 1: Existing appointment starts during the new appointment
                    ->whereBetween('appointment_date', [
                        date('Y-m-d H:i:s', $appointmentStart),
                        date('Y-m-d H:i:s', $appointmentEnd - 1) // End is exclusive
                    ])
                    // Case 2: New appointment starts during an existing appointment
                    ->orWhereRaw('DATE_ADD(appointment_date, INTERVAL ? SECOND) > ? AND appointment_date <= ?', [
                        $appointmentEnd - $appointmentStart,
                        date('Y-m-d H:i:s', $appointmentStart),
                        date('Y-m-d H:i:s', $appointmentStart)
                    ]);
            })
            ->exists();

        if ($overlapExists) {
            return [
                'success' => false,
                'message' => 'The selected time slot overlaps with another scheduled appointment.'
            ];
        }

        // Create the appointment
        $appointment = Appointment::create([
            'patient_id' => $patientId,
            'doctor_id' => $doctorId,
            'appointment_date' => date('Y-m-d H:i:s', $appointmentStart),
            'status' => 'scheduled',
            'notes' => '',
        ]);
        event(new AppointmentCreated($appointment));
        return [
            'success' => true,
            'appointment' => $appointment
        ];
    }


    //A function that updates the reservation logic
    public function updateAppointment($appointmentId, $patientId, $doctorId, $appointmentDate, $status, $notes)
    {
        $appointmentStart = strtotime($appointmentDate);

        // Verify that the appointment is not in the past
        if ($appointmentStart < time()) {
            return [
                'success' => false,
                'message' => 'Cannot update an appointment to a time in the past.'
            ];
        }

        // Retrieve the doctor's time slot for the specified day and time
        $dayOfWeek = date('w', $appointmentStart);
        $timeSlot = TimeSlot::where('doctor_id', $doctorId)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->whereRaw('TIME(?) BETWEEN start_time AND end_time', [date('H:i:s', $appointmentStart)])
            ->first();

        if (!$timeSlot) {
            return [
                'success' => false,
                'message' => 'The selected time does not fall within the doctor\'s available time slots.'
            ];
        }

        // Calculate the end time based on the slot duration
        $slotDuration = $timeSlot->slot_duration * 60; // Convert duration to seconds
        $appointmentEnd = $appointmentStart + $slotDuration;

        // Ensure the appointment start time is not equal to the end time of the time slot
        if (date('H:i:s', $appointmentStart) === $timeSlot->end_time) {
            return [
                'success' => false,
                'message' => 'Cannot update an appointment at the end of the doctor\'s working hours.'
            ];
        }

        // Check for overlapping appointments (scheduled status only), excluding the current appointment
        $overlapExists = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'scheduled') // Only consider scheduled appointments
            ->where('id', '!=', $appointmentId) // Exclude the current appointment
            ->where(function ($query) use ($appointmentStart, $appointmentEnd) {
                $query
                    // Case 1: Existing appointment starts during the new appointment
                    ->whereBetween('appointment_date', [
                        date('Y-m-d H:i:s', $appointmentStart),
                        date('Y-m-d H:i:s', $appointmentEnd - 1) // End is exclusive
                    ])
                    // Case 2: New appointment starts during an existing appointment
                    ->orWhereRaw('DATE_ADD(appointment_date, INTERVAL ? SECOND) > ? AND appointment_date <= ?', [
                        $appointmentEnd - $appointmentStart,
                        date('Y-m-d H:i:s', $appointmentStart),
                        date('Y-m-d H:i:s', $appointmentStart)
                    ]);
            })
            ->exists();

        if ($overlapExists) {
            return [
                'success' => false,
                'message' => 'The selected time slot overlaps with another scheduled appointment.'
            ];
        }

        // Update the appointment
        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->update([
            'patient_id' => $patientId,
            'doctor_id' => $doctorId,
            'appointment_date' => date('Y-m-d H:i:s', $appointmentStart),
            'status' => $status,
            'notes' => $notes
        ]);

        return [
            'success' => true,
            'appointment' => $appointment
        ];
    }

    //A function that displays the available times for each doctor on a specific date
    public function getAvailableSlots($doctorId, $dayOfWeek, $date)
    {
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

