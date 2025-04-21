<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer; // Make sure to import your Customer model
use App\Models\CustomerSupport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Import Auth facade

class CustomerSupportController extends Controller
{


    

    
    public function store(Request $request)
    {
        // Validate input fields
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:250',
        ]);
    
        // Ensure the user is authenticated via the vendor guard
        $vendor = Auth::guard('vendor')->user();
        if (!$vendor) {
            return redirect()->back()->with('error', 'Unauthorized Access! Please log in as a vendor.');
        }
    
        // Store the support message with the authenticated vendor's ID
        CustomerSupport::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'vendor_id' => $vendor->id, // Authenticated vendor's ID
            'status' => 'pending',
        ]);
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
    
    
    
    public function showVendorRequests()
    {
        $vendorRequests = DB::table('customer_support')
            ->orderBy('created_at', 'DESC') // Order by created_at in descending order
            ->get();
    
        return view('homepage_settings.vendor_request', compact('vendorRequests'));
    }
    


      // Change status to "Closed"
      public function close($id)
      {
          $vendorRequest = CustomerSupport::findOrFail($id);
          $vendorRequest->status = 'closed';
          $vendorRequest->save();
  
          return redirect()->back()->with('success', 'Vendor request closed successfully');
      }
  
      // Delete a vendor request
      public function destroy($id)
      {
          $vendorRequest = CustomerSupport::findOrFail($id);
          $vendorRequest->delete();
  
          return redirect()->back()->with('success', 'Vendor request deleted successfully');
      }

}

