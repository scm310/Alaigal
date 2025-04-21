<?php

namespace App\Http\Controllers;
use App\Models\LoginBanner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use App\Models\Banner;
use App\Models\CustomerBanner;
use App\Models\Favicon;
use App\Models\HeaderSetting;
use Illuminate\Http\Request;
class HeadersettingController extends Controller
{


    public function addBanner()
    {
        // Fetch all banners from the loginbanner table
        $banners = LoginBanner::all();

        // Return the view with banners data
        return view('admin.headersetting.addbanner', compact('banners'));
    }

    public function storeBanner(Request $request)
    {
        $request->validate([
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $bannerFilename = null;

        if ($request->hasFile('banner')) {
            // Get the original file extension and generate a unique filename
            $bannerFilename = time() . '.' . $request->file('banner')->getClientOriginalExtension();
            // Store the file in the 'public/banners' directory
            $request->file('banner')->storeAs('public/banners', $bannerFilename);
        }

        LoginBanner::create([
            'banner_image' => $bannerFilename, // Store only the image filename, not the full path
        ]);

        return back()->with('success', 'Banner image stored successfully!');
    }

    public function destroy($id)
    {
        $banner = LoginBanner::findOrFail($id);

        // Delete the banner image file from storage
        Storage::delete('public/banners/' . $banner->banner_image);

        // Delete the banner record from the database
        $banner->delete();

        return redirect()->route('admin.headersetting.addbanner')->with('success', 'Banner deleted successfully');
    }



public function addlogo()
{
    // Fetch all logos from the database
    $logos = HeaderSetting::all();

    // Return the view with logos data
    return view('admin.headersetting.addlogo', compact('logos'));
}




    public function storeHeader(Request $request)
    {
        // Validate the form input
        $request->validate([
            'logo' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            'title' => 'required|string|max:255',
        ]);

        // Check if there is already a header setting (logo and title) stored in the database
        $existingHeader = HeaderSetting::latest()->first();

        if ($existingHeader) {
            // If a header setting already exists, show the success message that data is already stored
            return back()->with('success', 'Logo and title are already stored.');
        }

        // If no existing header setting, proceed with the logo upload
        $logoFilename = null;
        if ($request->hasFile('logo')) {
            // Store the new logo
            $logoFilename = time() . '.' . $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->storeAs('public/logos', $logoFilename);
        }

        // Store the new logo and title in the database
        HeaderSetting::create([
            'logo' => $logoFilename,
            'title' => $request->title
        ]);

        return back()->with('success', 'Logo and Title uploaded successfully!');
    }




    public function showHeader()
    {
        $logos = HeaderSetting::latest()->first();
    
        // Return both pages with the same logo data
        return view('home', compact('logos'))->with('logos', $logos);
    }
    
  


    public function destroyLogo($id)
    {
        $logo = HeaderSetting::findOrFail($id);

        // Delete the logo file from storage if it exists
        if ($logo->logo) {
            Storage::delete('public/logos/' . $logo->logo);
        }

        $logo->delete(); // Delete the record from the database

        return redirect()->route('admin.headersetting.addlogo')->with('success', 'Logo deleted successfully');
    }



    public function uploadCustomerBanner(Request $request)
    {
        $request->validate([
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Get the original image name
        $imageName = time() . '_' . $request->file('banner')->getClientOriginalName();

        // Store the image in `storage/app/public/customer_banner/`
        $request->file('banner')->storeAs('public/customer_banner', $imageName);

        // Save only the image name in the database
        CustomerBanner::create([
            'image' => $imageName
        ]);

        return redirect()->route('header-setting.customerBanner')->with('success', 'Banner uploaded successfully!');
    }



    public function showCustomerBanner()
    {
        $banners = CustomerBanner::orderBy('created_at', 'desc')->get(); // Fetch all banners
        $bannerCount = $banners->count(); // Get the count of banners
        return view('admin.headersetting.customerbanner', compact('banners', 'bannerCount'));
    }




    // Delete banner
    public function deleteBanner($id)
    {
        $banner = CustomerBanner::findOrFail($id);

        // Delete image from storage
        Storage::delete('public/customer_banner/' . $banner->image);

        // Delete record from database
        $banner->delete();

        return redirect()->back()->with('success', 'Banner deleted successfully!');
    }


   // ✅ Method to show the favicon form
   public function create()
   {
      $fav=Favicon::all();
       return view('admin.headersetting.favicon',compact('fav'));
   }



   public function storeFavicon(Request $request)
   {
       $request->validate([
           'title' => 'required|string|max:255',
           'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
       ]);

       // Check if a favicon already exists
       $existingFavicon = Favicon::first();

       if ($existingFavicon) {
           return redirect()->back()->with('error', 'Only one favicon is allowed. Please delete the existing favicon before uploading a new one.');
       }

       // Store favicon in storage/app/public/favicon
       $imagePath = $request->file('logo')->store('public/favicon');

       // Extract filename for database storage
       $imageName = str_replace('public/favicon/', '', $imagePath);

       // Store new favicon in database
       Favicon::create([
           'title' => $request->title,
           'logo' => $imageName,
       ]);

       return redirect()->back()->with('success', 'Favicon uploaded successfully.');
   }



   public function deleteFavicon()
   {
       $favicon = Favicon::first();

       if (!$favicon) {
           return redirect()->back()->with('error', 'No favicon found.');
       }

       // Delete the favicon file
       $faviconPath = public_path('uploads/favicons/' . $favicon->logo);
       if (file_exists($faviconPath)) {
           unlink($faviconPath);
       }

       // Delete favicon record
       $favicon->delete();

       return redirect()->back()->with('success', 'Favicon deleted successfully.');
   }



public function showFaviconSettings()
{
    $favicon = Favicon::latest()->first(); // Fetch the latest favicon entry
    return view('admin.headersetting', compact('favicon')); // Pass data to Blade
}


public function showLogin()
{
    $header = HeaderSetting::first(); // Get the first record or modify the query as needed
    return view('admin.layout.login', compact('header'));
}


}
