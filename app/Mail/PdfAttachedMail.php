<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PdfAttachedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfPath;

    public function __construct($pdfPath)
    {
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->view('emails.pdf') // Specify your email view
                    ->attach($this->pdfPath, [
                        'as' => 'document.pdf', // The name for the attachment
                        'mime' => 'application/pdf',
                    ])
                    ->subject('Your PDF Document');
    }
}
