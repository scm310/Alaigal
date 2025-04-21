<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $vendor;

    /**
     * Create a new message instance.
     */
    public function __construct($vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Vendor Registration Pending Approval')
                    ->view('emails.vendor_approval')
                    ->with(['vendor' => $this->vendor]);
    }
}
