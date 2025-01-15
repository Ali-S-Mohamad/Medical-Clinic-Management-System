<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointmentDetails;

    /**
     * Create a new message instance.
     */
    public function __construct($appointmentDetails)
    {
        $this->appointmentDetails = $appointmentDetails;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appointment Notification Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment_notification', // مسار العرض الصحيح
            with: [
                'patientName' => $this->appointmentDetails->patient->user->name ?? 'N/A', // تجنب الأخطاء إذا كان الاسم فارغاً
                'appointmentDate' => $this->appointmentDetails->appointment_date ?? 'N/A',
                'doctorName' => 'Dr.' . $this->appointmentDetails->employee->user->name ?? 'N/A',
                'appointment_url' => url('appointments',$this->appointmentDetails)
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
