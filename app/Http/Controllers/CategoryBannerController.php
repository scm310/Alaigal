<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryBanner;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryBannerController extends Controller
{
    public function index()
    {
        $banners = CategoryBanner::with('category')->get(); // Fetch banners with category relationship
        $categories = Category::all(); // Fetch all categories for dropdown

        return view('homepage_settings.categorybanner', compact('banners', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:category,Category_id', 
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Check if the category already has 3 banners
        $bannerCount = CategoryBanner::where('category_id', $request->category_id)->count();
    
        if ($bannerCount >= 3) {
            return redirect()->back()->with('error', 'Each category can have only 3 banners.');
        }
    
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('CategoryBanner', 'public');
    
            CategoryBanner::create([
                'category_id' => $request->category_id,
                'banner' => $path,
            ]);
        }
    
        return redirect()->route('banners.index')->with('success', 'Banner uploaded successfully.');
    }
    
    public function destroy($id)
    {
        $banner = CategoryBanner::findOrFail($id);
        
        // Delete the stored image
        Storage::disk('public')->delete($banner->banner);
    
        // Delete the banner record from the database
        $banner->delete();
    
        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $banner = CategoryBanner::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($banner->banner);

            // Store new image
            $path = $request->file('image')->store('CategoryBanner', 'public');

            // Update banner path
            $banner->update(['banner' => $path]);
        }

        return response()->json(['success' => true, 'message' => 'Banner updated successfully']);
    }
    

}




