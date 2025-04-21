<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Members;

use App\Mail\TrialEndReminder;
use App\Mail\SubscriptionEndReminder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class SendDailyNotifications extends Command
{
    protected $signature = 'daily:notify';
    protected $description = 'Send daily trial and subscription reminder notifications';

    public function handle()
    {
        Log::info("Running Daily Notification Job...");

        $today = Carbon::now();
        $members = Members::all();

        foreach ($members as $member) {
            $memberId = $member->id;

            // === Trial Period ===
            if ($member->free_trial_start_date) {
                $trialStart = Carbon::parse($member->free_trial_start_date);
                $trialEnd = $trialStart->copy()->addDays(15);
                $daysLeft = $today->diffInDays($trialEnd, false);

                Log::info("Checking trial for {$member->email}: Trial ends on {$trialEnd->toDateString()} ({$daysLeft} days left)");

                if ($daysLeft >= 0 && $daysLeft <= 5) {
                    $message = $daysLeft == 0
                        ? "Your Free trial has ended. Please subscribe to enable access to the portal."
                        : "Your Free trial is ending on {$trialEnd->toDateString()}. Please subscribe to enjoy complete access.";

                    $this->notifyMember($member, $message, new TrialEndReminder($member, $trialEnd));
                    if ($daysLeft == 0) $member->update(['payment' => 0]);
                }
            }

            // === Subscription Expiry ===
            $activeSubscription = $member->latestSubscription;
            if ($activeSubscription) {
                $subscriptionEnd = Carbon::parse($activeSubscription->end_date);
                $daysLeft = $today->diffInDays($subscriptionEnd, false);

                Log::info("Checking subscription for {$member->email}: Subscription ends on {$subscriptionEnd->toDateString()} ({$daysLeft} days left)");

                if ($daysLeft >= 0 && $daysLeft <= 5) {
                    $key = "sub_email_sent_{$memberId}_day_{$daysLeft}";
                    if (!Cache::has($key)) {
                        $message = $daysLeft == 0
                            ? "Your subscription has expired. Please renew your subscription to regain access."
                            : "Your subscription is ending on {$subscriptionEnd->toDateString()}. Please renew your subscription.";

                        $this->notifyMember($member, $message, new SubscriptionEndReminder($member, $subscriptionEnd));
                        Cache::put($key, true, 86400);
                        if ($daysLeft == 0) $member->update(['payment' => 0]);
                    }
                }
            }
        }

        Log::info("Daily Notifications Sent Successfully.");
    }

    private function notifyMember($member, $message, $mailInstance)
    {
        try {
           

            Log::info("Sending Trial/Subscription mail to: {$member->email}");
            Mail::to($member->email)->send($mailInstance);

        } catch (\Exception $e) {
            Log::error("Failed to send notification email to {$member->email}: " . $e->getMessage());
        }
    }
}