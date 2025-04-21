<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionEndReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $member;
    public $subscriptionEnd;

    public function __construct($member, $subscriptionEnd)
    {
        $this->member = $member;
        $this->subscriptionEnd = $subscriptionEnd;
    }

    public function build()
    {
        return $this->subject('Your Subscription is Expiring Soon!')
                    ->view('emails.subscription_end_reminder')
                    ->with(['member' => $this->member, 'subscriptionEnd' => $this->subscriptionEnd]);
    }
}
