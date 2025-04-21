<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FooterSetting;

class FooterSettingController extends Controller
{
    // Show the form for editing the footer settings
    // public function index()
    // {
    //     // Retrieve the first record from the 'footersetting' table
    //     $footerSetting = FooterSetting::first(); // Get the first row
    //     return view('General_Settings.view', compact('footerSetting')); // Pass 'footerSetting' to the view
    // }
    

    public function show()
    {
        $footerSetting = FooterSetting::first(); // Get the first row
       
        return view('General_Settings.footer',compact('footerSetting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'address1' => 'nullable|string|max:255',
            'address2' => 'nullable|string|max:255',
            'privacy_policy' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'color_code' => 'nullable|string|max:7', // For color code like #ffffff
            'copyright_text' => 'nullable|string|max:255',
            'design_by' => 'nullable|string|max:255',
        ]);

        $footerSetting = FooterSetting::first() ?? new FooterSetting(); // Check if a footer setting exists or create a new one

        $footerSetting->update($request->all()); // Update the footer settings

        return redirect()->route('footer.show')->with('success', 'Footer settings updated successfully!');
    }
}