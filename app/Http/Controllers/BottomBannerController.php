<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BottomBanner;
use App\Models\BottomBanner1;
use Illuminate\Support\Facades\Storage;

class BottomBannerController extends Controller
{
    public function index()
    {
        $banners = BottomBanner::all();
        return view('homepage_settings.bottom_banners', compact('banners'));
    }


      public function show() {
        $banners2 = BottomBanner1::all();
        return view('homepage_settings.bottom_banner1', compact('banners2'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Store image in 'public/bottom_banners' directory
        $imagePath = $request->file('image')->store('bottom_banners', 'public');

        // Save to database
        BottomBanner::create(['image' => $imagePath]);

        return redirect()->route('bottom_banners.index')->with('success', 'Bottom Banner added successfully!');
    }
    
    public function destroy($id)
    {
        $banner = BottomBanner::findOrFail($id);

        // Delete image from storage
        Storage::disk('public')->delete($banner->image);

        // Delete from database
        $banner->delete();

        return redirect()->route('bottom_banners.index');
    }





  

    public function create() {
        return view('homepage_settings.bottom_banner1');
    }
    public function save(Request $request) {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($request->hasFile('image')) {
            // Generate a unique image name
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
    
            // Store the image in storage/app/public/bottombanner1 directory
            $request->image->storeAs('public/bottombanner1', $imageName);
    
            // Save only the image name in the database
            BottomBanner1::create([
                'image' => $imageName, // Storing only the image name
            ]);
    
            return redirect()->route('bottom_banners1.show')->with('success', 'Banner added successfully!');
        }
    
        return back()->with('error', 'Image upload failed.');
    }
    

    public function delete($id)
{
    $banner = BottomBanner1::findOrFail($id);

    // Delete the image file from storage
    if ($banner->image) {
        Storage::delete(str_replace('storage/', 'public/', $banner->image));
    }

    // Delete the banner from the database
    $banner->delete();

    return redirect()->route('bottom_banners1.show')->with('success', 'Banner deleted successfully!');
}
    
}

