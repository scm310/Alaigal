<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ChildCategory;
use App\Models\Item;
use App\Models\Unit;
use App\Models\VendorRegister;
use App\Models\VendorDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $vendor_id = auth()->user()->id;
    
        // Fetch vendor details from vendor_registers
        $member = DB::table('vendor_registers')->where('id', $vendor_id)->first();
    
        if (!$member) {
            return redirect()->back()->with('error', 'Vendor information not found.');
        }
    
        $member_id = $member->member_id;
    
        // Sum the total product_count from all subscriptions for the given member
        $totalSubscriptionProductLimit = DB::table('subscriptions')
            ->where('member_id', $member_id)
            ->where('plan_type', 'marketplace')
            ->sum('product_count'); // Get the total sum instead of a single row
    
        // Count the number of products already created by this vendor
        $productCount = DB::table('items')->where('vendor_id', $vendor_id)->count();
    
        // Check if the subscription limit is exceeded
        $subscriptionLimitExceeded = $productCount >= $totalSubscriptionProductLimit;
    
        // Fetch categories
        $categories = DB::table('category')->orderBy('Category_name', 'ASC')->get();

        
        // Fetch units
        $units = DB::table('unit')->orderBy('unit', 'asc')->get();
        
        // Fetch subcategories
        $subcategories = [];
        if (!$categories->isEmpty()) {
            $firstCategoryId = $categories->first()->Category_id ?? null;
            if ($firstCategoryId) {
                $subcategories = DB::table('subcategories')->where('category_id', $firstCategoryId)->get();
            }
        }
    
        // Fetch child categories
        $childcategories = [];
        if (!empty($subcategories)) {
            $childcategories = DB::table('child_categories')
                ->whereIn('subcategory_id', $subcategories->pluck('id'))
                ->get();
        }
    
        return view('vendorlogin.products.create', compact(
            'categories',
            'units',
            'vendor_id',
            'subcategories',
            'childcategories',
            'subscriptionLimitExceeded'
        ));
    }
    
    
    
    
    
    public function updateVendorStatus()
    {
        $currentDate = Carbon::now()->toDateString(); // Get today's date
    
        // Fetch vendors whose latest subscription has expired
        $vendorsToUpdate = DB::table('vendor_registers as vr')
            ->leftJoin('subscriptions as s', 'vr.member_id', '=', 's.member_id')
            ->select('vr.member_id', DB::raw('MAX(s.end_date) as latest_end_date')) // Get latest end_date
            ->groupBy('vr.member_id')
            ->havingRaw('latest_end_date IS NOT NULL AND latest_end_date < ?', [$currentDate]) // Only update if latest subscription has expired
            ->pluck('vr.member_id');
    
        // Debugging logs
        Log::info("Vendors whose subscription expired: ", ['vendors' => $vendorsToUpdate]);
    
        // If vendors exist, update their vendor_status to 'pending'
        if ($vendorsToUpdate->isNotEmpty()) {
            DB::table('items')
                ->whereIn('member_id', $vendorsToUpdate)
                ->update(['vendor_status' => 'pending']);
    
            Log::info("Updated vendor_status to 'pending' for:", ['members' => $vendorsToUpdate]);
        } else {
            Log::info("No vendors needed a status update.");
        }
    
        return response()->json(['message' => 'Vendor status update process completed']);
    }
    

    
    
    
    
    

    /**
     * Helper method to set subcategory and child category values.
     *
     * This ensures that if a vendor does not select a subcategory or child category,
     * those fields are set to null.
     */
    protected function setCategoryFields(Request $request, Item $item)
    {
        // If the field is filled, use its value; otherwise, set to null.
        $item->subcategoryid   = $request->filled('subcategoryid') ? $request->subcategoryid : null;
        $item->childcategoryid = $request->filled('childcategoryid') ? $request->childcategoryid : null;
    }

    /**
     * Store a newly created product.
     */
 
    
     public function store(Request $request)
     {
         // Validate the request data.
         $request->validate([
             'categoryid'         => 'required|exists:category,Category_id',
             'subcategoryid'      => 'nullable|exists:subcategories,id',
             'childcategoryid'    => 'nullable|exists:child_categories,id',
             'product_name'       => 'required|string|max:255',
             'brand'              => 'nullable|string|max:255',
             'uom'                => 'required|exists:unit,id',
             'sales_price'        => 'required|numeric',
             'expiration_date'    => 'nullable|date',
             'product_image'      => 'nullable|image|max:2048',
             'gallery_images'     => 'nullable|array|max:5',
             'gallery_images.*'   => 'image|mimes:jpeg,png,jpg,gif|max:2048',
             'gallery_video'      => 'nullable|max:1000000',
             'tax'                => 'nullable|numeric',
             'description'        => 'nullable|string|max:1000',
             'specification_name.*' => 'nullable|string|max:255',
             'specification_value.*' => 'nullable|string|max:255',
             'type'                => 'required|string',
         ]);
     
         DB::beginTransaction();
         try {
             $vendor_id = auth()->user()->id;
             $member_id = auth()->user()->member_id;
     
             // Fetch total product count from all subscriptions for the vendor
             $allowed_products = DB::table('subscriptions')
                 ->where('member_id', $member_id)
                 ->where('plan_type', 'marketplace')
                 ->sum('product_count');
     
             // Count the number of products the vendor has already added
             $current_product_count = DB::table('items')->where('member_id', $member_id)->count();
     
             // Restriction logic
             if ($current_product_count >= $allowed_products) {
                 return redirect()->route('vendor.products.create')
                     ->with('error', 'You have reached your product limit and cannot add more products.');
             }
     
             // Generate a unique product ID
             $lastItem = DB::table('items')->latest('id')->first();
             $nextId = $lastItem ? $lastItem->id + 1 : 1;
             $product_id = 'PRO' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
     
             // Create a new item
             $item = new Item();
             $item->product_id = $product_id;
             $item->categoryid = $request->categoryid;
             $item->name = $request->product_name;
             $item->brand = $request->brand;
             $this->setCategoryFields($request, $item);
     
             $unit = Unit::findOrFail($request->uom);
             $item->uom = $unit->id;
             $item->sales_price = $request->sales_price;
             $item->purchase_price = $request->sales_price;
             $item->expiration_date = $request->expiration_date;
             $item->product_status = $request->type;
             $item->tax = $request->tax;
             $item->description = $request->description;
             $item->vendor_id = $vendor_id;
             $item->member_id = $member_id;
     
             // Handle file uploads
             if ($request->hasFile('product_image')) {
                 $item->product_image = $request->file('product_image')->store('products', 'public');
             }
     
             if ($request->hasFile('gallery_images')) {
                 $galleryImages = [];
                 foreach ($request->file('gallery_images') as $image) {
                     $galleryImages[] = $image->store('product_gallery', 'public');
                 }
                 $item->gallery_images = json_encode($galleryImages);
             }
     
             if ($request->hasFile('gallery_video')) {
                 $item->gallery_video = $request->file('gallery_video')->store('gallery/videos', 'public');
             }
     
             // Handle specifications
             $item->specification_name = json_encode($request->specification_name ?? []);
             $item->specification_value = json_encode($request->specification_value ?? []);
     
             $item->status = 'vendor';
             $item->save();
     
             DB::commit();
     
             return redirect()->route('vendor.products.create')->with('success', 'Product created successfully!');
         } catch (\Exception $e) {
             DB::rollBack();
             return redirect()->route('vendor.products.create')->with('error', 'There was an error creating the product.');
         }
     }
     
      
    
    

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        // Fetch the product by ID.
        $product = Item::findOrFail($id);
        // You can remove this line once you're done debugging.

        // Fetch categories that correspond to the product's categoryid.
        $categories = Category::where('Category_id', $product->categoryid)->get();

        // If you still want to fetch the vendor's category for some reason, you can use this:
        $vendor_id = auth()->user()->id;
        $vendor = VendorRegister::where('id', $vendor_id)->first();

        // You can still use this if you need to fetch categories based on the vendor's category
        $vendorCategories = Category::where('Category_id', $vendor->vendor_category_id)->get();
        //dd($vendorCategories);
        // Fetch all units.
        $units = Unit::orderBy('unit', 'asc')->get();


        // Fetch subcategories and child categories.
        $subcategories = Subcategory::where('category_id', $product->categoryid)->get();
        $childcategories = ChildCategory::where('subcategory_id', $product->subcategoryid)->get();

        // Decode specifications JSON into arrays for editable format.
        $specifications = json_decode($product->specification_name, true);
        $specification_values = json_decode($product->specification_value, true);

        // Pass variables to the view.
        return view('vendorlogin.products.edit', compact(
            'product',
            'categories',
            'subcategories',
            'childcategories',
            'specifications',
            'specification_values',
            'units',
            'vendorCategories'
        ));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, $id)
    {
        
        // Validate incoming request data.
        $request->validate([
            'categoryid'         => 'nullable|exists:category,Category_id',
            'subcategoryid'      => 'nullable|exists:subcategories,id',
            'childcategoryid'    => 'nullable|exists:child_categories,id',
            'product_name'       => 'required|string|max:255',
            'brand'              => 'nullable|string|max:255',
            'uom'                => 'required|exists:unit,id',
            'sales_price'        => 'required|numeric',
            'expiration_date'    => 'nullable|date',
            'product_image'      => 'nullable|image|max:2048',
            'tax'                => 'nullable|numeric',
            'specification_name.*' => 'nullable|string|max:255',
            'specification_value.*' => 'nullable|string|max:255',
        ]);

        
    
        // Fetch the product to update.
        $product = Item::findOrFail($id);
    
        // Get the unit abbreviation based on the selected uom id.
        $unit = Unit::findOrFail($request->uom);
        $product->uom = $unit->id;
    
        // Handle product image upload if exists.
        if ($request->hasFile('product_image')) {
            // Remove old image if exists
            if ($product->product_image && file_exists(storage_path('app/public/' . $product->product_image))) {
                unlink(storage_path('app/public/' . $product->product_image));
            }
            $product->product_image = $request->file('product_image')->store('products', 'public');
        }
    
        // Handle the gallery images update.
        if ($request->hasFile('gallery_images')) {
            $galleryImages = [];
            // Remove old gallery images if any
            if ($product->gallery_images) {
                $existingImages = json_decode($product->gallery_images, true);
                foreach ($existingImages as $image) {
                    if (file_exists(storage_path('app/public/' . $image))) {
                        unlink(storage_path('app/public/' . $image));
                    }
                }
            }
            // Store new images
            foreach ($request->file('gallery_images') as $image) {
                $galleryImages[] = $image->store('product_gallery', 'public');
            }
            $product->gallery_images = json_encode($galleryImages);
        }
    
        // Handle the gallery videos update.
        if ($request->hasFile('gallery_videos')) {
            $galleryVideos = [];
            // Remove old gallery videos if any
            if ($product->gallery_video) {
                $existingVideos = json_decode($product->gallery_video, true);
                foreach ($existingVideos as $video) {
                    if (file_exists(storage_path('app/public/' . $video))) {
                        unlink(storage_path('app/public/' . $video));
                    }
                }
            }
            // Store new videos
            foreach ($request->file('gallery_videos') as $video) {
                $galleryVideos[] = $video->store('gallery/videos', 'public');
            }
            $product->gallery_video = json_encode($galleryVideos);
        }
    
        // Handle the specifications.
        if ($request->has('specification_name') && is_array($request->specification_name)) {
            $specifications = [];
            foreach ($request->specification_name as $key => $name) {
                if (isset($request->specification_value[$key])) {
                    $specifications[] = [
                        'specification_name' => $name,
                        'specification_value' => $request->specification_value[$key],
                    ];
                }
            }
            if (!empty($specifications)) {
                $product->specification_name = json_encode(array_column($specifications, 'specification_name'));
                $product->specification_value = json_encode(array_column($specifications, 'specification_value'));
            }
        }
    
        // Update product details.
        // For subcategory and child category, use the helper method.
        $product->categoryid = $request->categoryid;
        $this->setCategoryFields($request, $product);
    
        $product->name = $request->product_name;
        $product->brand = $request->brand;
        $product->sales_price = $request->sales_price;
        $product->purchase_price = $request->sales_price;
        $product->expiration_date = $request->expiration_date;
        $product->tax = $request->tax;
     $product->description = $request->description;
    
        // If the sales price has changed, update the timestamp (assuming 'Date' is a valid field).
        if ($product->sales_price != $request->sales_price) {
            $product->Date = now();
        }
    
        $product->save();
    
        // Increment a session variable for edited vendor products.
        $editedProductCount = session('new_vendor_product_edited_count', 0);
        session(['new_vendor_product_edited_count' => $editedProductCount + 1]);
    
        // Redirect to the edit page with a success message.
        return redirect()->route('vendor.products.edit', $id)
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Display the specified product.
     */
    public function view($id)
    {
        // Fetch the product from the 'items' table
        $product = Item::findOrFail($id);
    
        // Fetch the unit from the 'unit' table where the unit ID matches the 'uom' from the 'items' table
        $unit = DB::table('unit')->where('id', $product->uom)->first();
    
        // If no unit is found, you can handle the error or return a default value
        $uom = $unit ? $unit->unit : 'Unknown';
    
        // Return the view with the product and UOM data
        return view('vendorlogin.products.view', compact('product', 'uom'));
    }
    
    /**
     * Redirect to the vendor dashboard.
     */
    public function index()
    {
        return redirect()->route('vendorlogin.auth.dashboard');
    }
    public function destroy($id)
    {
        $product = Item::find($id);
    
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }
    
        $product->delete();
    
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
    
    
    

}
