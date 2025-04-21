<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomepageBanner;
use Illuminate\Support\Facades\Storage;

class HomepageBannerController extends Controller
{
    /**
     * Display all banners.
     */
    public function index()
    {
        $banners = HomepageBanner::all(); // Fetching banners from DB
        return view('homepage_settings.homepage_banners', compact('banners'));
    }

    /**
     * Store a newly uploaded banner.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($request->hasFile('image')) {
            // Store the image in "public/homepagebanners" directory
            $path = $request->file('image')->store('public/homepagebanners');
    
            // Remove "public/" prefix to make it accessible via storage link
            $path = str_replace('public/', '', $path);
    
            HomepageBanner::create(['image_path' => $path]);
    
            return redirect()->route('homepagebanners.index')->with('success', 'Banner uploaded successfully.');
        }
    
        return back()->with('error', 'Banner upload failed.');
    }

    /**
     * Show the form for editing a banner.
     */
    public function edit($id)
    {
        $banner = HomepageBanner::findOrFail($id);
        return view('edit_homepage_banner', compact('banner'));
    }

    /**
     * Update an existing banner.
     */
    public function update(Request $request, $id)
    {
        $banner = HomepageBanner::findOrFail($id);
    
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($request->hasFile('image')) {
            // Delete old image if exists
            Storage::delete('public/' . $banner->image_path);
    
            // Upload new image to "homepagebanners" folder
            $path = $request->file('image')->store('public/homepagebanners');
            $path = str_replace('public/', '', $path);
    
            // Update banner record
            $banner->update(['image_path' => $path]);
    
            return redirect()->route('homepagebanners.index')->with('success', 'Banner updated successfully.');
        }
    
        return back()->with('error', 'Update failed.');
    }
    

    /**
     * Delete a banner.
     */
    public function destroy($id)
    {
        $banner = HomepageBanner::findOrFail($id);

        // Delete image from storage
        Storage::disk('public')->delete($banner->image_path);

        $banner->delete();

        return redirect()->route('homepagebanners.index')->with('success', 'Banner deleted successfully.');
    }
}
