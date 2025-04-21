<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Banner;

class BannerController extends Controller
{
    /**
     * Display the banner upload form.
     */
    public function uploadForm()
    {
        // Pass banners to the view (only change here)
        $banners = Banner::orderBy('created_at', 'desc')->get();
        return view('homepage_settings.banner', compact('banners'));
    }

    public function showUploadForm()
    {
        return view('banner.upload');
    }

    /**
     * Handle the banner image upload and store it in the database.
     */
    public function upload(Request $request)
    {
        // Validate the images
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Loop through each uploaded file and store it
        foreach ($request->file('images') as $image) {
            // Store each image in the "public/banners" directory
            $imagePath = $image->store('banners', 'public');
    
            // Save each image path to the database
            Banner::create([
                'image_path' => $imagePath,
                'user_id' => auth()->id(), // Store the authenticated user's ID
            ]);
        }
    
        return redirect()->route('banner.uploadForm')->with('success', 'Banner images uploaded successfully!');
    }
    

    /**
     * Show the uploaded banners in the admin panel.
     */
     public function show()
    {
        $user = auth()->user(); // Get the authenticated user
    
        $query = Banner::orderBy('created_at', 'desc');
    
        // If the user is NOT a super admin, filter by user_id
        if ($user->role_id != 1) {
            $query->where('user_id', $user->id);
        }
    
        $banners = $query->get();
    
        return view('homepage_settings.banner', compact('banners'));
    }
    

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('homepage_settings.edit', compact('banner'));
    }

    /**
     * Update the banner in the database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $banner = Banner::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete the old image
            Storage::delete('public/' . $banner->image_path);

            // Store the new image
            $imagePath = $request->file('image')->store('banners', 'public');
            $banner->image_path = $imagePath;
        }

        $banner->save();

        return redirect()->route('homepage_settings.banner')->with('success', 'Banner updated successfully!');

    }

    /**
     * Delete the banner from the database.
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        // Delete the image from the storage
        Storage::delete('public/' . $banner->image_path);

        // Delete the banner record from the database
        $banner->delete();

        return redirect()->route('homepage_settings.banner')->with('success', 'Banner deleted successfully!');
    }

    public function index()
{
    // Fetch banners from the database
    $banners = Banner::orderBy('created_at', 'desc')->get();

    // Pass banners to the view
    return view('index', compact('banners'));
}


}
