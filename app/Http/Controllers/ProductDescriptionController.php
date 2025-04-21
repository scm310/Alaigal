<?php
namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ProductDescriptionController extends Controller
{
    public function productDetails()
    {
        return view('website.product_detail');
    }

    public function show(Request $request, $id = null)
{
    // Check if ID is provided in route or query
    $id = $id ?? $request->query('id');

    // Abort if no valid ID is provided
    if (!$id) {
        abort(404, 'Product not found');
    }

    // Fetch the main product details
    $product = Item::with(['vendorRegister', 'category', 'subcategory', 'childcategory', 'unit'])
        ->findOrFail($id);

    // Fetch related products (same category & approved vendor)
    $relatedProducts = Item::where('categoryid', $product->categoryid)
        ->where('id', '!=', $product->id) // Exclude the current product
        ->whereHas('vendorRegister', function ($query) {
            $query->where('vendor_status', 'approved'); // Fetch only approved vendors
        })
        ->take(40) // Limit to 40 related products
        ->get();

    // Process specifications
    $specifications = [];
    if (!empty($product->specification_name) && !empty($product->specification_value)) {
        $names = json_decode($product->specification_name, true);
        $values = json_decode($product->specification_value, true);

        if (is_array($names) && is_array($values) && count($names) === count($values)) {
            $specifications = array_combine($names, $values);
        }
    }

    // Pass product, specifications, and related products to the view
    return view('website.product_detail', compact('product', 'specifications', 'relatedProducts'));
}

}

