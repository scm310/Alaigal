<?php

namespace App\Http\Controllers;

use App\Models\CustomerSupport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\VendorRegister;  // Correctly import the VendorRegister model


use App\Models\Item;
use Carbon\Carbon;
use App\Models\VendorDetail;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Fetch the total number of products
        $totalProducts = Item::count();
    
        // Fetch the total number of vendors from the vendor_registers table
        $totalVendors = VendorRegister::count(); // This is correct as the model already uses vendor_registers table
    
        // Existing variables and logic
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
    
        $newVendorProductsCount = Item::where('status', 'vendor')->count();
    
        // Set the session variable for new vendor products notifications
        $newVendorProductSeen = session('new_vendor_product_seen', false); // false means not seen yet
        if ($newVendorProductsCount > 0 && !$newVendorProductSeen) {
            // Notification exists and hasn't been seen
            session(['new_vendor_product_seen' => false]);
        }
    
        // Get the edited vendor product count from the session
        $newVendorProductEditedCount = session('new_vendor_product_edited_count', 0);
        $customerSupportCount = DB::table('customer_support')->count();
    
        // Return view with data
        return view('dashboard', compact(
            'totalProducts', // Pass the totalProducts variable to the view
            'totalVendors', // Pass the totalVendors variable to the view
            'newVendorProductsCount',
            'newVendorProductEditedCount',
            'customerSupportCount',
            'newVendorProductSeen' // Pass the notification status to the view
        ));
    }
    







    //notification card function
    public function markVendorProductsAsSeen()
    {
        // Mark the session as seen for new vendor products
        session(['new_vendor_product_seen' => true]);

        // Redirect to the dashboard or any other page
        return redirect()->route('dashboard');
    }



    public function getNotifications()
    {
        $pendingCount = CustomerSupport::where('status', 'pending')->count();
        return response()->json(['count' => $pendingCount]);
    }

    // Fetch pending messages
    public function getPendingMessages()
    {
        $pendingMessages = CustomerSupport::where('status', 'pending')->get();
        return response()->json($pendingMessages);
    }




}
