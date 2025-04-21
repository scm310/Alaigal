<?php
// app/Http/Controllers/EnquiryController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduledEnquiry;

class EnquiryController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|regex:/^\+?[0-9]{7,15}$/',
            'message' => 'required|string',
        ]);
    
        // Ensure the model is correctly referenced
        $enquiry = new \App\Models\ScheduledEnquiry();
        $enquiry->name = $request->input('name');
        $enquiry->email = $request->input('email');
        $enquiry->phone = $request->input('phone');
        $enquiry->message = $request->input('message');
        $enquiry->save();
    
        // Redirect with a success message
        return redirect()->back()->with('success', 'Your enquiry has been submitted successfully!');
    }
    

   public function scheduleCall()
    {
        $user = auth()->user(); 
    
        $query = ScheduledEnquiry::orderBy('created_at', 'desc');
    
    
        if ($user->role_id != 1) {
            $query->where('user_id', $user->id);
        }
    
        $enquiries = $query->get();
    
        return view('Enquiry management.schedulecall', compact('enquiries'));
    }
}
