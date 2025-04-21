<?php

namespace App\Http\Controllers;

use App\Models\CustomerBanner; // Use correct model

class CustomerController extends Controller
{
    public function customer()
    {
        $banners = CustomerBanner::all(); // Fetch all images from customer_banner table
        return view('customersupport', compact('banners'));
    }
}
