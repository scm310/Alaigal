<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListingBanner;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ListingBannerController extends Controller
{
    // Display all listing banners
    public function index(Request $request)
    {
        $banners = ListingBanner::with('category')->get();
        $categories = Category::all();
      
    
        // Check if edit_id exists
        $editBanner = null;
        if ($request->has('edit_id')) {
            $editBanner = ListingBanner::find($request->edit_id);
        }
    
        return view('homepage_settings.listingbanner', compact('banners', 'categories', 'editBanner'));
    }
    

    // Show form to create a new banner
    public function create()
    {
        $categories = Category::all();
        return view('homepage_settings.create_banner', compact('categories'));
    }

    // Store new banner
    public function store(Request $request)
    {
        $request->validate([
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'category_id' => 'required|exists:category,Category_id',
        ]);
    
        // Check if a banner already exists for the selected category
        $existingBanner = ListingBanner::where('category_id', $request->category_id)->first();
        if ($existingBanner) {
            return back()->withErrors(['category_id' => 'A banner already exists for this category.']);
        }
    
        // Upload the banner image
        if ($request->hasFile('banner_image')) {
            $imagePath = $request->file('banner_image')->store('banners', 'public');
        }
    
        // Create the new banner
        ListingBanner::create([
            'banner_image' => $imagePath ?? null,
            'category_id' => $request->category_id,
        ]);
    
        return redirect()->route('listingbanners.index')->with('success', 'Banner created successfully!');
    }
    

    // Show form to edit a banner
    public function edit($id)
    {
        $banner = ListingBanner::findOrFail($id);
        $categories = Category::all();
        return view('homepage_settings.edit_banner', compact('banner', 'categories'));
    }

    // Update the banner
    public function update(Request $request, $id)
    {
        $banner = ListingBanner::findOrFail($id);
    
        $request->validate([
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:category,Category_id',
        ]);
    
        if ($request->hasFile('banner_image')) {
            if ($banner->banner_image) {
                Storage::delete('public/' . $banner->banner_image);
            }
            $imagePath = $request->file('banner_image')->store('banners', 'public');
            $banner->banner_image = $imagePath;
        }
    
        $banner->category_id = $request->category_id;
        $banner->save();
    
        return redirect()->route('listingbanners.index')->with('success', 'Banner updated successfully!');
    }
    

    // Delete the banner
    public function destroy($id)
    {
        $banner = ListingBanner::findOrFail($id);
    
        if ($banner->banner_image) {
            Storage::delete('public/' . $banner->banner_image);
        }
    
        $banner->delete();
    
        return redirect()->route('listingbanners.index')->with('success', 'Banner deleted successfully!');
    }
    
}
