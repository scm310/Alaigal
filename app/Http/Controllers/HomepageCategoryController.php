<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class HomepageCategoryController extends Controller
{
    public function index()
    {
        // Fetch all categories
        $categories = Category::all();
        
        // Fetch the status of each category, associating it with the category ID
        $homepageCategories = Category::pluck('status', 'Category_id')->toArray();
        
        // Pass the categories and their status to the view
        return view('homepage_settings.categories', compact('categories', 'homepageCategories'));
    }

    public function update(Request $request)
{
    try {
        foreach ($request->categories as $categoryId => $status) {
            $category = Category::find($categoryId);
            if ($category) {
                $category->status = $status; // Update status (0 or 1)
                $category->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Homepage categories updated successfully!',
        ]);
    } catch (\Exception $e) {
        Log::error('Category update failed: ' . $e->getMessage()); // Log error for debugging

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong!',
        ], 500);
    }
}


public function producthighlight()
{
    $user = auth()->user(); // Get the authenticated user

    // Fetch items with necessary joins
    $query = DB::table('items')
        ->select(
            'items.*', 
            'items.name as item_name',  // Alias for items.name
            'category.Category_name as category_name',
            'subcategories.name as subcategory_name',
            'child_categories.name as child_category_name',
            'vendor_registers.name as vendor_name',  // Alias for vendor_registers.name
            'vendor_registers.phone', 
            'vendor_registers.company_name', 
            'vendor_registers.email'
        )
        ->leftJoin('category', 'items.categoryid', '=', 'category.Category_id')
        ->leftJoin('subcategories', 'items.subcategoryid', '=', 'subcategories.id')
        ->leftJoin('child_categories', 'items.childcategoryid', '=', 'child_categories.id')
        ->leftJoin('vendor_registers', 'items.vendor_id', '=', 'vendor_registers.id')
        ->orderBy('items.created_at', 'desc');

    // Add condition to check for 'approved' vendor status
    $query->where('items.vendor_status', 'approved');

    // If the user is NOT a super admin, filter by user_id
    if ($user->role_id != 1) {
        $query->where('items.user_id', $user->id);
    }

    // Execute the query and get the results
    $items = $query->get();

    // Fetch all records from add_highlight table
    $highlights = DB::table('add_highlight')->get();

    // Return the view with both variables
    return view('homepage_settings.highlightproduct', compact('items', 'highlights'));
}

public function updateHighlight(Request $request)
{


    try {
        $productId = $request->input('product_id');
        $selectedHighlights = $request->input('highlights', []); // Default to empty array if nothing is selected



        // Convert array to JSON or comma-separated string before storing
        $highlightData = json_encode($selectedHighlights);

        // Update the item with selected highlights
        Item::where('id', $productId)->update([
            'add_highlight' => $highlightData,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product highlights updated successfully!',
        ]);
    } catch (\Exception $e) {
        Log::error('Highlight update failed: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong!',
        ], 500);
    }
}

    
}


