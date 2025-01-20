<?php

namespace App\Observers;

use App\Models\Report;
use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentNotificationMail;

class AppointmentObserver
{
    /**
     * Handle the Appointment "created" event.
     */
    public function created(Appointment $appointment): void
    {
        $patientEmail = $appointment->patient->user->email;
        if ($appointment->status === 'scheduled')
            Mail::to($patientEmail)->send(new AppointmentNotificationMail($appointment));
    }

    /**
     * Handle the Appointment "updated" event.
     */
    public function updated(Appointment $appointment)
    {
        if ($appointment->status === 'completed') {
            // Create report when appointment be completed
            Report::create([
                'patient_id' => $appointment->patient_id,
                'patient_name' => $appointment->patient->user->firstname . ' ' . $appointment->patient->user->lastname, // دمج firstname و lastname
                'doctor_name' => $appointment->employee->user->firstname . ' ' . $appointment->employee->user->lastname,
                'appointment_date' => $appointment->appointment_date,
                'medications_names' => $appointment->prescription->medications_names,
                'instructions' => $appointment->prescription->instructions,
                'details' => $appointment->prescription->details,
            ]);
        }
        $patientEmail = $appointment->patient->user->email;
        if ($appointment->status === 'scheduled')
            Mail::to($patientEmail)->send(new AppointmentNotificationMail($appointment));
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
