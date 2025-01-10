<?php

namespace App\Listeners;

use App\Events\AppointmentCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\AppointmentNotificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAppointmentNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AppointmentCreated $event): void
    {
        $appointment = $event->appointment;
        $patientEmail = $appointment->patient->user->email;
        
        Mail::to($patientEmail)->send(new AppointmentNotificationMail($appointment));
    }
}
