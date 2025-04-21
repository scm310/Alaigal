<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ChildCategory;
use App\Models\Item;
use App\Models\Unit;
use App\Models\VendorDetail;
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
        // Fetch the authenticated vendor's ID
        $vendor_id = auth()->user()->id;

        // Fetch the vendor's category IDs (could be a JSON string or a single value)
        $vendorCategoryIds = DB::table('vendor_details')
            ->where('id', $vendor_id)
            ->pluck('vendor_category_id')
            ->first();

        // Decode the JSON string to an array
        $vendorCategoryIdsArray = json_decode($vendorCategoryIds, true);

        // Initialize the categories collection
        $categories = collect();

        // If vendorCategoryIds is an array (i.e., multiple categories)
        if (is_array($vendorCategoryIdsArray) && !empty($vendorCategoryIdsArray)) {
            $categories = DB::table('category')
                ->whereIn('Category_id', $vendorCategoryIdsArray)
                ->get();
        } else {
            // Otherwise, treat it as a single category value
            $categories = DB::table('category')
                ->where('Category_id', $vendorCategoryIds)
                ->get();
        }

        // Fetch other data (like units, subcategories, etc.)
        $units = Unit::all();

        // Check if we have valid categories to fetch subcategories
        $subcategories = [];
        if ($categories->isNotEmpty()) {
            $firstCategoryId = $categories->first()->Category_id ?? null;
            if ($firstCategoryId) {
                $subcategories = Subcategory::where('category_id', $firstCategoryId)->get();
            }
        }

        // Fetch child categories for the subcategories
        $childcategories = [];
        if ($subcategories->isNotEmpty()) {
            $childcategories = ChildCategory::whereIn('subcategory_id', $subcategories->pluck('id'))->get();
        }

        // Return the view with all the fetched data
        return view('vendorlogin.products.create', compact(
            'categories',
            'units',
            'vendor_id',
            'subcategories',
            'childcategories'
        ));
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
            'brand'              => 'required|string|max:255',
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
        ]);

        DB::beginTransaction();
        try {
            // Generate a unique product ID.
            $lastItem = Item::latest('id')->first();
            $nextId = $lastItem ? $lastItem->id + 1 : 1;
            $product_id = 'PRO' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            // Get the logged-in vendor's ID.
            $vendor_id = auth()->user()->id;

            // Create a new item.
            $item = new Item();
            $item->product_id  = $product_id;
            $item->categoryid  = $request->categoryid;
            $item->name        = $request->product_name;
            $item->brand       = $request->brand;

            // Set subcategory and child category using the helper function.
            $this->setCategoryFields($request, $item);

            // Get the unit abbreviation based on the selected uom id.
            $unit = Unit::findOrFail($request->uom);
            $item->uom = $unit->abbreviation;
            $item->sales_price = $request->sales_price;
            $item->purchase_price = $request->sales_price;
            $item->expiration_date = $request->expiration_date;
            $item->tax = $request->tax;
            $item->description = $request->description;
            $item->vendor_id = $vendor_id;

            // Handle file upload for product image.
            if ($request->hasFile('product_image')) {
                $item->product_image = $request->file('product_image')->store('products', 'public');
            }

            // Handle file upload for gallery images.
            if ($request->hasFile('gallery_images')) {
                $galleryImages = [];
                foreach ($request->file('gallery_images') as $image) {
                    $galleryImages[] = $image->store('product_gallery', 'public');
                }
                $item->gallery_images = json_encode($galleryImages);
            }

            // Handle file upload for gallery video.
            if ($request->hasFile('gallery_video')) {
                $item->gallery_video = $request->file('gallery_video')->store('gallery/videos', 'public');
            }

            // Handle specification data.
            $specification_names = $request->specification_name ?? [];
            $specification_values = $request->specification_value ?? [];

            if (
                !empty($specification_names) && !empty($specification_values) &&
                count($specification_names) === count($specification_values)
            ) {
                $item->specification_name = json_encode($specification_names);
                $item->specification_value = json_encode($specification_values);
            } else {
                $item->specification_name = json_encode([]);
                $item->specification_value = json_encode([]);
            }

            // Set the status as 'vendor' and save the item.
            $item->status = 'vendor';
            $item->save();

            DB::commit();

            // Redirect with a success message.
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
        $vendor = VendorDetail::where('id', $vendor_id)->first();
        // You can still use this if you need to fetch categories based on the vendor's category
        $vendorCategories = Category::where('Category_id', $vendor->vendor_category_id)->get();
        //dd($vendorCategories);
        // Fetch all units.
        $units = Unit::all();

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
            'brand'              => 'required|string|max:255',
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
        $product->uom = $unit->abbreviation;
    
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
        $product->purchase_price = $request->purchase_price;
        $product->expiration_date = $request->expiration_date;
        $product->tax = $request->tax;
    
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
        $product = Item::findOrFail($id);
        return view('vendorlogin.products.view', compact('product'));
    }

    /**
     * Redirect to the vendor dashboard.
     */
    public function index()
    {
        return redirect()->route('vendorlogin.auth.dashboard');
    }
}
