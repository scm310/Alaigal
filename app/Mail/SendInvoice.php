<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Members;
use App\Models\Subscription;

class SendInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $member;
    public $subscription;

   public function __construct($member, $subscription, $filePath, $invoiceNumber)
{
    $this->member = $member;
    $this->subscription = $subscription;
    $this->filePath = $filePath;
    $this->invoiceNumber = $invoiceNumber;
}

public function build()
{
    return $this->subject('Your TIEPMD Subscription Invoice')
                ->view('emails.invoice')
                ->with([
                    'member' => $this->member,
                    'subscription' => $this->subscription,
                    'invoiceNumber' => $this->invoiceNumber
                ])
                ->attach($this->filePath, [
                    'as' => "invoice_{$this->invoiceNumber}.pdf",
                    'mime' => 'application/pdf',
                ]);
}
}
