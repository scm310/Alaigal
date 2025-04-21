<?php

namespace App\Mail;

use App\Models\VendorDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorLoginCredentials extends Mailable
{
    use Queueable, SerializesModels;

    public $vendor;
    public $password;

    /**
     * Create a new message instance.
     *
     * @param VendorDetail $vendor
     * @param string $password
     */
    public function __construct(VendorDetail $vendor, $password)
    {
        $this->vendor = $vendor;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return \Illuminate\Mail\Mailable
     */
    public function build()
    {
        return $this->subject('Your Vendor Login Credentials')
                    ->view('emails.vendor.login_credentials');
    }
}
