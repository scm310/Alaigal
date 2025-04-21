<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ClientTestimonial;
use App\Models\Highlight;
use App\Models\Member;
use App\Models\Subcategory;
use App\Models\ChildCategory;
use App\Models\Banner;
use App\Models\Item;
use App\Models\FooterSetting;
use App\Models\ListingPage;
use App\Models\VendorRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryBanner;
use App\Models\ListingBanner;



class WebsiteController extends Controller
{
    // Home Page
    public function index()
    {

        $banners = Banner::orderBy('created_at', 'desc')->get();


        $results = DB::table('items')
        ->join('add_highlight', function ($join) {
            $join->whereRaw("JSON_CONTAINS(items.add_highlight, JSON_QUOTE(CAST(add_highlight.id AS CHAR)), '$')");
        })
        // Filter hot-selling products
        ->selectRaw('DISTINCT items.*, add_highlight.id as highlight_id, add_highlight.name as highlight_name')
        ->get();

    // Group products by highlight name
    $groupedProducts = $results->groupBy('highlight_name');


        return view('website.index',compact('banners','groupedProducts'));
    }

    // Contact Page
    public function contact()
    {
        return view('website.contact');
    }





    // Product Details Page
    public function productDetails()
    {


        return view('website.product_detail');
    }
    public function products(Request $request)
    {

        // Fetch products with the given condition
        $products = Item::with(['category', 'subcategory', 'childcategory', 'VendorRegister'])
            ->where(function ($query) {
                $query->where('status', 'admin')
                    ->orWhere('vendor_status', 'approved');
            })
            ->paginate(12);

        $listingbanner = ListingPage::all(); // Fetch all banners for products page.

        // Fetch child categories
        $childcategories = ChildCategory::all();

        return view('website.products', compact('products', 'childcategories', 'listingbanner'));
    }



 

    public function productsByCategory($category)
    {
        // Fetch products under the selected category
        $products = Item::with(['category', 'subcategory', 'childcategory', 'VendorRegister'])
            ->where(function ($query) {
                $query->where('status', 'admin')
                      ->orWhere('vendor_status', 'approved');
            })
            ->whereHas('category', function ($query) use ($category) {
                $query->where('Category_name', $category);
            })
            ->get();
    
        $listingbanner = ListingPage::all(); // Fetch all banners for products page.
    
        // Fetch child categories related to the selected category
        $childCategories = ChildCategory::whereHas('subcategory.category', function ($query) use ($category) {
            $query->where('Category_name', $category);
        })->with('subcategory.category')->get();
    
        // Fetch category-specific banners
        $banners = CategoryBanner::whereHas('category', function ($query) use ($category) {
            $query->where('Category_name', $category);
        })->get();
    
        // ✅ **Fix: Fetch listing banners specific to the selected category**
        $listing_banners = ListingBanner::whereHas('category', function ($query) use ($category) {
            $query->where('Category_name', $category);
        })->get();
    
        return view('website.products', compact('products', 'listingbanner', 'childCategories', 'banners', 'listing_banners'));
    }
    
    
    
    
    public function productsBySubcategory($category, $subcategory)
    {
        $formattedSubcategory = $subcategory;
    
        // Check if subcategory exists
        $foundSubcategory = SubCategory::where('name', $formattedSubcategory)->first();
        if (!$foundSubcategory) {
            return redirect()->back()->with('error', 'Subcategory not found.');
        }
    
        // Fetch products
        $products = Item::with(['category', 'subcategory', 'childcategory', 'VendorRegister'])
            ->where(function ($query) {
                $query->where('status', 'admin')
                    ->orWhere('vendor_status', 'approved');
            })
            ->whereHas('subcategory', function ($query) use ($formattedSubcategory) {
                $query->where('name', $formattedSubcategory);
            })
            ->get();
    
        // Fetch listing banners
        $listingbanner = ListingPage::all();
    
        // Fetch child categories
        $childCategories = ChildCategory::whereHas('subcategory', function ($query) use ($formattedSubcategory) {
            $query->where('name', $formattedSubcategory);
        })->with('subcategory.category')->get();
    
        // Fetch category-specific banners
        $banners = CategoryBanner::whereHas('category', function ($query) use ($category) {
            $query->where('Category_name', $category);
        })->get();
    
          // ✅ **Fix: Fetch listing banners specific to the selected category**
          $listing_banners = ListingBanner::whereHas('category', function ($query) use ($category) {
            $query->where('Category_name', $category);
        })->get();
    
        return view('website.products', compact('products', 'listingbanner', 'childCategories', 'banners', 'listing_banners'));
    }
    
    public function productsByChildCategory($category, $subcategory, $childcategory)
    {
        $normalizedChildCategory = $childcategory;
    
        // Fetch selected child category
        $selectedChildCategory = ChildCategory::where('name', $normalizedChildCategory)->first();
        if (!$selectedChildCategory) {
            abort(404, 'Child category not found.');
        }
    
        // Fetch child categories within the same subcategory
        $childCategories = ChildCategory::where('subcategory_id', $selectedChildCategory->subcategory_id)->get();
    
        // Fetch products under the selected child category
        $products = Item::with(['category', 'subcategory', 'childcategory', 'VendorRegister'])
            ->where(function ($query) {
                $query->where('status', 'admin')
                    ->orWhere('vendor_status', 'approved');
            })
            ->whereHas('childcategory', function ($query) use ($normalizedChildCategory) {
                $query->where('name', $normalizedChildCategory);
            })
            ->get();
    
        $listingbanner = ListingPage::all(); // Fetch all banners for products page.
    
        // Fetch category-specific banners
        $banners = CategoryBanner::whereHas('category', function ($query) use ($category) {
            $query->where('Category_name', $category);
        })->get();
    
        // Fetch category-specific listing banners
         // ✅ **Fix: Fetch listing banners specific to the selected category**
         $listing_banners = ListingBanner::whereHas('category', function ($query) use ($category) {
            $query->where('Category_name', $category);
        })->get();
    
        // Return the view with data
        return view('website.products', compact('products', 'childCategories', 'selectedChildCategory', 'listingbanner', 'banners', 'listing_banners'));
    }
    
    

// *ADD TO Cart  Start ***cj

public function addToCart(Request $request)
{
    // Check if the user is logged in
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $productId = $request->input('product_id');
    $quantity = $request->input('quantity');

    // Get product details from the database (assuming you have a Product model)
    $product = item::where('id', $productId)->first();  // Use first() to get a single product

    $gst = $product->tax / 2;

    if ($product) {
        // Store the product in the session
        $cart = session()->get('cart', []);

        // Check if the product is already in the cart
        if (isset($cart[$productId])) {
            // Increase the quantity if the product is already in the cart
            $cart[$productId]['quantity'] += $quantity;
        } else {
            // Add the product to the cart
            $cart[$productId] = [
                'id' => $product->id,
                'product_name' => $product->name,  // Accessing the 'name' property of the product
                'quantity' => $quantity,
                'price' => $product->sales_price,
                'image' => $product->product_image,
                "specification_name" => json_decode($product->specification_name, true),
                "specification_value" => json_decode($product->specification_value, true),
                "tax" => $product->tax,
                "gst" => $gst,
            ];
        }

        // Update the cart in the session
        session()->put('cart', $cart);

        // Logic for adding the product to the user's quote
        $user = auth()->user();
        $user->customerQuotations()->create([  // Use customerQuotations method here
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_details' => $product->details,  // Make sure to have 'details' field in product table
            'price' => $product->sales_price,
            'quantity' => $quantity,
            'sgst' => $gst,  // You can calculate the SGST value based on your logic
            'cgst' => $gst,  // You can calculate the CGST value based on your logic
            'subtotal' => $product->sales_price * $quantity,  // Total price for the selected quantity
            'user_id' => $user->id,  // Ensure you're adding the correct user ID to the quote
        ]);

        // Return a success response
        return response()->json(['success' => true, 'message' => 'Product added to cart and quote!']);
    }

    // Return an error response if product is not found
    return response()->json(['success' => false, 'message' => 'Product not found']);
}




  // Cart Page
  public function cart()
  {

      return view('website.cart');
  }

  public function updateQuantity(Request $request)

  {
      $cart = session('cart', []);
      $productId = $request->input('product_id');
      $quantity = (int) $request->input('quantity');


      if (isset($cart[$productId])) {
          $cart[$productId]['quantity'] = $quantity;

          // Calculate values
          $price = $cart[$productId]['price'];
          $gst = $cart[$productId]['gst'];
          $tax = $cart[$productId]['tax'];
          $rowSubtotal1 = $price * $quantity;
          $rowSubtotal = $rowSubtotal1 + ( $rowSubtotal1 * $tax) / 100;

          $cgst = $price * $gst / 100;
          $sgst = $price * $gst / 100;

          // Update session
          session(['cart' => $cart]);

          // Recalculate cart totals
          $subtotal = 0;
          $totalCgst = 0;
          $totalSgst = 0;
          foreach ($cart as $item) {
              $subtotal += $item['price'] * $item['quantity'];
              $totalCgst += ($item['price'] * $item['gst'] / 100) * $item['quantity'];
              $totalSgst += ($item['price'] * $item['gst'] / 100) * $item['quantity'];
          }
          $total = $subtotal + $totalCgst + $totalSgst;

          return response()->json([
              'success' => true,
              'rowSubtotal' => $rowSubtotal,
              'cgst' => $cgst * $quantity,
              'sgst' => $sgst * $quantity,
              'gst' => $gst,
              'subtotal' => $subtotal,
              'totalCgst' => $totalCgst,
              'totalSgst' => $totalSgst,
              'total' => $total,
          ]);
      }

      return response()->json(['success' => false, 'message' => 'Product not found in cart.']);
  }






// delete
public function removeProduct($productId)
    {

        $cart = session()->get('cart', []);

        // Check if the product exists in the cart
        if (isset($cart[$productId])) {
            // Remove the product from the cart
            unset($cart[$productId]);

            // Store the updated cart back into the session
            session()->put('cart', $cart);
        }

        // Return a response indicating success or failure
        return response()->json(['success' => true]);

    }

   public function getCartSummary()
    {
        // Get cart data from session
        $cart = session('cart', []);

        $subtotal = 0;
        $totalItems = 0 ;
        $totalSgst = 0;
        $totalCgst = 0;
        $discount = 0;

        // Iterate through the cart to calculate totals
        foreach ($cart as $productId => $product) {
            $quantity = $product['quantity'] ?? 0;
            $price = $product['price'] ?? 0;



            // Determine the applicable price
            $offerPrice = $price;
            $productSubtotal = $offerPrice * $quantity;

            // Calculate discount
            $discount += ($price - $offerPrice) * $quantity;

            // Get GST (tax) percentage from the cart data
            $taxPercentage = $product['tax'] ?? 18; // Default 18% GST (9% SGST, 9% CGST)
            $sgstRate = $taxPercentage / 2 / 100;  // Half of GST percentage
            $cgstRate = $taxPercentage / 2 / 100;

            // Calculate SGST and CGST for the product
            $productSgst = $productSubtotal * $sgstRate;
            $productCgst = $productSubtotal * $cgstRate;

            // Add to cumulative totals
            $subtotal += $productSubtotal;
            $totalSgst += $productSgst;
            $totalCgst += $productCgst;

        }

        if (!empty($cart)) {
            $totalItems += is_countable($cart) ? count($cart) : 0;
        }
        // Calculate total including GST
        $total = $subtotal + $totalSgst + $totalCgst;



        return response()->json([
            'subtotal' => $subtotal,
            'sgst' => $totalSgst,
            'cgst' => $totalCgst,
            'total' => $total,
            'totalItems' => $totalItems,
        ]);
    }



    public function getUniqueItemCount()
    {
        // Retrieve cart data from session
        $cartItems = session('cart', []);

        // Get the number of unique items (keys in the cart array)
        $itemCount = count($cartItems);

        // Return the count as JSON
        return response()->json(['unique_count' => $itemCount]);
    }

    public function downloadPdf()
{
    // Retrieve the PDF content from session
    $pdfContent = session('pdf_content');

    if ($pdfContent) {
        // Return the PDF content as a downloadable file
        return response($pdfContent, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="invoice.pdf"');
    }

    return redirect()->route('generate.invoice')->with('error', 'Invoice not generated. Please generate it first.');
}



public function addcart(Request $request)
{
    // Example: Store cart item in session or database
    $cart = session()->get('cart', []);
    $cart[] = $request->all();
    session()->put('cart', $cart);

    return response()->json(['success' => true, 'message' => 'Item added to cart']);
}
// *ADD TO Cart  end ***cj



public function vendor()
{
    $testimonials = ClientTestimonial::latest()->get();
    return view('website.vendor', compact('testimonials'));
}


//category in mobile response

public function showSubcategories($categoryId)
{
    $category = Category::findOrFail($categoryId);
    $product = Item::where('categoryid', $categoryId)->get(); // Corrected where condition

    $subcategories = Subcategory::where('category_id', $categoryId)->get();


    return view('frontend.parital.msubcategory', compact('category', 'subcategories','product'));
}

// Show child categories page
public function showChildCategories($subcategoryId)
{
    $subcategory = Subcategory::findOrFail($subcategoryId);
    $product = Item::where('subcategoryid',$subcategoryId )->get();
    $childCategoriesm = ChildCategory::where('subcategory_id', $subcategoryId)->get();

    return view('frontend.parital.mchildcategory', compact('subcategory', 'childCategoriesm','product'));
}


public function memberProducts($member_id)
{
    $member = Member::findOrFail($member_id); // Fetch the member details

    // Fetch only products
    $products = Item::where('member_id', $member_id)
                    ->where('product_status', 'product') // Only fetch products
                    ->get();

    // Fetch only services
    $services = Item::where('member_id', $member_id)
                    ->where('product_status', 'service') // Only fetch services
                    ->get();

    // Ensure child categories are set (even if empty)
    $childCategories = collect();

    return view('website.member-products', compact('member', 'products', 'childCategories', 'services'));
}



public function showProductsWithBanners()
{
    $banners = CategoryBanner::all(); // Fetch all banners
    return view('website.products', compact('banners')); // Pass banners to the view
}



}
