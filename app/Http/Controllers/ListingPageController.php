<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Models\ListingPage;
use Illuminate\Support\Facades\Storage;

class ListingPageController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Get the authenticated user
    
        // Start query
        $query = ListingPage::orderBy('created_at', 'desc');
    
        // If the user is NOT a super admin, filter by user_id
        if ($user->role_id != 1) {
            $query->where('user_id', $user->id);
        }
    
        $listingbanner = $query->get();
    
        return view('homepage_settings.listingpage', compact('listingbanner'));
    }  
    public function upload(Request $request)
    {
        // Validate that 'image' is an array, and that it doesn't contain more than 20 items
        $request->validate([
            'image' => 'required|array|max:20',  // Ensures that 'image' is an array with no more than 20 items
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate each image individually
        ]);
    
        // Handle the image upload for each file
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                // Generate a unique file name for each image
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
    
                // Store the image in the 'listingpage' folder
                $image->storeAs('public/listingpage', $imageName);
    
                // Store the banner information in the database
                $banner = new ListingPage();
                $banner->image = $imageName;
                $banner->save();
            }
    
            // Redirect to the listing page with a success message
            return redirect()->route('listingpage.index')->with('success', 'Banners uploaded successfully.');
        }
    
        return redirect()->route('listingpage.index')->withErrors(['image' => 'Please select images to upload.']);
    }
    


    public function destroy($id)
    {
        // Find the banner to delete
        $banner = ListingPage::findOrFail($id);

        // Delete the image from storage
        Storage::delete('public/listingpage/' . $banner->image);

        // Delete the banner record from the database
        $banner->delete();

        return redirect()->route('listingpage.index')->with('success', 'Banner deleted successfully.');
    }


    // Store function to handle image upload
    public function store(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            // Get the uploaded file
            $image = $request->file('image');

            // Generate a unique file name
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Change the storage path to 'listingpage' folder
            $image->storeAs('public/listingpage', $imageName);

            // Create a new ListingPage instance and store the image file name
            $banner = new ListingPage();
            $banner->image = $imageName;
            $banner->save(); // Save the record in the database

            // Redirect back to the listing page with a success message
            return redirect()->route('listingpage.index')->with('success', 'Banner uploaded successfully.');
        }

        // If no image was uploaded, redirect with an error message
        return redirect()->route('listingpage.index')->withErrors(['image' => 'Please select an image to upload.']);
    }



    public function update(Request $request, $id)
    {
        // Validate the uploaded image (optional)
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        // Find the banner by its ID using the ListingPage model
        $banner = ListingPage::findOrFail($id);  // Changed from Banner to ListingPage
        
        // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            // If there is an old image, delete it
            if ($banner->image) {
                Storage::delete('public/listingpage/' . $banner->image);
            }
        
            // Store the new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/listingpage', $imageName);
        
            // Update the banner's image field in the database
            $banner->image = $imageName;
        }
        
        // Save the changes to the banner record
        $banner->save();
        
        // Redirect back with a success message
        return redirect()->route('listingpage.index')->with('success', 'Banner updated successfully!');
    }
    
    

    public function edit($id)
    {
        // Find the banner by its ID using the ListingPage model
        $banner = ListingPage::findOrFail($id);  // Change from Banner to ListingPage
    
        // Return the view with the banner data
        return view('homepage_settings.listingpageedit', compact('banner'));
    }

    
}
