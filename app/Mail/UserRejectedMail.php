<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRejectedMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Account Rejected')
                    ->view('emails.userRejected')
                    ->with([
                        'userName' => $this->user->first_name . ' ' . $this->user->last_name,
                        'reason' => $this->user->rejection_reason
                    ]);
    }
}

