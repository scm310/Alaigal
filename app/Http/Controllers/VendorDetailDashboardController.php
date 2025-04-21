<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CustomerSupport;
use App\Models\VendorDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class VendorDetailDashboardController extends Controller
{
    /**
     * Display the Vendor Details.
     */
    public function show($id)
    {
        // Fetch vendor details by ID
        $vendor = VendorDetail::find($id);
        
        // If vendor not found, redirect with an error message
        if (!$vendor) {
            return redirect()->route('vendorlogin.auth.dashboard')->with('error', 'Vendor details not found.');
        }

        // Return the view with vendor data
        return view('vendorlogin.auth.vendordetails', compact('vendor'));
    }

    /**
     * Update Vendor Details.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'vendor_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:15',
            'company_name' => 'required|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Added validation for profile photo
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zipcode' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
        ]);
    
        // Find the vendor by ID
        $vendor = VendorDetail::findOrFail($id);
    
        // Update vendor details
        $vendor->vendor_name = $request->vendor_name;
        $vendor->email = $request->email;
        $vendor->phone_number = $request->phone_number;
        $vendor->company_name = $request->company_name;
        $vendor->address = $request->address;
        $vendor->city = $request->city;
        $vendor->state = $request->state;
        $vendor->zipcode = $request->zipcode;
        $vendor->country = $request->country;
    
        // Handle company logo upload if provided
        if ($request->hasFile('company_logo')) {
            // Delete old company logo if it exists
            if ($vendor->company_logo) {
                Storage::delete('public/company_logos/' . $vendor->company_logo);
            }
            // Store the new company logo
            $imagePath = $request->file('company_logo')->store('public/company_logos');
            $vendor->company_logo = basename($imagePath);
        }
    
        // Handle profile photo upload if provided
        if ($request->hasFile('profile_photo')) {
            // Delete old profile photo if it exists
            if ($vendor->profile_photo) {
                Storage::delete('public/vendor_photos/' . $vendor->profile_photo);
            }
    
            // Store the new profile photo in the vendor_photos directory
            $profilePhotoPath = $request->file('profile_photo')->storeAs(
                'public/vendor_photos', 
                $vendor->id . '_' . $request->file('profile_photo')->getClientOriginalName()
            );
            $vendor->profile_photo = basename($profilePhotoPath);
        }
    
        // Save the updated vendor information
        $vendor->save();
    
        // Redirect back to the vendor edit page with a success message
        return redirect()->back()->with('success', 'Vendor details updated successfully!');
    }

    

    public function getNotificationCount()
    {
        // Get the authenticated vendor ID
        $vendorId = Auth::guard('vendor')->id();
    
        // Count the notifications for this specific vendor
        $count = CustomerSupport::where('vendor_id', $vendorId)
            ->where('status', 'closed') // Count only closed notifications
            ->count();
    
        return response()->json(['count' => $count]);
    }

    // Fetch notifications (closed requests)
    public function getNotifications()
    {
        // Get the authenticated vendor ID
        $vendorId = Auth::guard('vendor')->id();
    
        // Fetch notifications for this specific vendor
        $messages = CustomerSupport::where('status', 'closed')
            ->where('vendor_id', $vendorId) // Filter by vendor_id
            ->get(['id', 'message']);
    
        return response()->json(['messages' => $messages]);
    }
    
    public function markNotificationAsRead($id)
    {
        $notification = CustomerSupport::find($id);
        if ($notification) {
            $notification->delete(); // Remove notification from DB
            return response()->json(['success' => true, 'message' => 'Notification removed successfully.']);
        } else {
            return response()->json(['success' => false, 'error' => 'Notification not found.'], 404);
        }
    }
    

   }


