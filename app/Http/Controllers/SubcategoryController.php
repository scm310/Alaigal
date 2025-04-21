<?php
namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SubcategoryController extends Controller
{
 
    public function index()
    {
        $subcategories = DB::table('subcategories')
            ->join('category', 'subcategories.category_id', '=', 'category.Category_id')
            ->select('subcategories.id', 'subcategories.category_id', 'subcategories.name', 'subcategories.created_at', 'subcategories.updated_at', 'category.Category_name')
            ->get();
    
        $categories = Category::all(); // Fetch all categories
    
        return view('categories.subcategory', compact('subcategories', 'categories'));
    }
    
    
public function edit($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $categories = Category::all(); // Get all categories for the dropdown
        return view('categories.editchildcategory', compact('subcategory', 'categories'));
    }
    
 



    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:category,Category_id',
            'subcategory_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $subcategory = Subcategory::findOrFail($id);
        $subcategory->name = ucfirst(trim($request->name));
        $subcategory->category_id = $request->category_id;
    
        // Check if a new image file is uploaded
        if ($request->hasFile('subcategory_image')) {
            // Delete the old image if it exists
            if ($subcategory->image && Storage::disk('public')->exists($subcategory->image)) {
                Storage::disk('public')->delete($subcategory->image);
            }
            // Store the new uploaded image
            $imagePath = $request->file('subcategory_image')->store('subcategory', 'public');
            $subcategory->image = $imagePath;
        }
    
        $subcategory->save();
    
        return redirect()->route('childcategory')->with('success', 'Subcategory updated successfully!');
    }
    
    
    public function destroy($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $subcategory->delete();

        return redirect()->route('childcategory')->with('success', 'Subcategory deleted successfully!');
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:category,Category_id',
            'subcategory_names' => 'required|array',
            'subcategory_names.*' => 'required|string|max:255',
            'subcategory_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'selected_default_images' => 'array',
            'image_option' => 'required|array',
        ]);
    
        // Check for duplicate subcategories
        $duplicates = [];
        foreach ($request->subcategory_names as $subcategoryName) {
            $formattedName = ucfirst(trim($subcategoryName));
            if (Subcategory::where('category_id', $request->category_id)
                ->where('name', $formattedName)->exists()) {
                $duplicates[] = $formattedName;
            }
        }
    
        if (!empty($duplicates)) {
            return back()->with('error', 'Subcategory ' . implode(', ', $duplicates) . ' already exist.');
        }
    
        $subcategories = [];
        foreach ($request->subcategory_names as $index => $subcategoryName) {
            $imagePath = null;
            $formattedName = ucfirst(trim($subcategoryName));
    
            // Process uploaded images
            if ($request->image_option[$index] === "upload" && $request->hasFile("subcategory_images.$index")) {
                $imagePath = $request->file("subcategory_images.$index")->store('subcategory', 'public');
            }
            // Process default images
            elseif ($request->image_option[$index] === "default" && !empty($request->selected_default_images[$index])) {
                $defaultImage = $request->selected_default_images[$index];
                $defaultImagePath = storage_path("app/public/$defaultImage");
    
                if (file_exists($defaultImagePath)) {
                    $newFileName = 'subcategory/' . uniqid() . '_' . basename($defaultImage);
                    Storage::disk('public')->copy($defaultImage, $newFileName);
                    $imagePath = $newFileName;
                }
            }
    
            $subcategories[] = [
                'category_id' => $request->category_id,
                'name' => $formattedName,
                'image' => $imagePath,
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    
        Subcategory::insert($subcategories);
    
        return back()->with('success', 'Subcategories added successfully.');
    }
    
    
    
    
    
    public function getSubcategories($categoryId)
    {
        // Fetch subcategories where the parent category matches
        $subcategories = Subcategory::where('category_id', $categoryId)->get(['id', 'name']);
        
        // Return the data as JSON
        return response()->json($subcategories);
    }

    public function filter(Request $request)
    {
        // Get the selected category and subcategory from the request
        $categoryId = $request->input('category_id');
        $subcategoryId = $request->input('subcategory_id');
    
        // Query the subcategories based on category selection, and join with the correct table
        $subcategoriesQuery = Subcategory::query();
    
        // If category is selected, filter subcategories by category
        if ($categoryId) {
            $subcategoriesQuery->where('subcategories.category_id', $categoryId);
        }
    
        // If subcategory is selected, filter by subcategory ID
        if ($subcategoryId) {
            $subcategoriesQuery->where('subcategories.id', $subcategoryId);
        }
    
        // Join subcategories with the correct category table ('category')
        $subcategories = $subcategoriesQuery->join('category', 'subcategories.category_id', '=', 'category.Category_id')
                                            ->select('subcategories.*', 'category.Category_name')
                                            ->get();
    
        // Debugging to check the data being returned
       // dd($subcategories);
    
        // Get all categories to populate the category dropdown
        $categories = Category::all();
    
        return view('categories.subcategory', compact('subcategories', 'categories'));
    }
    
    

}
