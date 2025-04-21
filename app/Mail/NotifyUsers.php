<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class NotifyUsers extends Mailable
{
    public $subject;
    public $body; // Rename "message" to "body" to avoid conflicts

    public function __construct(array $emailData)
    {
        if (!isset($emailData['subject'], $emailData['message'])) {
            throw new \InvalidArgumentException('Subject and message are required.');
        }

        $this->subject = $emailData['subject'];
        $this->body = $emailData['message']; // Store "message" as "body"
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.notify')
                    ->with([
                        'subject' => $this->subject,
                        'body' => $this->body, // Pass "body" instead of "message"
                    ]);
    }
}
