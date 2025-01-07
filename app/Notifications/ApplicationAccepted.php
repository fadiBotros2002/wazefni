<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationAccepted extends Notification
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
       // $postTitle = $this->application->post ? $this->application->post->title : 'Unknown Position';

        return (new MailMessage)
                    ->subject('Your Application Has Been Accepted')
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line('Your job application has been accepted. The company will be in touch with you.')
                    ->line('Thank you for applying!')
                    //->action('View Application', url('/applications/' . $this->application->id))
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
