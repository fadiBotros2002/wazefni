<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationRejected extends Notification
{
    use Queueable;

    public $application;

    /**
     * Create a new notification instance.
     */
    public function __construct($application)
    {
        $this->application = $application;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Your Application Has Been Rejected')
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line('We regret to inform you that your job application has been rejected.')
                    ->line('Thank you for applying and we wish you the best of luck in your job search.')
                    ->line('Best regards,')
                    ->line('Wazefni Team');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'application_id' => $this->application->id,
            'post_id' => $this->application->post_id,
        ];
    }
}
