<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    public function __construct($mailData)
    {
        $this->mailData = $mailData; // Initialize mail data
    }

    public function build()
    {
        return $this->view('emails.registration')
                    ->with([
                        'email' => $this->mailData['email'],    // Ensure email is passed
                        'password' => $this->mailData['password'],  // Use the register object for password
                        'name'=> $this->mailData['name'], 
                    ]);
    }
}
