<?php

namespace App\Http\Controllers;

use App\Models\ClientTestimonial;
use App\Models\HeaderSetting;
use App\Models\LoginBanner;
use App\Models\Members;
use App\Models\Subscription;
use App\Models\VendorRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
      
        return view('auth.login');

       
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // Check if "Remember Me" is checked
    
        if (Auth::guard('web')->attempt($credentials, $remember)) {
            return redirect()->intended('dashboard'); // Redirect to intended page
        }
    
        return redirect()->back()->withErrors([
            'email' => 'Invalid email or password.',
        ]);
    }
    

    public function logout(Request $request)
    {
        Auth::guard('web')->logout(); // Only logout users under 'web' guard
    
        // Invalidate the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect()->route('user.login')->with('success', 'Logged out successfully.');
    }
    



        public function index()
        {
            // Fetch all banners to display in the carousel
            $banners = LoginBanner::all();
        
            // Fetch the latest header settings (logo and title)
            $headerSettings = HeaderSetting::latest()->first(); // Get the most recent header setting
        
            // Pass banners and header settings to the view
            return view('home', compact('banners', 'headerSettings'));
        }
    
// Update on 18-02-2025 Divya (for free trial function)
public function loginSubmit(Request $request)
{
    // Validate input
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Attempt login for MEMBERS only
    if (Auth::guard('member')->attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember'))) {
        $member = Auth::guard('member')->user();

        // Check if the account is approved
        if ($member->approve_status == 0) {
            Auth::guard('member')->logout();
            return redirect()->route('memberlogin')->withErrors(['email' => 'Your account is not approved yet.']);
        }

        // Check if the profile is updated
        if ($member->profile_update == 0) {
            return redirect()->route('profile.edit'); // Redirect to Profile Edit first
        }

        // Fetch subscription details
        $subscription = Subscription::where('member_id', $member->id)->first();

        // Check payment status
        if ($subscription && $subscription->payment_status == 1) {
            return redirect()->route('memberdashboard'); // Redirect to Dashboard
        } else {
            return redirect()->route('subscription.payment'); // Redirect to Payment Page
        }
    }

    // Authentication failed
    return redirect()->route('memberlogin')->withErrors(['email' => 'Invalid credentials. Please try again.'])->withInput();
}




       
    
        
    
        // Show the dashboard (after login)
        public function dashboard()
        {
            return view('dashboard');  // Assuming you have a dashboard view
        }
    
    
        public function showRegisterForm()
        {
            $headerSetting = HeaderSetting::first(); 
            
            // Fetch the first record
            $testimonials = ClientTestimonial::all();

            return view('auth.register', compact('headerSetting','testimonials'));
        }
    
        // Handle the registration form submission
    
        
    
     
        public function memberregister(Request $request)
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
                $errors = $validator->errors();
        
                // Reset email/phone if already registered
                $inputData = $request->all();
                if ($errors->has('email')) {
                    $inputData['email'] = ''; 
                }
                if ($errors->has('phone_number')) {
                    $inputData['phone_number'] = ''; 
                }
        
                return redirect()->back()
                    ->withErrors($errors)
                    ->withInput($inputData);
            }
        
            // Convert first_name, last_name, and company_name to Pascal Case
            $first_name = ucwords(strtolower($request->first_name));
            $last_name = ucwords(strtolower($request->last_name));
            $company_name = ucwords(strtolower($request->company_name));
        
            // Store data in the members table
            $member = Members::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'company_name' => $company_name,
                'location' => $request->location,
                'designation' => $request->designation,
                'password' => bcrypt('1234'),
                'approve_status' => 0, // Not approved yet
                'payment' => 0,
            ]);
        
            // Store data in the vendor_registers table
            VendorRegister::create([
                'member_id' => $member->id, // Store the member ID
                'name' => $first_name . ' ' . $last_name,
                'company_name' => $company_name,
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
        
            return redirect()->route('memberregister')->with('success', 'You will receive the login credentials after the admin approval.');
        }
        
        
        
        
        
        
        
        
        public function memberlogout(Request $request)
        {
            // Log out only the member
            Auth::guard('member')->logout();
        
            // Invalidate the session
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        
            return redirect()->route('memberlogin')->with('message', 'You have been successfully logged out.');
        }

        
        
    
}
