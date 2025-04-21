<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ChildCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Storage;

class ChildCategoryController extends Controller
{
    /**
     * Fetch subcategories for the selected category (AJAX)
     */



public function index()
     {
         $userId = auth()->id(); // Get logged-in user ID
     
         // Fetch only categories belonging to the logged-in user
         $categories = DB::table('category')
             ->where('user_id', $userId)
             ->select('Category_id', 'Category_name')
             ->orderBy('Category_name', 'asc')
             ->get();
     
         // Fetch categories, subcategories, and child categories related to the logged-in user
         $results = DB::table('category') // Use 'category' since it's your table name
             ->leftJoin('subcategories', 'category.Category_id', '=', 'subcategories.category_id')
             ->leftJoin('child_categories', 'subcategories.id', '=', 'child_categories.subcategory_id')
             ->select(
                 'category.Category_id',
                 'category.Category_name',
                 'category.Category_image',
                 'subcategories.id as subcategory_id',
                 'subcategories.name as subcategory_name',
                 'child_categories.id as child_category_id',
                 'child_categories.name as child_category_name'
             )
             ->where('category.user_id', $userId) // Filter only the logged-in user's categories
             ->orderBy('category.Category_name', 'asc')
             ->orderBy('subcategories.name', 'asc')
             ->orderBy('child_categories.name', 'asc')
             ->get();
     
         return view('categories.childcategory', compact('results', 'categories'));
     }
     
     
    public function fetchSubcategories(Request $request)
    {
        // Validate that category_id exists in the categories table
        $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        // Fetch subcategories based on the selected category_id
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();

        // Return subcategories as a JSON response
        return response()->json([
            'subcategories' => $subcategories
        ]);
    }




    /**
     * Store a newly created child category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:category,Category_id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'childcategory_names' => 'required|array',
            'childcategory_names.*' => 'required|string|max:255',
            'childcategory_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'selected_default_images' => 'array',
            'image_option' => 'required|array',
        ]);
    
        // Duplicate check for child categories
        $duplicates = [];
        foreach ($request->childcategory_names as $childCategoryName) {
            $formattedName = ucfirst(trim($childCategoryName));
            if (ChildCategory::where('category_id', $request->category_id)
                ->where('subcategory_id', $request->subcategory_id)
                ->where('name', $formattedName)
                ->exists()) {
                $duplicates[] = $formattedName;
            }
        }
    
        if (!empty($duplicates)) {
            return back()->with('error', 'Child category ' . implode(', ', $duplicates) . ' already exist.');
        }
    
        $childCategories = [];
    
        foreach ($request->childcategory_names as $index => $childCategoryName) {
            $imagePath = null;
            $formattedName = ucfirst(trim($childCategoryName));
    
            if ($request->image_option[$index] === "upload" && $request->hasFile("childcategory_images.$index")) {
                $imagePath = $request->file("childcategory_images.$index")->store('childcategories', 'public');
            } 
            elseif ($request->image_option[$index] === "default" && !empty($request->selected_default_images[$index])) {
                $defaultImage = $request->selected_default_images[$index];
                $defaultImagePath = storage_path("app/public/$defaultImage");
    
                if (file_exists($defaultImagePath)) {
                    $newFileName = 'childcategories/' . uniqid() . '_' . basename($defaultImage);
                    Storage::disk('public')->copy($defaultImage, $newFileName);
                    $imagePath = $newFileName;
                }
            }
    
            $childCategories[] = [
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'user_id' => auth()->id(),
                'name' => $formattedName,
                'image' => $imagePath,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    
        ChildCategory::insert($childCategories);
    
        return back()->with('success', 'Child categories added successfully.');
    }
    
    
    
    

    public function getLatestCategorySubcategory()
{
    $latestCategory = Category::latest()->first();
    $latestSubcategory = $latestCategory ? Subcategory::where('category_id', $latestCategory->Category_id)->latest()->first() : null;

    return response()->json([
        'latestCategory' => $latestCategory,
        'latestSubcategory' => $latestSubcategory
    ]);
}

    



public function update(Request $request, $id)
{
    $request->validate([
        'childcategory_name' => 'required|string|max:255',
        'category_id' => 'required|exists:category,Category_id',
        'subcategory_id' => 'required|exists:subcategories,id',
        'childcategory_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $childCategory = ChildCategory::findOrFail($id);

    $childCategory->name = ucfirst(trim($request->childcategory_name));
    $childCategory->category_id = $request->category_id;
    $childCategory->subcategory_id = $request->subcategory_id;

    // Check if a new image file is uploaded
    if ($request->hasFile('childcategory_image')) {
        // Delete the old image if it exists
        if ($childCategory->image && Storage::disk('public')->exists($childCategory->image)) {
            Storage::disk('public')->delete($childCategory->image);
        }
        // Store the new uploaded image
        $imagePath = $request->file('childcategory_image')->store('childcategories', 'public');
        $childCategory->image = $imagePath;
    }

    $childCategory->save();

    return redirect()->route('childcategory')->with('success', 'Child Category updated successfully.');
}




// public function editChildCategory($childCategoryId)
// {
//     $childCategory = ChildCategory::findOrFail($childCategoryId);
//     return response()->json($childCategory);
// }


public function destroy($id)
{
    $childCategory = ChildCategory::find($id);

    if ($childCategory) {
        $childCategory->delete();
        return redirect()->back()->with('success', 'Child Category deleted successfully.');
    }

    $subcategory = Subcategory::find($id);

    if ($subcategory) {
        $subcategory->delete();
        return redirect()->back()->with('success', 'Subcategory deleted successfully.');
    }

    $category = Category::find($id);

    if ($category) {
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }

    return redirect()->back()->with('error', 'Item not found.');
}



public function addnew(){
    $userId = auth()->id(); // Get the logged-in user's ID

    // Fetch only the categories that belong to the logged-in user
    $categories = Category::where('user_id', $userId)
                ->select('Category_id', 'Category_name')
                ->get();

    return view('vendor_details.addnewcategory', compact('categories'));
}


public function filter(Request $request)
{
    // Get the logged-in user's ID
    $userId = auth()->id();

    // Validate the input
    $request->validate([
        'category_id' => 'nullable|exists:category,Category_id',
        'subcategory_id' => 'nullable|exists:subcategories,id',
        'child_category_id' => 'nullable|exists:child_categories,id',
    ]);

    // Fetch categories related to the logged-in user only
    $categories = DB::table('category')
        ->select('Category_id', 'Category_name')
        ->where('user_id', $userId) // Ensure it fetches only the logged-in user's categories
        ->orderBy('Category_name', 'asc')
        ->get();

    

    // Start building the query for filtering results
    $query = DB::table('category')
        ->leftJoin('subcategories', 'category.Category_id', '=', 'subcategories.category_id')
        ->leftJoin('child_categories', 'subcategories.id', '=', 'child_categories.subcategory_id')
        ->where('category.user_id', $userId); // Ensure only user's categories are used

    // Apply filters if provided
    if ($request->filled('category_id')) {
        $query->where('category.Category_id', $request->category_id);
    }
    if ($request->filled('subcategory_id')) {
        $query->where('subcategories.id', $request->subcategory_id);
    }
    if ($request->filled('child_category_id')) {
        $query->where('child_categories.id', $request->child_category_id);
    }

    // Get filtered results sorted alphabetically
    $results = $query->select(
        'category.Category_id',
        'category.Category_name',
        'category.Category_image',
        'subcategories.id as subcategory_id',
        'subcategories.name as subcategory_name',
        'child_categories.id as child_category_id',
        'child_categories.name as child_category_name'
    )
    ->orderBy('category.Category_name', 'asc')
    ->orderBy('subcategories.name', 'asc')
    ->orderBy('child_categories.name', 'asc')
    ->get();

 

    // Return the data to the view with the filtered categories
    return view('categories.childcategory', compact('results', 'categories'));
}




public function editChildCategory($id)
{
    $userId = auth()->id(); // Get the logged-in user's ID

    // Check if the ID belongs to a child category
    $childCategory = ChildCategory::where('id', $id)->where('user_id', $userId)->first();

    if ($childCategory) {
        $category = Category::where('Category_id', $childCategory->category_id)->where('user_id', $userId)->firstOrFail();
        $subcategory = Subcategory::where('id', $childCategory->subcategory_id)->where('user_id', $userId)->firstOrFail();

      
        return view('categories.editchildcategory', compact('childCategory', 'category', 'subcategory'));
    }

    // Check if the ID belongs to a subcategory
    $subcategory = Subcategory::where('id', $id)->where('user_id', $userId)->first();
    if ($subcategory) {
        $category = Category::where('Category_id', $subcategory->category_id)->where('user_id', $userId)->firstOrFail();

     

        return view('categories.editsubcategory', compact('subcategory', 'category'));
    }

    // Check if the ID belongs to a category
    $category = Category::where('Category_id', $id)->where('user_id', $userId)->first();
    if ($category) {
     

        return view('categories.editcategory', compact('category'));
    }

    return redirect()->route('categories.index')->with('error', 'Item not found or unauthorized access.');
}

// public function getSubcategories($categoryId)
// {
//     // Fetch subcategories where the parent category matches
//     $subcategories = Subcategory::where('category_id', $categoryId)->get(['id', 'name']);
    
//     // Return the data as JSON
//     return response()->json($subcategories);
// }


public function getSubcategories(Request $request)
{
    $subcategories = SubCategory::where('category_id', $request->category_id)->get();
    return response()->json($subcategories);
}



    
}
