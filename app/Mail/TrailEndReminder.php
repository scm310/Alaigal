<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TrialEndReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $member;
    public $trialEnd;

    public function __construct($member, $trialEnd)
    {
        $this->member = $member;
        $this->trialEnd = $trialEnd;
    }

    public function build()
    {
        return $this->subject('Your Free Trial is Ending Soon!')
                    ->view('emails.trial_end_reminder')
                    ->with(['member' => $this->member, 'trialEnd' => $this->trialEnd]);
    }
}
