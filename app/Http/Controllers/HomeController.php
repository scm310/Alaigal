<?php

namespace App\Http\Controllers;

use App\Models\CompletedProject;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\Client;
use App\Models\Item;
use App\Models\Member;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    
    public function index()
    {
        // Fetch all advertisements
        $advertisements = Advertisement::all();
        $favicon = DB::table('favicons')->latest()->first(); // Fetch the latest favicon entry
        return view('home', compact('advertisements','favicon'));
    }

 
    public function memberdashboard()
    {
        $loggedInUserId = auth('member')->id(); // Get the logged-in member's ID
    
        $memberCount = Member::where('payment', 1)->count();

        $clientCount = Client::count();
        $productCount = Product::count();
        $serviceCount = Service::count(); // Fetch total count of services
    
        // Fetch logged-in member details
        $member = Member::where('id', $loggedInUserId)->first();
        $isPrimeMember = $member && $member->prime_member == 1;
        $showPrimePopup = $isPrimeMember && $member->prime_popup_shown == 0;
    
        // Fetch subscription status
        $hasPaidSubscription = DB::table('subscriptions')
            ->where('member_id', $loggedInUserId)
            ->where('payment_status', 1)
            ->exists();
    
        // Fetch free trial end date only if payment_status is NOT 1
        $freeTrialEndDate = (!$hasPaidSubscription && $member) ? $member->free_trial_end_date : null;
    
        // Check if trial period expired
        $trialExpired = $freeTrialEndDate && \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($freeTrialEndDate));
    
        // Fetch existing notifications
        $productNotifications = Product::join('members', 'products.user_id', '=', 'members.id')
            ->where('products.user_id', '!=', $loggedInUserId)
            ->select('products.id', 'products.product_name', 'members.first_name as member_name', 'products.created_at', DB::raw('"product" as type'))
            ->orderBy('products.created_at', 'DESC')
            ->get();
    
        $serviceNotifications = Service::join('members', 'services.user_id', '=', 'members.id')
            ->where('services.user_id', '!=', $loggedInUserId)
            ->select('services.id', 'services.service_name', 'members.first_name as user_name', 'services.created_at', DB::raw('"service" as type'))
            ->orderBy('services.created_at', 'DESC')
            ->get();
    
        $testimonialNotifications = Testimonial::join('members', 'testimonials.user_id', '=', 'members.id')
            ->where('testimonials.user_id', '!=', $loggedInUserId)
            ->select('testimonials.id', 'testimonials.client_name', 'members.first_name as user_name', 'testimonials.created_at', DB::raw('"testimonial" as type'))
            ->orderBy('testimonials.created_at', 'DESC')
            ->get();
    
        $clientNotifications = Client::join('members', 'clients.user_id', '=', 'members.id')
            ->where('clients.user_id', '!=', $loggedInUserId)
            ->select('clients.id', 'clients.client_name', 'clients.company_name', 'members.first_name as user_name', 'clients.created_at', DB::raw('"client" as type'))
            ->orderBy('clients.created_at', 'DESC')
            ->get();
    
            $newMemberNotifications = Member::where('profile_update', 1)
            ->where('payment', 1)
            ->where('id', '!=', $loggedInUserId)
            ->select('id', 'first_name', 'last_name', 'created_at', DB::raw('"new_member" as type'))
            ->orderBy('created_at', 'DESC')
            ->get();
        
    
        $completedProjectNotifications = CompletedProject::join('members', 'completed_projects.user_id', '=', 'members.id')
            ->where('completed_projects.user_id', '!=', $loggedInUserId)
            ->select('completed_projects.id', 'completed_projects.project_name', 'completed_projects.client_name', 'completed_projects.company_name', 'members.first_name as user_name', 'completed_projects.updated_at', DB::raw('"completed_project" as type'))
            ->orderBy('completed_projects.updated_at', 'DESC')
            ->get();
    
        // Fetch Hot-Selling Products Notifications
        $hotSellingProducts = Item::join('add_highlight', function ($join) {
            $join->on(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(items.add_highlight, "$[0]"))'), '=', 'add_highlight.id');
        })
        ->join('members', 'items.member_id', '=', 'members.id')
        ->where('add_highlight.name', 'Top - Selling Products')
        ->select(
            'items.id', 
            'items.name as item_name', 
            'items.member_id', 
            'items.created_at', 
            'members.first_name as seller_name', 
            DB::raw('"hot_selling" as type')
        )
        ->orderBy('items.updated_at', 'DESC')
        ->get();
        
    
    
        // Merge all notifications
        $notifications = $productNotifications
            ->merge($serviceNotifications)
            ->merge($testimonialNotifications)
            ->merge($clientNotifications)
            ->merge($newMemberNotifications)
            ->merge($completedProjectNotifications)
            ->merge($hotSellingProducts)
            ->sortByDesc('created_at');
    
        return view('members.dashboard', compact(
            'memberCount', 'clientCount', 'productCount', 'serviceCount',
            'notifications', 'showPrimePopup', 'loggedInUserId', 'freeTrialEndDate', 'trialExpired'
        ));
    }
    
    
    
    
    
    
    
    public function updatePrimePopup(Request $request)
{
    $userId = $request->input('user_id');

    Member::where('id', $userId)->update(['prime_popup_shown' => 1]);

    return response()->json(['message' => 'Popup status updated successfully']);
}

    
    
    
      
    
    

    
    




}
