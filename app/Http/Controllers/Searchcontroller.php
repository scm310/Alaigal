<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ChildCategory;
use App\Models\Item;
use App\Models\ListingPage;

class Searchcontroller extends Controller
{
  
    public function search(Request $request)
    {
        
        
        // Check if query is empty and redirect to home
    if (!$request->has('query') || empty($request->input('query'))) {
        return redirect()->route('home'); // Make sure 'home' is a valid route name
    }
        $query = $request->input('query'); // Get the search query
    
        // Search in Category table
        $categories = Category::where('Category_name', 'like', '%' . $query . '%')->get();
    
        // Search in Subcategory table
        $subcategories = Subcategory::where('name', 'like', '%' . $query . '%')->get();
    
        // Search in Childcategory table
       // Fetch child categories, eager load the related subcategory and category
$childCategories = ChildCategory::with('subcategory.category')
->where('name', 'like', '%' . $query . '%')
->get();
    
        // Fetch selected child category for highlighting in the view (optional, for links)
        $selectedChildCategory = null; // Set as null by default
        if ($request->has('childCategoryId')) {
            $selectedChildCategory = ChildCategory::find($request->input('childCategoryId'));
        }
    
        // Fetch products with pagination
        $products = Item::where(function ($queryBuilder) use ($categories, $subcategories, $childCategories, $query) {
            // Filter by category IDs
            foreach ($categories as $category) {
                $queryBuilder->orWhere('categoryid', $category->Category_id);
            }
            // Filter by subcategory IDs
            foreach ($subcategories as $subcategory) {
                $queryBuilder->orWhere('subcategoryid', $subcategory->id);
            }
            // Filter by childcategory IDs
            foreach ($childCategories as $childCategory) {
                $queryBuilder->orWhere('childcategoryid', $childCategory->id);
            }
            // Filter by name and description in the Item table
            $queryBuilder->orWhere('name', 'like', '%' . $query . '%')
                         ->orWhere('description', 'like', '%' . $query . '%');
        })->paginate(12); // Ensure pagination is used here
    
        // Fetch all banners for products page.
        $listingbanner = ListingPage::all();
    
        // Pass everything to the view
        return view('website.products', compact('products', 'categories', 'subcategories', 'childCategories', 'selectedChildCategory', 'listingbanner'));
    }
    

    public function getSearchSuggestions(Request $request)
    {
        $query = $request->input('query');
    
        // Ensure that the query is not empty before proceeding
        if (empty($query)) {
            return response()->json([]);
        }
    
        // Find categories, subcategories, child categories, and items that match the query
        $categories = Category::where('Category_name', 'like', $query . '%')->get();
        $subcategories = Subcategory::where('name', 'like', $query . '%')->get();
        $childCategories = ChildCategory::where('name', 'like', $query . '%')->get();
        $items = Item::where('name', 'like', $query . '%')
            ->orWhere('description', 'like', $query . '%')
            ->orWhere('brand', 'like', $query . '%')
            ->get();
    
        $results = [];
    
        // Add categories to results
        foreach ($categories as $category) {
            $results[] = [
                'name' => $category->Category_name,
                'type' => 'category',
                'link' => route('products.category', $category->Category_name),
            ];
        }
    
        // Add subcategories to results
        foreach ($subcategories as $subcategory) {
            $results[] = [
                'name' => $subcategory->name,
                'type' => 'subcategory',
                'link' => route('products.subcategory', [$subcategory->category->Category_name, $subcategory->name]),
            ];
        }
    
        // Add child categories to results
        foreach ($childCategories as $child) {
            $results[] = [
                'name' => $child->name,
                'type' => 'childcategory',
                'link' => route('products.childcategory', [$child->subcategory->category->Category_name, $child->subcategory->name, $child->name]),
            ];
        }
    
        // Add items to results (products)
        foreach ($items as $item) {
            $results[] = [
                'name' => $item->name,
                'type' => 'item',
                'link' => route('product.childcategory', $item->id), // Assuming route for item details
            ];
        }
    
        // Return all results combined
        return response()->json($results);
    }

    public function productsByChildCategory($category, $subcategory, $childcategory)
    {
        // Normalize input (replace hyphens with spaces and capitalize)
        $normalizedChildCategory = ucwords(str_replace('-', ' ', $childcategory));
    
        // Fetch selected child category
        $selectedChildCategory = ChildCategory::where('name', $normalizedChildCategory)->first();
    
        // Handle missing child category
        if (!$selectedChildCategory) {
            abort(404, 'Child category not found.');
        }
    
        // Fetch child categories within the same subcategory
        $childCategories = ChildCategory::where('subcategory_id', $selectedChildCategory->subcategory_id)->get();
    
        // Fetch products under the selected child category
        $products = Item::with(['category', 'subcategory', 'childcategory', 'vendorDetails'])
            ->where(function ($query) {
                $query->where('status', 'admin')
                    ->orWhere('vendor_status', 'approved');
            })
            ->whereHas('childcategory', function ($query) use ($normalizedChildCategory) {
                $query->where('name', $normalizedChildCategory);
            })
            ->paginate(12);
    $listingbanner = ListingPage::all(); // Fetch all banners for products page.
        // Return the view with data
        return view('website.products', compact('products', 'childCategories', 'selectedChildCategory','listingbanner'));
    }

    
    

    

    
    



}
