<?php

namespace App\Http\Controllers;

use App\Imports\ProductImport;
use App\Models\Item;
use App\Models\Unit;
use App\Models\Vendor;
use App\Models\VendorRegister;
use Illuminate\Http\Request;
use App\Imports\ItemImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ChildCategory;
use App\Models\Wholesale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    $user = auth()->user(); // Get the authenticated user

    // Start building the base query
    $query = DB::table('items')
        ->select(
            'items.*',
            'items.name as item_name',  // Alias for items.name
            'category.Category_name as category_name',
            'subcategories.name as subcategory_name',
            'child_categories.name as child_category_name',
            'vendor_registers.name as vendor_name',  // Alias for vendor_registers.name
            'vendor_registers.phone',
            'vendor_registers.email',
            DB::raw("CASE WHEN items.status = 'vendor' THEN vendor_registers.company_name ELSE users.company_name END as company_name")
        )
        ->leftJoin('category', 'items.categoryid', '=', 'category.Category_id')
        ->leftJoin('subcategories', 'items.subcategoryid', '=', 'subcategories.id')
        ->leftJoin('child_categories', 'items.childcategoryid', '=', 'child_categories.id')
        ->leftJoin('vendor_registers', 'items.vendor_id', '=', 'vendor_registers.id')
        ->leftJoin('users', 'items.user_id', '=', 'users.id') // Join with users table
        ->orderBy('items.created_at', 'desc');

    // If the user is NOT a super admin, filter by user_id
    if ($user->role_id != 1) {
        $query->where('items.user_id', $user->id);
    }

    $items = $query->get();

    return view('items.index', compact('items'));
}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     // Retrieve the item and its associated vendor using eager loading
    //     $item = Item::with('vendor')->findOrFail($id);

    //     // Return the 'show' view and pass the item data
    //     return view('items.show', compact('item'));
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    // In ItemController.php


    public function show($id)
    {
        // Fetch the product and related details in a single query
        $item = DB::table('items')
            ->select(
                'items.id',
                'items.product_id',
                'items.name as item_name',  
                'items.brand',
                'items.uom',
                'unit.unit as uom_name',  // Fetch unit name correctly
                'items.sales_price',
                'items.purchase_price',
                'items.status',
                'items.tax',
                'items.vendor_id',
                'items.categoryid',
                'items.subcategoryid',
                'items.childcategoryid',
                'items.expiration_date',
                'items.product_image',
                'items.specification_name',
                'items.specification_value',
                'items.created_at',
                'items.updated_at',
                'items.Date',
                'category.Category_name as category_name',
                'subcategories.name as subcategory_name',
                'child_categories.name as child_category_name',
                'vendor_registers.name as vendor_name',
                'vendor_registers.phone',
                'vendor_registers.email'
            )
            ->leftJoin('category', 'items.categoryid', '=', 'category.Category_id')
            ->leftJoin('subcategories', 'items.subcategoryid', '=', 'subcategories.id')
            ->leftJoin('child_categories', 'items.childcategoryid', '=', 'child_categories.id')
            ->leftJoin('vendor_registers', 'items.vendor_id', '=', 'vendor_registers.id')
            ->leftJoin('unit', 'unit.id', '=', 'items.uom')  // FIXED: Join using 'id' instead of 'abbreviation'
            ->where('items.id', $id)
            ->first();
    
        // Ensure UOM name is always available
        $uom = $item->uom_name ?? 'N/A';
    
        // Decode JSON fields safely
        $specificationNames = json_decode($item->specification_name ?? '[]', true);
        $specificationValues = json_decode($item->specification_value ?? '[]', true);
    
        // Pass data to the view
        return view('items.show', compact('item', 'specificationNames', 'specificationValues', 'uom'));
    }
    
    

    public function getProductData($productId)
    {
        $product = Item::find($productId); // Fetch product by ID
       

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'highlights' => json_decode($product->add_highlight, true) ?? [], // Ensure it's an array
        ]);
    }

     //highlight product
     public function updateProductStatus(Request $request)
     {
         // dd($request->all());
 
 
         $product = Item::where('id', $request->product_id)->first();
 
 
         foreach ($request->except(['_token', 'product_id']) as $field => $value) {
             if (in_array($field, ['hot_sale', 'top_sale', 'newyear_offer', 'festival'])) {
                 $product->$field = $value;
             }
         }
 
         $product->save();
 
         return response()->json([
             'success' => true,
             'message' => 'Product status updated successfully!',
         ]);
     }

     public function destroy($id)
     {
         DB::delete("DELETE FROM items WHERE `items`.`id` = ?", [$id]);
     
         return redirect()->back()->with('success', 'Product deleted successfully!');
     }
     
     

}
