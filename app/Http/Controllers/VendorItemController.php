<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Item;
use Illuminate\Http\Request;

class VendorItemController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user
    
        // Initialize the query builder for items
        $query = DB::table('items')
            ->join('vendor_registers', 'vendor_registers.id', '=', 'items.vendor_id')
            ->join('category', 'category.Category_id', '=', 'items.categoryid') // Join with the category table
            ->select(
                'items.name', 
                'items.brand', 
                'items.sales_price', 
                'items.created_at',
                'vendor_registers.phone',        
                'vendor_registers.company_name', 
                'category.Category_name' // Select category name
            );
    
        // If the user is not a super admin, filter items by the logged-in user's vendor ID
        if ($user->role_id != 1) {
            $query->where('items.user_id', $user->id); // Filter by the logged-in user
        }
    
        // Handle search functionality
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
        
            // Search in product name, brand, sales price (like search for string fields, exact match for price)
            $query->where(function($query) use ($searchTerm) {
                $query->where('items.name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('items.brand', 'like', '%' . $searchTerm . '%')
                    ->orWhere('items.sales_price', 'like', '%' . $searchTerm . '%')
                    ->orWhere('category.Category_name', 'like', '%' . $searchTerm . '%');
            });
        }
    
        // Get the filtered vendor items
        $vendorItems = $query->get();
    
        // Get distinct vendor names for the dropdown filter
        $vendorNames = DB::table('vendor_registers')
            ->select('name')
            ->distinct()
            ->get();
    
        // Get distinct product names for the dropdown filter
        $productNames = DB::table('items')
            ->select('name')
            ->distinct()
            ->get();
    
        // Pass the data to the view
        return view('vendor-items.index', compact('vendorItems', 'vendorNames', 'productNames'));
    }

    // Vendor autocomplete method
    public function autocompleteVendor(Request $request)
{
    $query = $request->get('query');
    $vendors = DB::table('vendor_registers')
        ->where('name', 'like', '%' . $query . '%')
        ->distinct()
        ->get(['vendor_name']);

    return response()->json(['suggestions' => $vendors]);
}

public function autocompleteProduct(Request $request)
{
    $query = $request->get('query');
    $products = DB::table('items')
        ->where('name', 'like', '%' . $query . '%')
        ->distinct()
        ->get(['name']);

    return response()->json(['suggestions' => $products]);
}
}

