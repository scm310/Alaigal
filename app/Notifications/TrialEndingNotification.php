<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class TrialEndingNotification extends Notification
{
    use Queueable;

    protected $freeTrialEnd;

    public function __construct($freeTrialEnd)
    {
        $this->freeTrialEnd = $freeTrialEnd;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Send email and store in database for pop-up
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Free Trial is Ending Soon')
            ->line("Your free trial is ending on {$this->freeTrialEnd}.")
            ->line('Please make your subscription to enjoy complete access.')
            ->action('Make Payment', url('/subscription/payment'))
            ->line('Thank you for using our service!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Your free trial is ending on {$this->freeTrialEnd}. Please make your subscription to enjoy complete access."
        ];
    }
}
