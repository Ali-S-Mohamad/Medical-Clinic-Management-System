<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentReminder extends Notification
{
    use Queueable;

    protected $appointment;

    /**
     * Create a new notification instance.
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Appointment Reminder')
            ->greeting('Hello ' . $this->appointment->patient->user->name . ',')
            ->line("Dear {$this->appointment->patient->user->name},")
            ->line('Date: ' . $this->appointment->appointment_date)
            // ->line('Time: ' . $this->appointment->time)
            // ->action('View Details', url( '/appointments/' . $this->appointment->id))
            ->action('View Details', config('app.url') . '/appointments/' . $this->appointment->id)
            ->line('Thank you for choosing our clinic!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [

        ];
    }
}
