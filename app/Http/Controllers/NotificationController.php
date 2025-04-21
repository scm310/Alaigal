<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Notification;
use App\Models\VendorRegister;
use Illuminate\Support\Facades\DB; // Move this to the top

class NotificationController extends Controller
{
    public function newVendorProducts()
    {
        $user = auth()->user(); // Get the authenticated user

        $query = DB::table('items')
        ->select('items.*','items.id', 'items.name as productname', 'vendor_registers.name as vendorname', 'vendor_registers.company_name', 'category.Category_name') 
        ->leftJoin('vendor_registers', 'items.vendor_id', '=', 'vendor_registers.id')
        ->leftJoin('category', 'items.categoryid', '=', 'category.category_id')
        ->where('items.status', 'vendor')
        ->orderBy('items.created_at', 'desc');
    
    
  
    
    // Get the results from the query
    $newVendorProducts = $query->get();
    
        //dd($newVendorProducts);

        // Fetch the status from the notifications table based on product_id matching the item's id
        $notificationsStatus = DB::table('notifications')
            ->whereIn('product_id', $newVendorProducts->pluck('id'))
            ->pluck('status', 'product_id'); // Pluck status values with product_id as the key

        // Pass the data to the view
        return view('notifications.newVendorProducts', compact('newVendorProducts', 'notificationsStatus'));
    }



    public function markVendorProductsAsSeen()
    {
        // Mark the session as seen for new vendor products
        session(['new_vendor_product_seen' => true]);

        // Redirect to the dashboard or any other page
        return redirect()->route('dashboard');
    }

    public function updateStatus($id, Request $request)
    {
        // Validate status input
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);

        // Fetch data from the items table for the given $id
        $item = DB::table('items')
            ->select('id', 'vendor_id', 'categoryid', 'subcategoryid', 'childcategoryid', 'vendor_status')
            ->where('id', $id)
            ->first();

        if ($item) {
            // Update the vendor_status in the items table
            DB::table('items')
                ->where('id', $id)
                ->update([
                    'vendor_status' => $request->status, // Update the vendor_status column
                    'updated_at' => now(), // Update the updated_at timestamp
                ]);

            // Check if a notification for this product_id already exists
            $existingNotification = DB::table('notifications')
                ->where('product_id', $item->id)
                ->first();

            if ($existingNotification) {
                // If a notification exists, update the status
                DB::table('notifications')
                    ->where('product_id', $item->id)
                    ->update([
                        'status' => $request->status, // Update the status
                        'updated_at' => now(),
                    ]);
            } else {
                // If no notification exists, insert a new record
                DB::table('notifications')->insert([
                    'product_id' => $item->id,
                    'vendor_id' => $item->vendor_id,
                    'category_id' => $item->categoryid,
                    'subcategory_id' => $item->subcategoryid,
                    'child_category_id' => $item->childcategoryid,
                    'status' => $request->status, // Set the status
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Redirect back with a success message
        return redirect()->route('notifications.newVendorProducts')->with('success', 'Product status updated successfully.');
    }



    public function markNotificationAsSeen()
    {
        // Mark the notification as seen by updating session or database
        session(['new_vendor_product_seen' => true]);

        return response()->json(['success' => true]);
    }



    public function updatePricing($id, Request $request)
    {
        // Validate the input data
        $request->validate([
            'sales_price' => 'required|numeric|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'fixing_of_margin' => 'required|numeric|min:0',
        ]);

        // Find the product by ID
        $product = Item::find($id);

        if ($product) {
            // Update the pricing details
            $product->sales_price = $request->sales_price;
            $product->purchase_price = $request->purchase_price;
            $product->fixing_of_margin = $request->fixing_of_margin;

            // Save the changes
            $product->save();

            // Redirect back with success message
            return redirect()->route('notifications.newVendorProducts')->with('success', 'Product pricing updated successfully.');
        }

        // If product not found, redirect with error message
        return redirect()->route('notifications.newVendorProducts')->with('error', 'Product not found.');
    }


    //fixing of margin update
    public function updateProduct(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'product_id' => 'required|exists:items,id',
            'fixing_of_margin' => 'required|numeric',
            'sales_price' => 'required|numeric',
        ]);

        // Find the product by ID
        $product = Item::find($validated['product_id']);
        if ($product) {
            // Update the fixing of margin and sales price
            $product->fixing_of_margin = $validated['fixing_of_margin'];
            $product->sales_price = $validated['sales_price'];
            $product->save(); // Save changes to the database

            return response()->json(['message' => 'Product updated successfully']);
        }

        return response()->json(['message' => 'Product not found'], 404);
    }

    //vendor product status update
    public function updatevendorStatus(Request $request)
    {
        // Debugging output to confirm the request data
        \Log::info('Request received: ', $request->all());
    
        $product = Item::find($request->id);
        if ($product) {
            $product->vendor_status = $request->status;
            $product->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
    
    
    
}
