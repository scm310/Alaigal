<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\CustomerEnquiry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;





class RegisterController extends Controller
{

    public function register(Request $request)
{
    // Validate the request
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:customer_enquiries,email',
        'phone' => 'required|digits:10|unique:customer_enquiries,phone',
        'password' => 'required|confirmed|min:8',
        'company' => 'nullable|string',
        'location' => 'nullable|string'
    ]);
 
    // If validation fails, return an error
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }
    //dd("djhd");


    $customer = CustomerEnquiry::create([
        'user_name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'company_name' => $request->company,
        'location' => $request->location,
        'password' => Hash::make($request->password),
    ]);

    // Optionally, log the user in
    auth()->login($customer);

 
// Check the logged-in user details


    // Flash success message to the session
    session()->flash('success', 'Registration successful, you are now logged in!');

    // Return back to the same page (without redirecting to a different route)
    return redirect()->back();
}

    
    
    
    
// Login method in your RegisterController
public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // Authentication passed...
        return redirect()->intended('dashboard'); // or whatever route you want
    }

    return back()->withErrors(['email' => 'Invalid credentials']);
}


    


public function addToCart(Request $request)
    {
        // Handle adding the item to the cart
        // You can use the data from $request to add the product to the cart

        // Return a response (you can customize this as needed)
        return response()->json(['success' => true]);
    }
    
    
}

