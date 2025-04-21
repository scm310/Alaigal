<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Subscription;
use App\Models\Members;
use Razorpay\Api\Api;
use Log;
use Carbon\Carbon;
use App\Models\CustomNotification;
use App\Mail\TrialEndReminder;
use App\Mail\SubscriptionEndReminder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Mail\SendInvoice;

class SubscriptionController extends Controller
{
    public function showPaymentPage()
{
    $member = Auth::guard('member')->user();

    $latestDirectory = Subscription::where('member_id', $member->id)
        ->where('plan_type', 'member_directory')
        ->where('payment_status', 1)
        ->whereDate('end_date', '>=', now())
        ->latest('end_date')
        ->first();

    $razorpayKey = config('services.razorpay.key');
    $remainingDays = 0;
    $calculatedMonths = 0;

    if ($latestDirectory) {
        $now = Carbon::now();
        $end = Carbon::parse($latestDirectory->end_date);
        $remainingDays = $now->diffInDays($end);
        $calculatedMonths = max(1, ceil($remainingDays / 30));
    }

    return view('subscription.payment', compact('razorpayKey', 'latestDirectory', 'calculatedMonths'));
}

    public function processPayment(Request $request)
    {
        DB::beginTransaction();
        try {
            $member = Auth::guard('member')->user();
            if (!$member) {
                Log::error('❌ User not authenticated.');
                return response()->json(['error' => 'User not authenticated.'], 401);
            }

            $memberPlan = (int) $request->input('member_plan');
            $marketplaceEnabled = $request->has('enable_marketplace');
            $marketplacePlan = $request->input('marketplace_plan', null);
            $productCount = $marketplaceEnabled ? (int) $request->input('product_count', 5) : null;

            $memberPrice = ($memberPlan == 6) ? 600 : 1200;
            $marketplaceBase = ($marketplacePlan == "6") ? 200 * 6 : 200 * 12;
            $extraCost = (($productCount - 5) / 5) * 100 * ($memberPlan == 6 ? 6 : 12);
            $marketplacePrice = $marketplaceEnabled ? ($marketplaceBase + $extraCost) : 0;

            $subtotal = $memberPrice + $marketplacePrice;
            $cgst = round($subtotal * 0.09, 2);
            $sgst = round($subtotal * 0.09, 2);
            $totalAmount = round($subtotal + $cgst + $sgst, 2);

            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
            $orderData = [
                'receipt' => 'order_' . uniqid(),
                'amount' => $totalAmount * 100,
                'currency' => 'INR',
                'payment_capture' => 1
            ];
            $razorpayOrder = $api->order->create($orderData);

            DB::commit();

            return response()->json([
                'razorpay_order_id' => $razorpayOrder['id'],
                'amount' => $totalAmount * 100,
                'currency' => 'INR',
                'razorpay_key' => config('services.razorpay.key')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('❌ Payment Processing Failed: ' . $e->getMessage());
            return response()->json(['error' => 'Payment failed: ' . $e->getMessage()], 500);
        }
    }

    public function verifyPaymentMemberDirectory(Request $request)
    {
        DB::beginTransaction();
        try {
            $member = Auth::guard('member')->user();
            if (!$member) {
                throw new \Exception("User not authenticated");
            }

            $paymentId = $request->query('razorpay_payment_id');
            $duration = (int) $request->query('duration');
            
            if (!$paymentId || !in_array($duration, [6, 12])) {
                throw new \Exception("Invalid payment data");
            }

            if (Subscription::where('order_id', $paymentId)->exists()) {
                return redirect()->route('memberdashboard')->with('info', 'Payment already processed');
            }

            $start = Carbon::now();
            $end = $start->copy()->addMonths($duration);

            Subscription::create([
                'member_id' => $member->id,
                'plan_type' => 'member_directory',
                'duration' => $duration,
                'product_count' => null,
                'amount' => $duration === 12 ? 1200 : 600,
                'payment_status' => 1,
                'start_date' => $start,
                'end_date' => $end,
                'order_id' => $paymentId,
            ]);

            $member->update(['payment' => 1]);
            DB::commit();
            return redirect()->route('memberdashboard')->with('success', 'Payment verified successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Payment verification failed: " . $e->getMessage());
            return redirect()->route('subscription.payment')->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }





public function verifyPaymentMarketplace(Request $request)
{
    DB::beginTransaction();
    try {
        $member = Auth::guard('member')->user();
        if (!$member) {
            return redirect()->route('subscription.payment')->with('error', 'User not authenticated.');
        }

        $paymentId = $request->query('razorpay_payment_id');
        $productCount = (int) $request->query('product_count', 0);
        
        if (!$paymentId || $productCount < 5) {
            return redirect()->route('subscription.payment')->with('error', 'Invalid payment data.');
        }

        // Check for existing subscription
        $existing = Subscription::where('order_id', $paymentId)->first();
        if ($existing) {
            return redirect()->route('memberdashboard')->with('info', 'Payment already processed.');
        }

        $now = Carbon::now();
        $latestDirectory = Subscription::where('member_id', $member->id)
            ->where('plan_type', 'member_directory')
            ->where('payment_status', 1)
            ->whereDate('end_date', '>=', $now)
            ->latest('end_date')
            ->first();

        if (!$latestDirectory) {
            return redirect()->route('subscription.payment')->with('error', 'Active Member Directory subscription required.');
        }

        $endDate = Carbon::parse($latestDirectory->end_date);
        
        // More accurate month calculation
        $diffMonths = $now->diffInMonths($endDate);
        
        // If there are remaining days less than 15, don't count as full month
        $remainingDays = $now->copy()->addMonths($diffMonths)->diffInDays($endDate);
        if ($remainingDays > 15) {  // Only add month if more than 15 days remaining
            $diffMonths += 1;
        }
        
        // Ensure minimum 1 month
        $diffMonths = max(1, $diffMonths);

        // Log calculation for debugging
        Log::info('Marketplace duration calculation', [
            'start_date' => $now,
            'end_date' => $endDate,
            'diff_months' => $diffMonths,
            'remaining_days' => $remainingDays,
            'product_count' => $productCount
        ]);

        $base = 200;
        $extra = max(($productCount - 5) / 5, 0) * 100;
        $total = ($base + $extra) * $diffMonths;

        Subscription::create([
            'member_id' => $member->id,
            'plan_type' => 'marketplace',
            'duration' => $diffMonths,
            'product_count' => $productCount,
            'amount' => $total,
            'payment_status' => 1,
            'start_date' => $now,
            'end_date' => $endDate,
            'order_id' => $paymentId,
        ]);

        $member->update(['payment' => 1]);
        DB::commit();
        return redirect()->route('memberdashboard')->with('success', 'Marketplace Payment verified successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Marketplace Payment Error: ' . $e->getMessage());
        return redirect()->route('subscription.payment')->with('error', 'Payment verification failed: ' . $e->getMessage());
    }
}

    public function verifyPaymentBoth(Request $request)
    {
        DB::beginTransaction();
        try {
            $member = Auth::guard('member')->user();
            if (!$member) {
                return redirect()->route('subscription.payment')->with('error', 'User not authenticated.');
            }

            $paymentId = $request->query('razorpay_payment_id');
            $duration = (int) $request->query('duration');
            $productCount = (int) $request->query('product_count', 0);
            
            if (!$paymentId || !in_array($duration, [6, 12]) || $productCount < 5) {
                return redirect()->route('subscription.payment')->with('error', 'Invalid payment data.');
            }

            // Check for existing subscription
            $existing = Subscription::where('order_id', $paymentId)->first();
            if ($existing) {
                return redirect()->route('memberdashboard')->with('info', 'Payment already processed.');
            }

            $now = Carbon::now();
            $endDate = $now->copy()->addMonths($duration);

            Subscription::insert([
                [
                    'member_id' => $member->id,
                    'plan_type' => 'member_directory',
                    'duration' => $duration,
                    'product_count' => null,
                    'amount' => $duration === 12 ? 1200 : 600,
                    'payment_status' => 1,
                    'start_date' => $now,
                    'end_date' => $endDate,
                    'order_id' => $paymentId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'member_id' => $member->id,
                    'plan_type' => 'marketplace',
                    'duration' => $duration,
                    'product_count' => $productCount,
                    'amount' => (200 + max(($productCount - 5) / 5, 0) * 100) * $duration,
                    'payment_status' => 1,
                    'start_date' => $now,
                    'end_date' => $endDate,
                    'order_id' => $paymentId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);

            $member->update(['payment' => 1]);
            DB::commit();
            return redirect()->route('memberdashboard')->with('success', 'Both subscriptions activated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Both Payment Error: ' . $e->getMessage());
            return redirect()->route('subscription.payment')->with('error', 'Payment verification failed: ' . $e->getMessage());
        }
    }

 

public function downloadInvoice($subscriptionId)
{
    try {
        $member = Auth::guard('member')->user();
        $subscription = Subscription::where('id', $subscriptionId)
            ->where('member_id', $member->id)
            ->firstOrFail();

        $data = [
            'member' => $member,
            'subscription' => $subscription,
            'invoiceNumber' => 'INV-'.str_pad($subscription->id, 4, '0', STR_PAD_LEFT),
            'date' => now()->format('d M, Y')
        ];

        $pdf = PDF::loadView('subscription.invoice', $data);
        return $pdf->download("invoice_{$data['invoiceNumber']}.pdf");

    } catch (\Exception $e) {
        Log::error("Invoice generation failed: ".$e->getMessage());
        return back()->with('error', 'Invoice generation failed');
    }
}

   public function paymentHistory()
    {
        $member = Auth::guard('member')->user();
        if (!$member) {
            return redirect()->route('login')->with('error', 'You must be logged in to view your payment history.');
        }

        $subscriptions = Subscription::where('member_id', $member->id)->get();
        return view('subscription.history', compact('subscriptions'));
    }



    // ✅ Send Daily Notifications for Free Trial & Subscription Expiry
public function sendDailyNotifications()
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
            $daysLeft = $trialEnd->diffInDays($today, false);

            if ($daysLeft <= 5 && $daysLeft >= 0) {
                $key = "trial_email_sent_{$memberId}_day_{$daysLeft}";

                // Disabled cache for testing trial emails
                // if (!Cache::has($key)) {
                    $message = $daysLeft == 0
                        ? "Your Free trial has ended. Please subscribe to enable access to the portal."
                        : "Your Free trial is ending on {$trialEnd->toDateString()}. Please subscribe to enjoy complete access.";

                    $this->notifyMember($member, $message, new TrialEndReminder($member, $trialEnd));

                    // Cache::put($key, true, 86400);
                    if ($daysLeft == 0) $member->update(['payment' => 0]);
                // }
            }
        }

        // === Subscription Expiry ===
        $activeSubscription = $member->latestSubscription;
        if ($activeSubscription) {
            $subscriptionEnd = Carbon::parse($activeSubscription->end_date);
            $daysLeft = $subscriptionEnd->diffInDays($today, false);

            if ($daysLeft <= 5 && $daysLeft >= 0) {
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

    // ✅ Create Notification Entry & Send Email
 private function notifyMember($member, $message, $mailInstance)
{
    try {
        CustomNotification::create([
            'notifiable_type' => 'App\\Models\\Members',
            'notifiable_id' => $member->id,
            'data' => json_encode(['message' => $message]),
        ]);

        \Log::info("Sending Trial/Subscription mail to: {$member->email}");

        \Mail::to($member->email)->send($mailInstance);

    } catch (\Exception $e) {
        \Log::error("Failed to send notification email to {$member->email}: " . $e->getMessage());
    }
}

private function sendNotification($member, $message)
{
    try {
        \App\Models\CustomNotification::create([
            'notifiable_type' => \App\Models\Members::class,
            'notifiable_id' => $member->id,
            'data' => json_encode(['message' => $message]),
            'read_at' => null
        ]);

        \Log::info("Sending generic notification email to: {$member->email}");

        \Mail::to($member->email)->send(new \App\Mail\TrialEndReminder($message));

    } catch (\Exception $e) {
        \Log::error("Failed to send generic email to {$member->email}: " . $e->getMessage());
    }
}

}