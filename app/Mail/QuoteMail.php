<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuoteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $quote;

public function __construct($quote)
{
    $this->quote = $quote;
}

public function build()
{
    return $this->view('emails.quote')
                ->subject('Your Quote')
                ->with('quote', $this->quote);
}


}
