<?php
namespace App\Mail;

use App\Models\VendorDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $vendor;
    public $password;

    public function __construct(VendorDetail $vendor, $password)
    {
        $this->vendor = $vendor;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Your Vendor Registration Details')
                    ->view('emails.vendor_credentials');
    }
}
