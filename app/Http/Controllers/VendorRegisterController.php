<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendorRegister;
use App\Mail\VendorApprovalMail;
use App\Models\Members;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class VendorRegisterController extends Controller
{
// Store vendor data
public function websitememberregister(Request $request)
{
    $validator = Validator::make($request->all(), [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:members,email|unique:vendor_registers,email',
        'phone_number' => 'required|numeric|digits:10|unique:members,phone_number|unique:vendor_registers,phone',
        'company_name' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'designation' => 'required|string|max:255',
    ], [
        'email.unique' => 'This email is already registered.',
        'phone_number.unique' => 'This phone number is already registered.',
        'phone_number.digits' => 'The phone number must be exactly 10 digits.',
        'phone_number.numeric' => 'The phone number must contain only numbers.',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput($request->except(['email', 'phone_number']));
    }

    $member = Members::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'phone_number' => $request->phone_number,
        'company_name' => $request->company_name,
        'location' => $request->location,
        'designation' => $request->designation,
        'password' => bcrypt('1234'),
        'approve_status' => 0,
        'payment' => 0,
    ]);

    VendorRegister::create([
        'member_id' => $member->id,
        'name' => $request->first_name . ' ' . $request->last_name,
        'company_name' => $request->company_name,
        'company_website' => '',
        'email' => $request->email,
        'phone' => $request->phone_number,
        'gst_number' => null,
        'status' => 0,
        'password' => bcrypt('1234'),
        'city' => '',
        'state' => '',
        'country' => '',
        'postal_code' => '',
        'vendor_type' => '',
    ]);

    return redirect()->back()->with('success', 'You will receive the login credentials after the admin approval.');
}



    
    public function index()
    {
        // Fetch all vendor records ordered by name in descending order
        $vendors = VendorRegister::orderBy('name', 'DESC')->get();
    
        // Pass data to the Blade file
        return view('Approval.index', compact('vendors'));
    }
    


    public function update(Request $request, $id)
{
    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'company_name' => 'nullable|string|max:255',
        'address' => 'nullable|string',
        'city' => 'nullable|string|max:100',
        'state' => 'nullable|string|max:100',
        'postal_code' => 'nullable|string|max:20',
        'country' => 'nullable|string|max:100',
        'gst_number' => 'nullable|string|max:50',
    ]);

    // Find vendor by ID
    $vendor = VendorRegister::findOrFail($id);

    // Update vendor details
    $vendor->update([
        'name' => $request->name,
        'phone' => $request->phone,
        'company_name' => $request->company_name,
        'address' => $request->address,
        'city' => $request->city,
        'state' => $request->state,
        'postal_code' => $request->postal_code,
        'country' => $request->country,
        'gst_number' => $request->gst_number,
    ]);

    // Redirect with success message
    return redirect()->back()->with('success', 'Vendor details updated successfully!');
}
  
}
