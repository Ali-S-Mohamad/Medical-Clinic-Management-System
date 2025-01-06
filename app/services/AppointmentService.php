<?php
namespace App\Services;

use App\Models\Appointment;
use App\Models\TimeSlot;

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
            ->where('is_available', true)
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
    
        return [
            'success' => true,
            'appointment' => $appointment
        ];
    }
    

    //A function that updates the reservation logic
    public function updateAppointment($appointmentId, $patientId, $doctorId, $appointmentDate , $status, $notes)
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

        $slotDuration = $timeSlot->slot_duration * 60; // Convert duration to seconds
        $appointmentEnd = $appointmentStart + $slotDuration;

        // Check for overlapping appointments (scheduled status only), excluding the current appointment
        $overlapExists = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'scheduled') // Only consider scheduled appointments
            ->where('id', '!=', $appointmentId) // Exclude the current appointment
            ->where(function ($query) use ($appointmentStart, $appointmentEnd) {
                $query
                    ->whereBetween('appointment_date', [
                        date('Y-m-d H:i:s', $appointmentStart),
                        date('Y-m-d H:i:s', $appointmentEnd - 1) // End is exclusive
                    ])
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

    public function getAvailableSlots($doctorId, $date)
    {
        $dayOfWeek = date('w', strtotime($date)); // استخراج اليوم
    
        // استرجاع الفترات الزمنية المتاحة للطبيب
        $timeSlots = TimeSlot::where('doctor_id', $doctorId)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->get();
    
        // استرجاع المواعيد المحجوزة (فقط المواعيد ذات الحالة "scheduled")
        $bookedAppointments = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $date)
            ->where('status', 'scheduled') // استبعاد المواعيد غير المجدولة
            ->pluck('appointment_date');
    
        $availableSlots = [];
    
        foreach ($timeSlots as $slot) {
            $startTime = strtotime($slot->start_time);
            $endTime = strtotime($slot->end_time);
            $slotDuration = $slot->slot_duration * 60; // تحويل المدة إلى ثوانٍ
    
            while ($startTime + $slotDuration <= $endTime) {
                $proposedStart = date('H:i:s', $startTime);
                $proposedEnd = date('H:i:s', $startTime + $slotDuration);
    
                // تحقق مما إذا كانت الفترة الزمنية متاحة
                $isAvailable = true;
    
                foreach ($bookedAppointments as $appointmentDateTime) {
                    $appointmentStart = strtotime($appointmentDateTime);
                    $appointmentEnd = $appointmentStart + $slotDuration;
    
                    if (
                        ($startTime >= $appointmentStart && $startTime < $appointmentEnd) || 
                        ($startTime + $slotDuration > $appointmentStart && $startTime + $slotDuration <= $appointmentEnd)
                    ) {
                        $isAvailable = false;
                        break;
                    }
                }
    
                if ($isAvailable) {
                    $availableSlots[] = [
                        'start_time' => $proposedStart,
                        'end_time' => $proposedEnd,
                    ];
                }
    
                $startTime += $slotDuration; // الانتقال إلى الفترة الزمنية التالية
            }
        }
    
        return $availableSlots;
    }
    

}

