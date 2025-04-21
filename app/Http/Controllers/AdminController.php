<?php

namespace App\Http\Controllers;

use App\Mail\UserRejectedMail;
use App\Models\CompletedProject;
use App\Models\Testimonial;
use App\Models\VendorRegister;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserApprovedMail;
use App\Models\Client;
use App\Models\Item;
use App\Models\Members;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf; // Add at the top
use App\Models\Thanksnote;

class AdminController extends Controller
{


    public function showUsers()
    {
        // Sort users based on 'created_at' in descending order
        $users = Members::orderBy('created_at', 'desc')->get();
        return view('admin.managemember', compact('users'));
    }






    public function approveUser($id)
    {
        // Find user by ID
        $user = Members::findOrFail($id);

        // Update status to 'approved' in `members` table
        $user->approve_status = 1;

        // Save changes in `members` table
        $user->save();

        // Fetch vendor details from `vendor_registers`
        $vendor = VendorRegister::where('member_id', $user->id)->first();

        if ($vendor) {
            // Explicitly set and save vendor status
            $vendor->status = 'approved';
            $vendor->save(); // Explicit save

            // Send approval email with both user and vendor login credentials
            Mail::to($user->email)->send(new UserApprovedMail($user, $vendor));
        } else {
            // Send only user approval email if vendor details are not found
            Mail::to($user->email)->send(new UserApprovedMail($user, null));
        }

        // Redirect back with a success message
        return redirect()->route('admin.users')->with('success', 'User approved and member directory and marketplace credentials sent successfully');
    }








public function rejectUser(Request $request)
{
    // Find user by ID
    $user = Members::findOrFail($request->user_id);

    // Update status to rejected
    $user->approve_status = 3; // Mark the user as rejected
    $user->rejection_reason = $request->rejection_reason; // Store the rejection reason
    $user->save();

    // Send rejection email
    Mail::to($user->email)->send(new UserRejectedMail($user));

    // Redirect with SweetAlert message
    return redirect()->route('admin.users')->with('error', 'User has been rejected and email sent.');
}







public function logout()
{
    // Log out the user
    Auth::logout();

    // Redirect to the admin login page
    return redirect()->route('admin.login');
}


public function memberlounge(Request $request)
{
    $search = $request->input('search');

    $members = Members::where('approve_status', 1)
        ->where('payment', 1) // Show only paid members
        ->where(function ($query) use ($search) {
            if ($search) {
                $query->where('first_name', 'like', "%$search%")
                      ->orWhere('last_name', 'like', "%$search%")
                      ->orWhere('company_name', 'like', "%$search%")
                      ->orWhere('phone_number', 'like', "%$search%")
                      ->orWhereIn('id', function ($subQuery) use ($search) {
                          $subQuery->select('user_id')->from('products')->where('product_name', 'like', "%$search%");
                      })
                      ->orWhereIn('id', function ($subQuery) use ($search) {
                          $subQuery->select('user_id')->from('services')->where('service_name', 'like', "%$search%");
                      });
            }
        })
        ->orderBy('first_name', 'asc')
        ->paginate(18);

    // Check if each member has related data (Products, Services, Clients, etc.)
    foreach ($members as $member) {
        $member->canEnablePrime = DB::table('products')->where('user_id', $member->id)->exists() ||
                                  DB::table('services')->where('user_id', $member->id)->exists() ||
                                  DB::table('clients')->where('user_id', $member->id)->exists() ||
                                  DB::table('testimonials')->where('user_id', $member->id)->exists() ||
                                  DB::table('completed_projects')->where('user_id', $member->id)->exists();
    }

    return view('admin.memberlounge.member-lounge', compact('members', 'search'));
}




public function profile($id)
{
    // Fetch the member with an approved status
    $member = Members::where('approve_status', 1)->findOrFail($id);

    // Fetch products & services
    $products = DB::table('products')->where('user_id', $id)->get();
    $services = DB::table('services')->where('user_id', $id)->get();

    // Fetch clients from multiple tables
    $clients = DB::table('clients')->where('user_id', $id)->get()
        ->merge(DB::table('testimonials')->where('user_id', $id)->get())
        ->merge(DB::table('completed_projects')->where('user_id', $id)->get());

    // Fetch testimonials separately
    $testimonials = DB::table('testimonials')->where('user_id', $id)->get();

    // Fetch completed projects separately
    $completed_projects = DB::table('completed_projects')->where('user_id', $id)->get();

    return view('admin.memberlounge.member-profile', compact(
        'member', 'products', 'services', 'clients', 'testimonials', 'completed_projects'
    ));
}




public function deleteUser($id)
{
    // Find the user
    $user = Members::find($id);

    if (!$user) {
        return redirect()->back()->with('error', 'User not found.');
    }

    // Delete related records and their images
    $this->deleteImages(Testimonial::where('user_id', $id)->get(), 'testimonial_image');
    $this->deleteImages(CompletedProject::where('user_id', $id)->get(), 'project_image');
    $this->deleteImages(Service::where('user_id', $id)->get(), 'service_image');
    $this->deleteImages(Product::where('user_id', $id)->get(), 'product_image');

    // Delete related records
    Client::where('user_id', $id)->delete();
    Testimonial::where('user_id', $id)->delete();
    CompletedProject::where('user_id', $id)->delete();
    Service::where('user_id', $id)->delete();
    Product::where('user_id', $id)->delete();

    // Get vendor_registers associated with the user
    $vendors = VendorRegister::where('member_id', $id)->get();

    foreach ($vendors as $vendor) {
        // Fetch items linked to the vendor
        $items = Item::where('member_id', $id)->where('vendor_id', $vendor->id)->get();

        foreach ($items as $item) {
            // Delete item images from storage
            if ($item->product_image) {
                Storage::delete("storage/app/public/products/{$item->product_image}");
            }
            // Delete the item
            $item->delete();
        }

        // Delete vendor entry
        $vendor->delete();
    }

    // Delete user profile image if exists
    if ($user->profile_photo) {
        Storage::delete("storage/app/public/{$user->profile_photo}");
    }

    // Delete the user
    $user->delete();

    return redirect()->back()->with('delete_success', 'User and related data deleted successfully.');
}





private function deleteImages($records, $imageField)
{
    foreach ($records as $record) {
        if (!empty($record->$imageField)) {
            Storage::delete("public/{$record->$imageField}");
        }
    }
}


public function viewpayment()
{
    $currentDate = Carbon::now();

    $subscriptions = DB::table('subscriptions')
        ->join('members', 'subscriptions.member_id', '=', 'members.id')
        ->select(
            'subscriptions.member_id',
            DB::raw("CONCAT(members.first_name, ' ', members.last_name) as user_name"),
            'members.company_name',
            'members.designation',
            'members.location',
            DB::raw("CASE
                        WHEN COUNT(DISTINCT subscriptions.plan_type) > 1
                        THEN 'MP&MMP'
                        WHEN MAX(subscriptions.plan_type) = 'member_directory' THEN 'MP'
                        WHEN MAX(subscriptions.plan_type) = 'marketplace' THEN 'MMP'
                        ELSE MAX(subscriptions.plan_type)
                     END as plan_types"),
            DB::raw("MIN(subscriptions.start_date) as start_date"),
            DB::raw("MAX(subscriptions.end_date) as end_date"),
            DB::raw("SUM(subscriptions.duration) as duration"),
            DB::raw("SUM(subscriptions.amount) as total_amount"),
            DB::raw("CASE
                        WHEN SUM(subscriptions.payment_status = 'Paid') > 0 THEN 'Paid'
                        ELSE 'Unpaid'
                     END as payment_status")
        )
        ->where('subscriptions.end_date', '>=', $currentDate)
        ->groupBy('subscriptions.member_id', 'members.first_name', 'members.last_name', 'members.company_name', 'members.designation', 'members.location')
        ->orderByDesc('subscriptions.created_at') // Ordering by created_at in descending order
        ->get();

    return view('admin.payment.viewallpayment', compact('subscriptions'));
}








// AdminController.php
public function viewExpiringSubscriptions()
{
    // Get current date and calculate the date 5 days from now
    $dateThreshold = now()->addDays(5)->format('Y-m-d');

    // Fetch members whose subscriptions are expiring within the next 5 days along with company details
    $expiringSubscriptions = DB::table('subscriptions')
        ->join('members', 'subscriptions.member_id', '=', 'members.id') // Fix: Use 'member_id' instead of 'user_id'
        ->select(
            'subscriptions.amount as subscription_amount', // Fix: Use 'amount' instead of 'subscription_amount'
            'subscriptions.start_date',
            'subscriptions.end_date',
            'members.id as user_id',
            DB::raw("CONCAT(members.first_name, ' ', members.last_name) as user_name"),
            'members.company_name',
            'members.designation',
            'members.location'
        )
        ->where('subscriptions.end_date', '<=', $dateThreshold)
        ->where('subscriptions.end_date', '>=', now()->format('Y-m-d'))
        ->get();

    return view('admin.payment.renewpayment', compact('expiringSubscriptions'));
}

// Controller Method
public function sendRenewalNotification($userId)
{
    $user = DB::table('members')->where('id', $userId)->first();
    $subscription = DB::table('subscriptions')
        ->where('member_id', $userId)
        ->orderBy('end_date', 'desc')
        ->first();

    if ($user && $subscription) {
        $endDate = Carbon::parse($subscription->end_date)->format('d-m-Y');
        $message = "Your subscription is ending on {$endDate}. Please renew your subscription to continue accessing the member portal on or before {$endDate}. Log into the portal to make the payment.";

        Mail::raw($message, function ($mail) use ($user) {
            $mail->to($user->email)
                 ->subject('Subscription Renewal Notice');
        });

        return back()->with('success', 'Notification sent successfully.');
    }

    return back()->with('error', 'User or subscription not found.');
}

//hightlight (prime /non-prime)
public function togglePrimeMember(Request $request, $id)
{
    $member = Members::findOrFail($id);

    // Check if at least one product or service exists
    $hasProductOrService = $member->pro == 1 || $member->ser == 1;

    // Check if clients, testimonials, and completed projects exist
    $hasClients = $member->cli == 1;
    $hasTestimonials = $member->tem == 1;
    $hasCompletedProjects = $member->proj == 1;

    // Enable Prime Member only if all conditions are met
    if ($hasProductOrService && $hasClients && $hasTestimonials && $hasCompletedProjects) {
        $member->prime_member = $request->prime_member;
        $member->save();

        return response()->json([
            'success' => true,
            'prime_member' => $member->prime_member
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => "Member profile is incomplete. Prime Member status cannot be changed."
        ]);
    }
}


public function membersData()
{
    $members = DB::table('members')
        ->leftJoin('products', 'members.id', '=', 'products.user_id')
        ->leftJoin('services', 'members.id', '=', 'services.user_id')
        ->leftJoin('testimonials', 'members.id', '=', 'testimonials.user_id')
        ->leftJoin('clients', 'members.id', '=', 'clients.user_id')
        ->leftJoin('completed_projects', 'members.id', '=', 'completed_projects.user_id')
        ->leftJoin(DB::raw("(SELECT member_id, GROUP_CONCAT(DISTINCT plan_type ORDER BY plan_type SEPARATOR ', ') as plan_types FROM subscriptions GROUP BY member_id) as sub"), 'members.id', '=', 'sub.member_id') // Aggregate plan_types
        ->select(
            'members.id',
            'members.first_name',
            'members.last_name',
            'members.website',
            DB::raw('COUNT(DISTINCT products.id) as product_count'),
            DB::raw('COUNT(DISTINCT services.id) as service_count'),
            DB::raw('COUNT(DISTINCT testimonials.id) as testimonial_count'),
            DB::raw('COUNT(DISTINCT clients.id) as client_count'),
            DB::raw('COUNT(DISTINCT completed_projects.id) as completed_project_count'),
            DB::raw('IFNULL(sub.plan_types, "") as plan_types'), // Store plan types
            DB::raw("
                CASE
                    WHEN sub.plan_types LIKE '%member_directory%' AND sub.plan_types LIKE '%marketplace%' THEN 'MP&MMP'
                    WHEN sub.plan_types LIKE '%member_directory%' THEN 'MP'
                END as user_type
            "), // Determine user type (excluding Free Trial and MMP alone)
            DB::raw("
                CASE
                    WHEN sub.plan_types LIKE '%marketplace%' THEN 'Yes'
                    ELSE 'No'
                END as presence_in_marketplace
            ") // Display Yes if marketplace exists, otherwise No
        )
        ->where(function ($query) {
            $query->whereRaw("sub.plan_types LIKE '%member_directory%'"); // Only members with MP or MP&MMP
        })
        ->groupBy('members.id', 'members.first_name', 'members.last_name', 'members.website', 'sub.plan_types')
        ->orderByRaw("FIELD(user_type, 'MP&MMP', 'MP')") // Order results
        ->get();

    return view('admin.primereport', compact('members'));
}









public function showReferences(Request $request)
{
    // Filters
    $filterMonth = $request->input('month');
    $filterYear = $request->input('year');
    $filterTitle = $request->input('title');
    $filterTo = $request->input('reference_to');

    // Build base query
    $query = DB::table('member_references')
        ->join('members as ref_from', 'member_references.reference_from', '=', 'ref_from.id')
        ->join('members as ref_to', 'member_references.reference_to', '=', 'ref_to.id')
        ->select(
            'member_references.id as sno',
            DB::raw("CONCAT(ref_from.first_name, ' ', ref_from.last_name) as referred_by"),
            DB::raw("CONCAT(ref_to.first_name, ' ', ref_to.last_name) as referred_to"),
            'member_references.amount',
            'member_references.title',
            'member_references.details as reference_details',
            'member_references.date',
            
        );

    // Apply filters
    if ($filterMonth) {
        $query->whereMonth('member_references.date', Carbon::parse($filterMonth)->month);
    }
    if ($filterYear) {
        $query->whereYear('member_references.date', $filterYear);
    }
    if ($filterTitle) {
        $query->where('member_references.title', $filterTitle);
    }
    if ($filterTo) {
        $query->where(DB::raw("CONCAT(ref_to.first_name, ' ', ref_to.last_name)"), 'like', '%' . $filterTo . '%');
    }

    // Get filtered data
    $references = $query->orderBy('member_references.id', 'desc')->get();

    // Total amount
    $totalAmount = $references->sum('amount');

    // Dropdown filter data
    $allTitles = DB::table('member_references')->pluck('title')->unique();
    $allDates = DB::table('member_references')->pluck('date');
    $allMonths = $allDates->map(fn($d) => Carbon::parse($d)->format('F'))->unique();
    $allYears = $allDates->map(fn($d) => Carbon::parse($d)->format('Y'))->unique();
    $allRefTo = DB::table('members')->select(DB::raw("CONCAT(first_name, ' ', last_name) as name"))->pluck('name')->unique();

    return view('admin.report.refgivenreport', compact(
        'references',
        'totalAmount',
        'allTitles',
        'allMonths',
        'allYears',
        'allRefTo'
    ));
}

public function showThanksNotes(Request $request)
{
    $companyName = $request->input('company_name');
    $memberId = $request->input('member_id');

    // Fetch distinct company names for the filter dropdown
    $companies = DB::table('members')
        ->select('company_name')
        ->distinct()
        ->whereNotNull('company_name')
        ->get();

    // Fetch member list for the "Thanks Note From" filter
    $members = DB::table('members')
        ->select('id', 'first_name', 'last_name', 'profile_photo')
        ->get();

       


    // Build the thanks notes query
    $query = DB::table('member_thanksnote')
        ->join('members as source_member', 'member_thanksnote.source_member_id', '=', 'source_member.id')
        ->join('members as thanks_to', 'member_thanksnote.thanksnote_to', '=', 'thanks_to.id')
        ->select(
            'member_thanksnote.id as sno',
            DB::raw("CONCAT(source_member.first_name, ' ', source_member.last_name) as name"),
            DB::raw("CONCAT(thanks_to.first_name, ' ', thanks_to.last_name) as thanks_to"),
            'member_thanksnote.thanksnote_title',
            'member_thanksnote.thanksnote_amount',
            'member_thanksnote.date',
            'source_member.company_name',
            'source_member.profile_photo'
        )
        ->orderBy('member_thanksnote.id', 'desc');

    // Apply filters
    if (!empty($companyName)) {
        $query->where('source_member.company_name', $companyName);
    }

    if (!empty($memberId)) {
        $query->where('source_member.id', $memberId);
    }

    // Execute the query
    $thanksNotes = $query->get();

    // Calculate total amount
    $totalAmount = $thanksNotes->sum('thanksnote_amount');

    return view('admin.report.thanksreport', compact('thanksNotes', 'companies', 'members', 'totalAmount'));
}
public function thisWeekReference()
{
    // Get current date
    $today = Carbon::now();

    // Get last Saturday 12:00 AM
    $startOfWeek = $today->copy()->startOfWeek(Carbon::SATURDAY)->startOfDay();

    // Get this week's Friday 11:59 PM
    $endOfWeek = $startOfWeek->copy()->addDays(6)->endOfDay();

    // Query with custom week filter
    $data = DB::table('member_references as mr')
        ->select(
            'mr.id',
            'mr.date',
            'mr.reference_from',
            DB::raw("CONCAT(m_from.first_name, ' ', m_from.last_name) AS reference_by_name"),
            'm_from.company_name AS reference_by_company',
            'mr.reference_to',
            DB::raw("CONCAT(m_to.first_name, ' ', m_to.last_name) AS reference_to_name"),
            'm_to.company_name AS reference_to_company',
            'mr.amount'
        )
        ->leftJoin('members as m_from', 'm_from.id', '=', 'mr.reference_from')
        ->leftJoin('members as m_to', 'm_to.id', '=', 'mr.reference_to')
        ->whereBetween('mr.date', [$startOfWeek, $endOfWeek])
        ->orderBy('mr.date', 'DESC')
        ->get();

        return view('admin.report.thisweek', compact('data'));

}

}
