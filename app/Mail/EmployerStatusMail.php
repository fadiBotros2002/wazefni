<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployerStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $status;

    public function __construct($user, $status)
    {
        $this->user = $user;
        $this->status = $status;
    }

    public function build()
    {
        $subject = ($this->status === 'approved') ? 'Your Employer Application Approved' : 'Your Employer Application Rejected';

        return $this->view('emails.employer_status')
                    ->with(['user' => $this->user, 'status' => $this->status])
                    ->subject($subject);
    }
}

