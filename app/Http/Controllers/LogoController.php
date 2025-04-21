<?php

namespace App\Http\Controllers;

use App\Models\Logo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    public function index()
    {
        $logos = Logo::all();
        return view('General_Settings.Logo_management', compact('logos'));
    }


public function storeLogo(Request $request)
{
    // Validate the uploaded file
    $request->validate([
        'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Check if the user is authenticated
    if (!Auth::check()) {
        return redirect()->back()->with('error', 'You must be logged in to upload a logo.');
    }

    // Store the uploaded logo in 'public/logos' folder
    $path = $request->file('logo')->store('logos', 'public');

    // Retrieve the existing logo record for the authenticated user
    $logo = Logo::where('user_id', Auth::id())->first();

    if ($logo) {
        // Delete the old logo file if it exists before updating
        if ($logo->logo_path && Storage::disk('public')->exists($logo->logo_path)) {
            Storage::disk('public')->delete($logo->logo_path);
        }

        // Update the existing logo
        $logo->update(['logo_path' => $path]);
    } else {
        // Create a new logo record if one doesn't exist
        Logo::create([
            'logo_path' => $path,
            'user_id' => Auth::id(),
        ]);
    }

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Logo uploaded successfully!');
}


    public function storeFavicon(Request $request)
    {
        $request->validate([
            'favicon' => 'required|image|mimes:ico,jpeg,png|max:1024',
        ]);

        // Store the uploaded favicon
        $path = $request->file('favicon')->store('favicons', 'public');

        // Check if a favicon already exists for the authenticated user
        $logo = Logo::where('user_id', Auth::id())->first();

        if ($logo) {
            $logo->update(['favicon' => $path]);
        } else {
            Logo::create([
                'favicon' => $path,
                'user_id' => Auth::id(),
            ]);
        }

        return redirect()->back()->with('success', 'Favicon uploaded successfully!');
    }

    public function updateHeading(Request $request, $id)
    {
        $request->validate([
            'heading' => 'required|string|max:255',
        ]);

        $logo = Logo::findOrFail($id);
        $logo->heading = $request->input('heading');
        $logo->save();

        return redirect()->back()->with('success', 'Heading updated successfully!');
    }

    /**
     * Store Admin Name and Admin Logo
     */
/**
 * Store or update Admin Name
 */
public function storeAdminName(Request $request)
{
    $request->validate([
        'admin_name' => 'required|string|max:255',
    ]);

    $logo = Logo::where('user_id', Auth::id())->first();

    if ($logo) {
        $logo->update(['admin_name' => $request->admin_name]);
    } else {
        Logo::create([
            'admin_name' => $request->admin_name,
            'user_id' => Auth::id(),
        ]);
    }

    return redirect()->back()->with('success', 'Admin Name updated successfully!');
}

/**
 * Store or update Admin Logo
 */
public function storeAdminLogo(Request $request)
{
    $request->validate([
        'admin_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $path = $request->file('admin_logo')->store('admin_logos', 'public');

    $logo = Logo::where('user_id', Auth::id())->first();

    if ($logo) {
        $logo->update(['admin_logo' => $path]);
    } else {
        Logo::create([
            'admin_logo' => $path,
            'user_id' => Auth::id(),
        ]);
    }

    return redirect()->back()->with('success', 'Admin Logo updated successfully!');
}

}
