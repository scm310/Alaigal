<?php

namespace App\Http\Controllers;

use App\Models\ClientTestimonial;
use App\Models\VendorDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class VendorAuthController extends Controller
{
    // Show the vendor login form



    public function dashboard()
    {
        // Ensure the user is authenticated
        if (Auth::guard('vendor')->check()) {
            // Return the dashboard view with the vendor details
            return view('vendorlogin.auth.dashboard');
        } else {
            // Redirect to login page if not authenticated
            return redirect()->route('vendorlogin.auth.login')->with('error', 'Please login to access the dashboard.');
        }
    }
    public function showLoginForm()
    {
        $testimonials = ClientTestimonial::all();

        return view('vendorlogin.auth.login',compact('testimonials'));
    }

    // Handle vendor login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
           
        ]);
    
        if (Auth::guard('vendor')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('vendorlogin.auth.dashboard')->with('success', 'Welcome to your Vendor Dashboard!');
        }
    
        return back()->withErrors(['email' => 'Invalid login credentials.']);
    }
    
    


    // Log the vendor out
    public function logout()
    {
        Auth::logout();
        return redirect()->route('vendor.login');
    }
}
