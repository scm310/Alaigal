<?php
use App\Http\Controllers\ChildCategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MemberProfileController;
use App\Http\Controllers\MemberLoungeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MyaskController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\ClientSearchController;
use App\Http\Controllers\HeadersettingController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ApprovememberController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\VendorDetailDashboardController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HighlightController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\VendorDetailController;

use App\Http\Controllers\Searchcontroller;
use App\Http\Controllers\VendorItemController;
use App\Http\Controllers\ReferenceController;

use App\Http\Controllers\VendorAuthController;
use App\Http\Controllers\VendorDashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\FooterSettingController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\ProductDescriptionController;
use App\Http\Controllers\ListingPageController;

 use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\HomepageCategoryController;
// use App\Http\Controllers\SuperAdminAuthController;
// use App\Http\Controllers\SuperAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\RegisterController;

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\CustomerSupportController;
use App\Http\Controllers\VendorRegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ThanksnoteController;
use App\Http\Controllers\BottomBannerController;
use App\Http\Controllers\ClientTestimonialController;
use App\Http\Controllers\HomepageBannerController;
use App\Http\Controllers\CategoryBannerController;
use App\Http\Controllers\ListingBannerController;


/*

|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/send-email/{id}', [MailController::class, 'sendmailcontent']);
//user
Route::get('/pcs', [UserController::class, 'index'])->name('user.index1');
Route::get('/about', [UserController::class, 'about'])->name('user.about');
Route::get('/contact', [UserController::class, 'contact'])->name('user.contact');
Route::get('/gallery', [UserController::class, 'gallery'])->name('user.gallery');
Route::get('/login', [UserController::class, 'login'])->name('user.login');

Route::get('/test', function () {
    return view('admin.vehiclecreate');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/notifications/editedVendorProducts', [DashboardController::class, 'viewEditedVendorProducts'])->name('notifications.editedVendorProducts');

    Route::get('/path-to-vehicle-list-api', [DashboardController::class, 'getVehicleList']);
    Route::get('/path-to-vehicle-list-apis', [DashboardController::class, 'getVehicleLists']);
    Route::get('/users', [UserController::class, 'user'])->name('users.manage')->middleware('auth');
    Route::get('/user/create', [UserController::class, 'create'])->name('admin.user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/create-role', [UserController::class, 'createRole'])->name('user.createRole');
    Route::post('/user/storeRole', [UserController::class, 'storeRole'])->name('role.store');
    // web.php

    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');




    /*PermissionController routes*/ 

    Route::get('/manage-permissions', [PermissionController::class, 'managePermissions'])->name('permissions.manage');

    Route::get('/permissions', [PermissionController::class, 'showPermissionsForm'])->name('permissions.index');
    Route::post('/permissions/assign', [PermissionController::class, 'assignPermissions'])->name('permissions.assign');

    Route::get('/permissions/role/{roleId}', [PermissionController::class, 'getPermissionsByRole']);

// PermissionController end




    //SettingController
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
   
    // Update UOM Route
    Route::post('/settings/updateuom', [SettingController::class, 'updateuom'])->name('settings.updateuom');

    // Delete UOM Route
    Route::delete('/settings/destroy-uom/{id}', [SettingController::class, 'destroyuom'])->name('settings.destroyuom');
//SettingController END



    //ItemController Start

    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');  // Show individual item
    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');

    // Add the search route for items
    Route::get('/items/search', [ItemController::class, 'search'])->name('items.search');
    Route::get('/items/compare/{id}', [ItemController::class, 'compare'])->name('items.compare');

    // highlight
    Route::post('/item/update-status', [ItemController::class, 'updateProductStatus'])->name('update.product.status');
    //show highlight 
    Route::get('/get-product-data/{productId}', [ItemController::class, 'getProductData']);

    Route::get('items/create', [ItemController::class, 'create'])->name('items.create');
    Route::get('/get-subcategories/{category_id}', [ItemController::class, 'fetchSubcategories']);
    Route::get('/get-childcategories/{subcategory_id}', [ItemController::class, 'fetchChildCategories']);


    Route::get('/get-subcategories', [ItemController::class, 'getSubcategories']);
    Route::get('/getchildcategories/{subcategoryId}', [ItemController::class, 'getChildCategories']);

    Route::get('/get-subcategories/{categoryId}', [ItemController::class, 'getSubcategories']);

 

//ItemController end


//NotificationController start
    //new one (31/12/24)
    Route::get('/notifications/newVendorProducts', [NotificationController::class, 'newVendorProducts'])->name('notifications.newVendorProducts');
    // In routes/web.php
    Route::get('/mark-vendor-products-seen', [NotificationController::class, 'markVendorProductsAsSeen'])->name('markVendorProductsAsSeen');
    // In routes/web.php
    Route::get('/mark-vendor-products-seen', [DashboardController::class, 'markVendorProductsAsSeen'])->name('markVendorProductsAsSeen');

    Route::post('/notifications/mark-as-seen', [NotificationController::class, 'markAsSeen'])->name('notifications.markAsSeen');

    Route::post('/mark-as-seen', [NotificationController::class, 'markAsSeen']);

    /// Fixing of Margin for vendor prodect 21/01/2025
    Route::put('/product/updatePricing/{id}', [NotificationController::class, 'updatePricing'])->name('product.updatePricing');

     //notifications
     Route::put('/product/{id}/update-status', [NotificationController::class, 'updateStatus'])->name('product.updateStatus');
    //new one (31/12/24)
    Route::get('/notifications/newVendorProducts', [NotificationController::class, 'newVendorProducts'])->name('notifications.newVendorProducts');

    //fixing of margin update
    Route::post('/update-product', [NotificationController::class, 'updateProduct'])->name('updateProduct');
    //product status update
    Route::post('/update-product-status', [NotificationController::class, 'updatevendorStatus'])->name('update.vendorproduct.status');
    
});

//NotificationController end


    Route::get('/privacy-policy', function () {
        return view('privacy-policy');  // Replace 'privacy-policy' with your actual view name
    })->name('privacy-policy');


    // //new category adding in vendor page (31/12/24)
  
    // In routes/web.php
    Route::get('/vendor-details/create', function () {
        return view('vendor_details.create');
    })->name('vendor-details.create');


   
    Route::get('/get-subcategories/{categoryId}', function ($categoryId) {
        $subcategories = DB::table('subcategories')
            ->where('category_id', $categoryId)
            ->select('id', 'name')
            ->get();

        return response()->json($subcategories);
    });

    Route::get('/get-child-categories/{subcategoryId}', function ($subcategoryId) {
        $childCategories = DB::table('child_categories')
            ->where('subcategory_id', $subcategoryId)
            ->select('id', 'name')
            ->get();

        return response()->json($childCategories);
    });




//VendorDashboardController start
    // Dashboard routes (vendor login side)
    Route::middleware('auth:vendor')->group(function () {
        Route::get('/vendor/dashboard', [VendorDashboardController::class, 'index'])->name('vendorlogin.auth.dashboard');
        Route::get('/vendor/products/{id}/details', [VendorDashboardController::class, 'getProductDetails'])->name('vendor.products.details');
        Route::delete('/vendor/products/{id}', [VendorDashboardController::class, 'deleteProduct'])->name('vendor.products.delete');
    });
    // Vendor Dashboard Route (protected by vendor.auth middleware)
Route::middleware('auth:vendor')->get('/vendor/dashboard', [VendorDashboardController::class, 'index'])->name('vendorlogin.auth.dashboard');
Route::middleware('auth:vendor')->get('/vendor/products', [VendorDashboardController::class, 'product'])->name('vendor-product');
// VendorDashboardController end
   


    //07-01-2025 VendorItemController start
    Route::get('/vendor-items/autocomplete/vendor', [VendorItemController::class, 'autocompleteVendor'])->name('vendor_items.autocomplete.vendor');
    Route::get('/vendor-items/autocomplete/product', [VendorItemController::class, 'autocompleteProduct'])->name('vendor_items.autocomplete.product');
    Route::get('/vendor-items', [VendorItemController::class, 'index'])->name('vendor_items.index');
    Route::get('/vendor-items', [VendorItemController::class, 'index'])->name('vendor-items.index');
// VendorItemController end 



    //BannerController start
    Route::get('/banner/upload', [BannerController::class, 'uploadForm'])->name('banner.uploadForm');

    Route::get('/homepage-settings/banner', [BannerController::class, 'show'])->name('homepage_settings.banner');

    Route::get('/homepage-settings/banners', [BannerController::class, 'index'])->name('homepage_settings.banners');

    Route::get('/homepage-settings/index', [BannerController::class, 'showBanners'])->name('homepage_settings.showBanners');

    // Route for showing the banner upload form
    Route::get('/banner', [BannerController::class, 'uploadForm'])->name('banner.uploadForm');
    // Route for handling the banner upload submission
    Route::post('/banner/upload', [BannerController::class, 'upload'])->name('banner.upload');
    Route::get('banner/upload', [BannerController::class, 'uploadForm'])->name('banner.uploadForm');
    Route::get('banners', [BannerController::class, 'show'])->name('banner.show');
    Route::get('banners/edit/{id}', [BannerController::class, 'edit'])->name('banner.edit');
    Route::post('banners/update/{id}', [BannerController::class, 'update'])->name('banner.update');
    Route::delete('banners/delete/{id}', [BannerController::class, 'destroy'])->name('banner.destroy');
// BannerController end 




    //footer settings
    //10-01-2025 for FooterSetting
    Route::get('footer/show', [FooterSettingController::class, 'show'])->name('footer.show');
    Route::post('footer/update', [FooterSettingController::class, 'update'])->name('footer.update');
   



    //LogoController
    Route::post('/logos/store-logo', [LogoController::class, 'storeLogo'])->name('logos.storeLogo');
    Route::post('/logos/store-favicon', [LogoController::class, 'storeFavicon'])->name('logos.storeFavicon');
    Route::put('/logos/{id}/update-heading', [LogoController::class, 'updateHeading'])->name('logos.updateHeading');
    Route::get('/logos', [LogoController::class, 'index'])->name('logos.index');
Route::post('/logos/admin-name', [LogoController::class, 'storeAdminName'])->name('logos.storeAdminName');
Route::post('/logos/admin-logo', [LogoController::class, 'storeAdminLogo'])->name('logos.storeAdminLogo');
//LogoController end




//ListingPageController start

    //product isting page banner (admin)-22/01/25
    Route::get('/homepage-settings/listingpage', [ListingPageController::class, 'index'])->name('listingpage.index');
    Route::post('/homepage-settings/listingpage/upload', [ListingPageController::class, 'upload'])->name('listingbanner.upload');
    Route::delete('/homepage-settings/listingpage/{id}', [ListingPageController::class, 'destroy'])->name('listingbanner.destroy');
    Route::post('/listingpage/upload', [ListingPageController::class, 'store'])->name('listingpage.upload');
    Route::resource('listingpage', ListingPageController::class);
    // Display the edit form
    Route::get('listingpagebanners/edit/{id}', [ListingPageController::class, 'edit'])->name('listingpage.edit');
    // Update the banner (POST or PUT)
    Route::put('listingpagebanners/update/{id}', [ListingPageController::class, 'update'])->name('listingbanner.update');
//ListingPageController end







// VendorAuthController start
Route::get('/vendor/login', [VendorAuthController::class, 'showLoginForm'])->name('vendor.login');
Route::post('/vendor/login', [VendorAuthController::class, 'login'])->name('vendor.login.submit');
Route::post('/vendor/logout', [VendorAuthController::class, 'logout'])->name('vendor.logout');
// VendorAuthController end




//WebsiteController start

Route::get('/', [WebsiteController::class, 'index'])->name('home');

Route::get('/contact', [WebsiteController::class, 'contact'])->name('contact');
Route::get('/products', [WebsiteController::class, 'products'])->name('products');
Route::get('/cart', [WebsiteController::class, 'cart'])->name('cart');
Route::get('/member-products/{member_id}', [WebsiteController::class, 'memberProducts'])->name('member.products');
//product listing page 
Route::get('/products', [WebsiteController::class, 'products'])->name('products');
Route::get('/product/{id}', [WebsiteController::class, 'productDetail'])->name('product.detail');

Route::get('/products/{category}', [WebsiteController::class, 'productsByCategory'])->name('products.category');
Route::get('/products/{category}/{subcategory}', [WebsiteController::class, 'productsBySubcategory'])->name('products.subcategory');
Route::get('/product/{category}/{subcategory}/{childcategory}', [WebsiteController::class, 'productsByChildCategory'])->name('products.childcategory');
Route::get('/products/{category}/{subcategory}/{childcategory}', [WebsiteController::class, 'productsByChildCategory'])->name('products.byChildCategory');

//add to quote route 
Route::post('/add-to-cart', [WebsiteController::class, 'addToCart'])->name('addToCart');

Route::get('/cart-unique-count', [WebsiteController::class, 'getUniqueItemCount']);

Route::delete('/cart/remove/{productId}', [WebsiteController::class, 'removeProduct'])->name('cart.remove');

//search updated(28/01/25)
Route::get('/search', [SearchController::class, 'search'])->name('product.search');
Route::get('/search-suggestions', [SearchController::class, 'getSearchSuggestions'])->name('search.suggestions');

Route::get('/download-pdf', [WebsiteController::class, 'downloadPdf'])->name('download.pdf');
Route::post('/cart/update-quantity', [WebsiteController::class, 'updateQuantity'])->name('cart.updateQuantity');
//***total purchase
Route::get('/cart-summary', [WebsiteController::class, 'getCartSummary'])->name('cart.summary');

Route::get('website.vendor', [WebsiteController::class, 'vendor'])->name('vendor');

//WebsiteController end





//ProductDescriptionController start 
Route::get('/product/{id}', [ProductDescriptionController::class, 'show'])->name('product.detail');

Route::get('/product', [ProductDescriptionController::class, 'productDetails'])->name('product_detail');

 Route::middleware(['auth:web'])->group(function () {
    Route::get('/product/details/{id}', [ProductDescriptionController::class, 'show'])->name('product.details');
});
Route::get('/product/details/{id}', [ProductDescriptionController::class, 'show'])->name('product.details');
//ProductDescriptionController end 
 

//HomepageCategoryController start
Route::get('/homepage-settings/categories', [HomepageCategoryController::class, 'index'])->name('homepage.categories');
Route::post('/homepage-settings/categories/update', [HomepageCategoryController::class, 'update'])->name('homepage.categories.update');

//highight settings
Route::get('/highlight-product', [HomepageCategoryController::class, 'producthighlight'])->name('highlightproduct');

Route::post('/update-highlight', [HomepageCategoryController::class, 'updateHighlight'])->name('highlight.update');
// HomepageCategoryController end


Route::post('/store-user-details', function (Request $request) {
    // Validate form input
    $request->validate([
        'user_name' => 'required',
        'company_name' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
        'location' => 'required',
    ]);

    // Store user details in session
    Session::put('user_details', [
        'user_name' => $request->user_name,
        'company_name' => $request->company_name,
        'phone' => $request->phone,
        'email' => $request->email,
        'location' => $request->location,
    ]);

    return redirect()->back(); // Reload cart page
})->name('store.user.details');


Route::get('/vendor/quotes', function () {
    return view('vendorlogin.auth.vendorquote');
})->name('vendor.quotes');



// RegisterController start
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [RegisterController::class, 'login'])->name('login');
// RegisterController end




//ProductController start
// Vendor Product Management Routes (Only authenticated vendors can access these)
Route::middleware(['auth:vendor'])->group(function () {
    // Route to create a product
    Route::get('/vendor/products/create', [ProductController::class, 'create'])->name('vendor.products.create');
    
    // Route to store a new product
    Route::post('/vendor/products/store', [ProductController::class, 'store'])->name('vendor.products.store');
    
    // Route to edit an existing product
    Route::get('/vendor/products/edit/{id}', [ProductController::class, 'edit'])->name('vendor.products.edit');
    
    // Route to update an existing product
    Route::put('/vendor/products/update/{id}', [ProductController::class, 'update'])->name('vendor.products.update');
    
    // Route to view product details (can be customized based on your use case)
    Route::get('/vendor/products/{id}/details', [ProductController::class, 'showDetails']);
});

// Public Route for Viewing Product (No Authentication Required)
Route::get('vendor/products/{id}/view', [ProductController::class, 'view'])->name('vendor.products.view');

// Vendor Dashboard (Only authenticated vendors can access)
Route::middleware('auth:vendor')->get('/vendordashboard', [ProductController::class, 'index'])->name('vendordashboard');

Route::delete('/vendor/products/{id}', [ProductController::class, 'destroy'])->name('vendor.products.delete');
Route::get('/website/terms', function () {
        return view('website.terms');
    })->name('terms');
    


    Route::get('/terms', function () {
        return view('auth.terms');
    })->name('terms');


  Route::get('/update-vendor-status', [ProductController::class, 'updateVendorStatus']);
// ProductController end



// VendorDetailDashboardController start
// Vendor Details Routes (Only authenticated vendors can access)
Route::middleware('auth:vendor')->get(
    '/vendor/details/{id}',
    [VendorDetailDashboardController::class, 'show']
)->name('vendor.details.show');

// Update Vendor Information (Only authenticated vendors can access)
Route::put('vendor/{id}/update', [VendorDetailDashboardController::class, 'update'])->name('vendor.updateform');
Route::post('/vendor/notifications/read/{id}', [VendorDetailDashboardController::class, 'markNotificationAsRead'])->name('vendor.notifications.read');
// VendorDetailDashboardController end 





// ApprovalController start
Route::get('/approval', [ApprovalController::class, 'index'])->name('approval.index');
Route::get('/approval/vendor', [ApprovalController::class, 'vendorApproval'])->name('approval.vendor');
Route::get('/approval/category', [ApprovalController::class, 'categoryApproval'])->name('approval.category');
Route::get('/approval/vendor/view/{id}', [ApprovalController::class, 'vendorView'])->name('approval.vendor.view');
// Routes for approval actions
Route::post('/approval/vendor/approve/{id}', [ApprovalController::class, 'approveVendor'])->name('approval.vendor.approve');
Route::post('/approval/vendor/reject/{id}', [ApprovalController::class, 'rejectVendor'])->name('approval.vendor.reject');

Route::post('/approval/vendor/deactivate/{id}', [ApprovalController::class, 'deactivateVendor'])->name('approval.vendor.deactivate');
Route::post('/approval/vendor/update-status/{id}', [ApprovalController::class, 'updateVendorStatus'])->name('approval.vendor.updateStatus');
Route::post('/approval/category/update/{id}', [ApprovalController::class, 'updateCategoryStatus'])->name('approval.category.update');
    
Route::get('/approval', [ApprovalController::class, 'index'])->name('approval.index');
Route::get('/approval/approved-vendors', [ApprovalController::class, 'approvedVendors'])->name('approval.approved');
Route::get('/approval/rejected-vendors', [ApprovalController::class, 'rejectedVendors'])->name('approval.rejected');
// ApprovalController end




//UnitController start
Route::get('units', [UnitController::class, 'index'])->name('units.index');
Route::post('/units', [UnitController::class, 'store'])->name('units.store');
Route::get('/units/{id}/edit', [UnitController::class, 'edit'])->name('units.edit');
Route::put('/units/{id}', [UnitController::class, 'update'])->name('units.update');
Route::delete('/units/{id}', [UnitController::class, 'destroy'])->name('units.destroy');
// UnitController end




//EnquiryController start
    //description page schedule a call form route 
Route::post('/enquiry/store', [EnquiryController::class, 'store'])->name('enquiry.store');
Route::get('/schedule-call', [EnquiryController::class, 'scheduleCall'])->name('schedule-call');
// EnquiryController end





//CustomerSupportController start
Route::post('/customer-support', [CustomerSupportController::class, 'store'])->name('customer.support.store');
Route::get('/vendor/customer-support', function () {
    return view('vendorlogin.auth.customer_support');
})->name('customer.support.view');

// Route to handle form submission
Route::post('/support/store', [CustomerSupportController::class, 'store'])->name('support.store');
Route::get('/customer_support/{id}/close', [CustomerSupportController::class, 'close'])->name('customer_support.close');
Route::delete('/customer_support/{id}', [CustomerSupportController::class, 'destroy'])->name('customer_support.delete');

Route::get('/vendors-request', [CustomerSupportController::class, 'showVendorRequests'])->name('vendors.request');
//CustomerSupportController end



Route::get('/dashboard', [DashboardController::class, 'Dashboard']);


//VendorRegisterController start
Route::put('/vendor/update/{id}', [VendorRegisterController::class, 'update'])->name('vendor.update');
Route::post('/member/register', [VendorRegisterController::class, 'websitememberregister'])->name('vendor.register.submit');
Route::post('/vendor/register', [VendorRegisterController::class, 'store'])->name('vendor.register');
// VendorRegisterController end




Route::get('/welcomepage', function () {
    return view('welcome');
});


Route::get('/signup', function () {
    return "Sign-up page here"; 
})->name('member.signup');


// Show login form

//AuthController Start
Route::get('/memberdirectory', [AuthController::class, 'index'])->name('memberlogin');
Route::post('/memberlogin', [AuthController::class, 'loginSubmit'])->name('member.login.submit');

// Member Logout
Route::post('/memberlogout', [AuthController::class, 'memberlogout'])->name('memberlogout');
// Display the registration page
Route::get('/memberregister', [AuthController::class, 'showRegisterForm'])->name('memberregister');

// Handle the registration form submission
Route::post('/memberregister', [AuthController::class, 'memberregister'])->name('register.submit');

Route::post('/adminlogin', [AuthController::class, 'login'])->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
//AuthController end


// HomeController Start
Route::get('/memberdashboard', [HomeController::class, 'memberdashboard'])
    ->name('memberdashboard')
    ->middleware('auth:member');
    
    Route::delete('/notifications/{id}', [HomeController::class, 'removeNotification'])->name('notifications.remove');

    Route::post('/update-prime-popup', [HomeController::class, 'updatePrimePopup'])->name('update.prime_popup');
// HomeController end





//SubscriptionController start

Route::middleware('auth:member')->group(function () {
    Route::get('/subscription/payment', [SubscriptionController::class, 'showPaymentPage'])->name('subscription.payment');
    Route::post('/subscription/process', [SubscriptionController::class, 'processPayment'])->name('subscription.processPayment');
    Route::get('/subscription/verify/member', [SubscriptionController::class, 'verifyPaymentMemberDirectory'])->name('subscription.verifyMember');
Route::get('/subscription/verify/marketplace', [SubscriptionController::class, 'verifyPaymentMarketplace'])->name('subscription.verifyMarketplace');
Route::get('/subscription/verify/both', [SubscriptionController::class, 'verifyPaymentBoth'])->name('subscription.verifyBoth');

    Route::get('/subscription/history', [SubscriptionController::class, 'paymentHistory'])->name('subscription.history');
    Route::post('/subscription/generate-invoice', [SubscriptionController::class, 'generateInvoice'])
    ->name('subscription.generateInvoice');

Route::get('/subscription/download-invoice/{filename}', [SubscriptionController::class, 'downloadGeneratedInvoice'])
    ->name('subscription.downloadInvoice');
     Route::get('/subscription/invoice/{id}', [SubscriptionController::class, 'downloadInvoice'])
        ->name('subscription.invoice');
Route::get('/debug-send-notifications', [SubscriptionController::class, 'sendDailyNotifications']);


});

// SubscriptionController end


//MyaskController start

//my ask(member login) (priya(29-01-2025))

Route::get('/ask', [MyaskController::class, 'showForm'])->name('ask.form');

Route::post('/ask/submit', [MyaskController::class, 'submitForm'])->name('ask.submit');

Route::get('/askreport', [MyaskController::class, 'showSubmittedQuestions'])->name('ask.report');
Route::delete('/ask/{id}', [MyaskController::class, 'destroy'])->name('ask.destroy');
Route::get('/asklist', [MyaskController::class, 'askList'])->name('ask.list');
Route::get('/admin/my-ask/asklist', [MyAskController::class, 'index'])->name('admin.ask.list');

//MyaskController end


//MemberProfileController start
Route::middleware(['auth:member'])->group(function () {
    Route::get('/profile', [MemberProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [MemberProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/products/save', [MemberProfileController::class, 'saveProducts'])->name('products.save');
    Route::post('/profile/services/save', [MemberProfileController::class, 'saveServices'])->name('services.save');
    Route::post('/profile/clients/save', [MemberProfileController::class, 'saveClients'])->name('clients.save');
    Route::post('/profile/testimonials/save', [MemberProfileController::class, 'saveTestimonials'])->name('testimonials.save');
    Route::post('/profile/projects/save', [MemberProfileController::class, 'saveProjects'])->name('projects.save');
});

// MemberProfileController end




//MemberLoungeController start

Route::get('/member-lounge', [MemberLoungeController::class, 'index'])->name('memberlounge.member.lounge');
Route::get('/member-profile/{id}', [MemberLoungeController::class, 'viewProfile']);
// MemberLoungeController end 




//adminlogin controller  start
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/dashboard', [AdminLoginController::class, 'dashboard'])->name('admin.dashboard');
//AdminLoginController end




// HeadersettingController start

Route::delete('admin/banner/{id}', [HeadersettingController::class, 'destroy'])->name('admin.banner.delete');
//delete logo&title  on 04-02-2025 priya

Route::delete('/admin/logo/{id}', [HeadersettingController::class, 'destroyLogo'])->name('admin.logo.delete');
//header setting
Route::get('/admin/headersetting/addbanner', [HeadersettingController::class, 'addbanner'])->name('admin.headersetting.addbanner');
Route::get('/admin/headersetting/addlogo', [HeadersettingController::class, 'addlogo'])->name('admin.headersetting.addlogo');
Route::post('/admin/banner/store', [HeadersettingController::class, 'storeBanner'])->name('admin.banner.store');
Route::post('/admin/headersetting/store', [HeadersettingController::class, 'storeHeader'])->name('admin.header.store');
Route::post('/admin/header-setting/uploadBanner', [HeaderSettingController::class, 'uploadBanner'])->name('header-setting.uploadBanner');
Route::get('/admin/header-setting/customer-banner', [HeaderSettingController::class, 'showCustomerBanner'])->name('header-setting.customerBanner');
Route::post('/admin/header-setting/customer-banner/upload', [HeaderSettingController::class, 'uploadCustomerBanner'])->name('header-setting.uploadBanner');
Route::delete('/admin/headersetting/delete-banner/{id}', [HeaderSettingController::class, 'deleteBanner'])->name('header-setting.deleteBanner');
Route::post('/admin/headersetting/storeFavicon', [HeaderSettingController::class, 'storeFavicon'])->name('admin.headersetting.storeFavicon');
Route::get('/admin/favicon/create', [HeadersettingController::class, 'create'])->name('admin.favicon.create');
Route::post('/admin/favicon/store', [HeadersettingController::class, 'storeFavicon'])->name('admin.favicon.store');
Route::get('/admin/login', [HeadersettingController::class, 'showLogin'])->name('admin.login');
Route::delete('/admin/headersetting/favicon/{id}', [HeadersettingController::class, 'deleteFavicon'])
    ->name('admin.headersetting.deleteFavicon');

//HeadersettingController end



//PasswordController start 
Route::get('update-password', [PasswordController::class, 'showUpdateForm'])->name('update-password.form');
Route::post('update-password', [PasswordController::class, 'updatePassword'])->name('update-password.submit');
//PasswordController end




//ClientSearchControllerstart
Route::get('/clients/search', [ClientSearchController::class, 'index'])->name('clients.search');
//ClientSearchController end




//ApprovememberController start
 Route::get('/admin/approve-member', [ApprovememberController::class, 'approveMember'])->name('admin.approveMember');
 Route::get('/admin/rejected-member', [ApprovememberController::class, 'rejectedMember'])->name('admin.rejectedMember');
// ApprovememberController end



Route::get('/privacy-policy', function () {
    return view('privacypolicy');
})->name('privacy_policy');


//CustomerController start
Route::get('/customer',[CustomerController::class,'customer'])->name('customer');
Route::delete('/customer-banner/{id}', [CustomerController::class, 'destroy'])->name('customer-banner.destroy');
// CustomerController end





//admincontroller start

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('users', [AdminController::class, 'showUsers'])->name('users');
    Route::put('users/{id}/approve', [AdminController::class, 'approveUser'])->name('users.approve');

});
Route::put('users/{id}/approve', [AdminController::class, 'approveUser'])->name('users.approve');
Route::post('users/reject', [AdminController::class, 'rejectUser'])->name('users.reject');

Route::get('/admin/viewpayments', [AdminController::class, 'viewpayment'])->name('admin.viewpayments');
Route::get('/admin/expiring-subscriptions', [AdminController::class, 'viewExpiringSubscriptions'])->name('admin.expiringSubscriptions');

Route::post('/admin/send-renewal-notification/{userId}', [AdminController::class, 'sendRenewalNotification'])->name('admin.sendRenewalNotification');

Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

Route::get('/admin/member-lounge', [AdminController::class, 'memberlounge'])->name('admin.member.lounge');

Route::get('/admin/member-profile/{id}', [AdminController::class, 'profile'])->name('admin.member.profile');

Route::post('/admin/toggle-prime/{id}', [AdminController::class, 'togglePrimeMember'])->name('admin.toggle.prime');

Route::get('/admin/members-data', [AdminController::class, 'membersData'])->name('admin.members.data');

//admincontroller


Route::get('/admin/references', [AdminController::class, 'showReferences'])->name('admin.references');
Route::get('/admin/thanksnotes', [AdminController::class, 'showThanksNotes'])->name('admin.thanksnotes');
Route::get('admin/references/thisweek', [AdminController::class, 'thisWeekReference'])->name('admin.references.thisweek');
//admincontroller end





// CategoryController start
//Category Routes -13/3/2025
Route::prefix('categories')->middleware('auth')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/refresh-filters', [CategoryController::class, 'refreshFilters'])->name('categories.refreshFilters');

    Route::get('/create-main', [CategoryController::class, 'createMainCategory'])->name('categories.createMain');
    Route::post('/store-main', [CategoryController::class, 'storeMainCategory'])->name('categories.storeMain');

    Route::get('/create-sub/{id}', [CategoryController::class, 'createSubCategory'])->name('categories.createSub');
    Route::post('/store-sub', [CategoryController::class, 'storeSubCategory'])->name('categories.storeSub');
    Route::get('/select-default-image/{id}', [CategoryController::class, 'selectDefaultImage'])->name('categories.selectDefaultImage');
Route::post('/store-default-image', [CategoryController::class, 'storeDefaultImage'])->name('categories.storeDefaultImage');

    Route::get('/create-child/{categoryId}/{subCategoryId}', [CategoryController::class, 'createChildCategory'])->name('categories.createChild');
    Route::post('/store-child', [CategoryController::class, 'storeChildCategory'])->name('categories.storeChild');
    Route::post('/store-child-default-image', [CategoryController::class, 'storeChildDefaultImage'])->name('categories.storeChildDefaultImage');

Route::get('categories/{id}/edit', [CategoryController::class, 'editCategory'])->name('categories.edit');
Route::post('categories/{id}', [CategoryController::class, 'updateCategory'])->name('categories.update');


    Route::delete('/delete/{id}', [CategoryController::class, 'deleteCategory'])->name('categories.delete');

    Route::get('/subcategories/{id}', [CategoryController::class, 'getSubcategories']);
    Route::get('/childcategories/{id}', [CategoryController::class, 'getChildcategories']);
    Route::get('/select-child-default-image/{main_category_id}/{sub_category_id}', [CategoryController::class, 'selectChildDefaultImage'])->name('categories.selectChildDefaultImage');
    
Route::post('/store-child-default-image', [CategoryController::class, 'storeChildDefaultImage'])->name('categories.storeChildDefaultImage');


});

Route::prefix('vendor')->middleware('auth')->group(function () {
    Route::get('/create-main-category', [CategoryController::class, 'createMainFromVendor'])->name('categories.createMainFromVendor');
    Route::post('/store-main-category', [CategoryController::class, 'storeMainCategoryFromVendor'])->name('categories.storeMainFromVendor');

    Route::get('/create-sub/{id}', [CategoryController::class, 'createSubCategoryFromVendor'])->name('categories.createSubFromVendor');
    Route::post('/store-sub-category', [CategoryController::class, 'storeSubCategoryFromVendor'])->name('categories.storeSubFromVendor');

    Route::get('/create-child/{categoryId}/{subCategoryId}', [CategoryController::class, 'createChildCategoryFromVendor'])->name('categories.createChildFromVendor');
    Route::post('/store-child-category', [CategoryController::class, 'storeChildCategoryFromVendor'])->name('categories.storeChildFromVendor');
});


Route::get('vendor/create-sub/{id}', [CategoryController::class, 'createSubCategoryFromVendor'])->name('categories.createSubFromVendor');
// Route for storing a main category
Route::post('categories/store-main', [CategoryController::class, 'storeMainCategory'])->name('categories.storeMainCategory');

// CategoryController end 




//SubcategoryController start

    // Show subcategories
    Route::get('/subcategories', [SubcategoryController::class, 'index'])->name('subcategories.index');

    // Edit a subcategory
    Route::get('/subcategories/{id}/edit', [SubcategoryController::class, 'edit'])->name('subcategories.edit');

    // Update a subcategory
    Route::put('/subcategories/{id}', [SubcategoryController::class, 'update'])->name('subcategories.update');

    // Delete a subcategory
    Route::delete('/subcategories/{id}', [SubcategoryController::class, 'destroy'])->name('subcategories.destroy');
//SubcategoryController end 




//ChildCategoryController start
    Route::get('/childcategories/{id}', [ChildCategoryController::class, 'show'])->name('childcategories.show');
// ChildCategoryController end




//HighlightController start

Route::resource('highlight', HighlightController::class);
Route::get('/highlight/{id}/edit', [HighlightController::class, 'edit'])->name('highlight.edit');
Route::put('/highlight/{id}', [HighlightController::class, 'update'])->name('highlight.update');
Route::post('/update-highlight', [HomepageCategoryController::class, 'updateHighlight'])->name('highlight.update');
Route::post('/update-highlight', [HomepageCategoryController::class, 'updateHighlight'])->name('highlight.updateHighlight');
//HighlightController end 

//references controller start
Route::middleware(['auth:member'])->group(function () {
    Route::get('/references', [ReferenceController::class, 'index'])->name('references.index');
    Route::get('/references/create', [ReferenceController::class, 'create'])->name('references.create');
    Route::post('/references/store', [ReferenceController::class, 'store'])->name('references.store');
    Route::get('/references/report', [ReferenceController::class, 'report'])->name('references.report');
    Route::get('/references/received', [ReferenceController::class, 'received'])->name('references.received');


       // 👇 New routes for 'On Behalf of Reference'
       Route::get('/references/onbehalf', [ReferenceController::class, 'onBehalf'])->name('references.onbehalf');
       Route::post('/references/onbehalf/store', [ReferenceController::class, 'storeOnBehalf'])->name('references.storeOnBehalf');
});


//references controller end


//thanksnote controller start

Route::prefix('thanksnote')->middleware(['auth:member'])->group(function () {
    Route::get('/create', [ThanksnoteController::class, 'create'])->name('thanksnote.create');
    Route::post('/store', [ThanksnoteController::class, 'store'])->name('thanksnote.store');
    Route::get('/report', [ThanksnoteController::class, 'report'])->name('thanksnote.report');

    Route::get('/get-references/{memberId}', [ThanksnoteController::class, 'getReferences']);
    Route::get('/get-due-payments/{referenceId}', [ThanksnoteController::class, 'getDuePayments']); // ✅ New Route
    Route::get('/thanksnote/received', [ThanksnoteController::class, 'received'])->name('thanksnote.received');

});

//thanksnote controller end



//categories (18.3.2023) scm moble responsive


Route::get('/subcategoriesm/{categoryId}', [WebsiteController::class, 'showSubcategories']);
Route::get('/childcategoriesm/{subcategoryId}', [WebsiteController::class, 'showChildCategories']);

//categories (18.3.2023) scm end

Route::get('/notifications', [DashboardController::class, 'getNotifications']);
Route::get('/notifications/messages', [DashboardController::class, 'getPendingMessages']);

Route::get('/customer-support/{id}', function ($id) {
    return "Displaying details for customer support request #".$id;
});

Route::get('/vendor/notifications/count', [VendorDetailDashboardController::class, 'getNotificationCount'])
    ->name('vendor.notifications.count');

Route::get('/vendor/notifications/messages', [VendorDetailDashboardController::class, 'getNotifications'])
    ->name('vendor.notifications.messages');

Route::get('/vendor/notifications/read/{id}', [VendorDetailDashboardController::class, 'markNotificationAsRead'])
    ->name('vendor.notifications.read');



Route::get('/client-testimonials', [ClientTestimonialController::class, 'index'])->name('client_testimonials.index');
Route::post('/client-testimonials', [ClientTestimonialController::class, 'store'])->name('client_testimonials.store');

Route::delete('/client-testimonials/{id}', [ClientTestimonialController::class, 'destroy'])->name('client_testimonials.destroy');



Route::get('/vendor', [ClientTestimonialController::class, 'vendor'])->name('vendor.testimonials');


////////////////////////////
Route::resource('homepagebanners', HomepageBannerController::class);

Route::get('/homepage-banners', [HomepageBannerController::class, 'index'])->name('homepage.banners');

////////////////////////////



Route::get('/bottom-banners', [BottomBannerController::class, 'index'])->name('bottom_banners.index');
Route::post('/bottom-banners', [BottomBannerController::class, 'store'])->name('bottom_banners.store');
Route::delete('/bottom-banners/{id}', [BottomBannerController::class, 'destroy'])->name('bottom_banners.destroy');

Route::get('/bottom-banners1', [BottomBannerController::class, 'show'])->name('bottom_banners1.show'); // List banners
Route::get('/bottom-banners/create', [BottomBannerController::class, 'create'])->name('bottom_banners.create'); // Show form
Route::post('/bottom-banners1', [BottomBannerController::class, 'save'])->name('bottom_banners.save'); // Handle upload

Route::delete('/bottom-banners1/{id}', [BottomBannerController::class, 'delete'])->name('bottom_banners1.delete');

//banners

Route::get('/banners', [CategoryBannerController::class, 'index'])->name('banners.index');
Route::post('/banners', [CategoryBannerController::class, 'store'])->name('banners.store');
Route::delete('/banners/{banner}', [CategoryBannerController::class, 'destroy'])->name('banners.destroy');
Route::get('/homepage-settings/categorybanner', [CategoryBannerController::class, 'index'])->name('categorybanner.index');
Route::delete('/banners/{id}', [CategoryBannerController::class, 'destroy'])->name('banners.destroy');
// routes/web.php
Route::post('/banners/{id}/update', [CategoryBannerController::class, 'update'])->name('banners.update');



//
Route::get('/listingbanner', [ListingBannerController::class, 'index'])->name('listingbanners.index');

// Store new banner
Route::post('/listingbanner', [ListingBannerController::class, 'store'])->name('listingbanners.store');

// Edit banner
Route::get('/listingbanner/{id}/edit', [ListingBannerController::class, 'edit'])->name('listingbanners.edit');

// Update banner
Route::put('/listingbanner/{id}', [ListingBannerController::class, 'update'])->name('listingbanners.update');

// Delete banner
Route::delete('/listingbanner/{id}', [ListingBannerController::class, 'destroy'])->name('listingbanners.destroy');


Route::get('/products', [WebsiteController::class, 'showProductsWithBanners']);

