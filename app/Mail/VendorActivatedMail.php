<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorActivatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $vendor;
    public $password;

    public function __construct($vendor, $password)
    {
        $this->vendor = $vendor;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Your Vendor Account is Approved')
                    ->view('emails.vendor_approved')
                    ->with([
                        'name' => $this->vendor->name,
                        'email' => $this->vendor->email,
                        'password' => $this->password,
                        'login_url' => url('/vendor/login'), // Change this to your login URL
                    ]);
    }


    
}
