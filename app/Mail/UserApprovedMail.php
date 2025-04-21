<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $vendor;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $vendor (\Illuminate\Support\Optional)
     */
    public function __construct($user, $vendor = null)
    {
        $this->user = $user;
        $this->vendor = $vendor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Account has been Approved')
                    ->view('emails.userApproved')
                    ->with([
                        'userName' => $this->user->first_name . ' ' . $this->user->last_name,
                        'userEmail' => $this->user->email,
                        'userPassword' => '1234', // Default password
                        'vendorEmail' => $this->vendor ? $this->vendor->email : null,
                        'vendorPassword' => $this->vendor ? '12345678' : null, // Default vendor password
                    ]);
    }
}
