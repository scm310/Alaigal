<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item; // Import the Item model

class VendorDashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated vendor
        $vendor = auth()->guard('vendor')->user();
    
        // Fetch the products associated with the vendor
        $products = Item::where('vendor_id', $vendor->id)
                        ->with('category', 'subcategory', 'childcategory')
                         ->orderBy('created_at', 'desc') 
                        ->get();  // Make sure you're calling get() to return a collection
    
        // Check if products are null and assign an empty collection if true
        if ($products->isEmpty()) {
            $products = collect();  // Ensures it's an empty collection, not null
        }
    
        // Return the vendor dashboard view with vendor and products data
        return view('vendorlogin.auth.dashboard', compact('vendor', 'products'));
    }

    public function product()
    {
        // Get the authenticated vendor
        $vendor = auth()->guard('vendor')->user();
    
        // Fetch the products associated with the vendor
        $products = Item::where('vendor_id', $vendor->id)
                        ->with('category', 'subcategory', 'childcategory')
                         ->orderBy('created_at', 'desc') 
                        ->get();  // Make sure you're calling get() to return a collection
    
        // Check if products are null and assign an empty collection if true
        if ($products->isEmpty()) {
            $products = collect();  // Ensures it's an empty collection, not null
        }
    
        // Return the vendor dashboard view with vendor and products data
        return view('vendorlogin.auth.product', compact('vendor', 'products'));
    }

    public function deleteProduct($id)
    {
        // Get the authenticated vendor
        $vendor = auth()->guard('vendor')->user();
    
        // Find the product belonging to the authenticated vendor
        $product = Item::where('vendor_id', $vendor->id)->where('id', $id)->first();
    
        if (!$product) {
            return back()->with('error', 'Product not found or you are not authorized to delete this product.');
        }
    
        // Delete the product
        $product->delete();
    
        // Redirect back to the same page with a success message
        return back()->with('success', 'Product deleted successfully.');
    }
    

    public function getProductDetails($id)
    {
        $vendor = auth()->guard('vendor')->user();
    
        // Fetch product details with relationships
        $product = Item::where('vendor_id', $vendor->id)
            ->where('id', $id)
            ->with('category', 'subcategory', 'childcategory')
            ->first();
    
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    
        // Convert arrays to strings for specifications
        $specificationName = is_array($product->specification_name) 
            ? implode(', ', $product->specification_name) 
            : $product->specification_name;
    
        $specificationValue = is_array($product->specification_value) 
            ? implode(', ', $product->specification_value) 
            : $product->specification_value;
    
        return response()->json([
            'name' => $product->name,
            'brand' => $product->brand,
            'category' => $product->category ? $product->category->Category_name : 'N/A',
            'subcategory' => $product->subcategory ? $product->subcategory->name : 'N/A',
            'childcategory' => $product->childcategory ? $product->childcategory->name : 'N/A',
            'sales_price' => $product->sales_price,
            'purchase_price' => $product->purchase_price,
            'status' => $product->status,
            'expiration_date' => $product->expiration_date ?? 'N/A',
            'description' => $product->description ?? 'N/A',
            'stock' => $product->stock ?? 'N/A',
            'image_url' => $product->image_url ?? null,
            'specification_name' => $specificationName ?? 'N/A', // Ensure it's a string
            'specification_value' => $specificationValue ?? 'N/A'  // Ensure it's a string
        ]);
    }
}


