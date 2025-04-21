<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class SubscriptionEndingNotification extends Notification
{
    use Queueable;

    protected $subscriptionEnd;

    public function __construct($subscriptionEnd)
    {
        $this->subscriptionEnd = $subscriptionEnd;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Send email and store in database for pop-up
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Subscription is Ending Soon')
            ->line("Your subscription is ending on {$this->subscriptionEnd}.")
            ->line('Please renew your subscription before the end date to enjoy uninterrupted access.')
            ->action('Renew Subscription', url('/subscription/payment'))
            ->line('Thank you for using our service!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Your subscription is ending on {$this->subscriptionEnd}. Please renew your subscription on or before the end date to enjoy uninterrupted access."
        ];
    }
}
