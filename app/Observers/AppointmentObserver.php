<?php

namespace App\Observers;

use App\Models\Report;
use App\Models\Appointment;

class AppointmentObserver
{
    /**
     * Handle the Appointment "created" event.
     */
    public function created(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "updated" event.
     */
    public function updated(Appointment $appointment)
    {
        if ($appointment->status === 'completed') {
            // إنشاء تقرير جديد بناءً على الموعد المكتمل
            Report::create([
                'patient_id' => $appointment->patient_id,
                'patient_name' => $appointment->patient->user->name, 
                'doctor_name' => $appointment->employee->user->name,
                'appointment_date' => $appointment->appointment_date, 
                'medications_names' => $appointment->prescription->medications_names, 
                'instructions' => $appointment->prescription->instructions, 
                'details' => $appointment->prescription->details, 
            ]);
        }
    }

    /**
     * Handle the Appointment "deleted" event.
     */
    public function deleted(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "restored" event.
     */
    public function restored(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "force deleted" event.
     */
    public function forceDeleted(Appointment $appointment): void
    {
        //
    }
}
