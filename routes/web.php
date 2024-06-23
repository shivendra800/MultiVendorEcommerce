<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Front\ProductsController;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\CmsPage;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// require __DIR__ . '/auth.php';

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function () {
    // Admin login route
    Route::match(['get', 'post'], 'login', 'AdminController@login');

    Route::group(['middleware' => ['admin']], function () {
        // Admin Dashboard route
        Route::get('dashboard', 'AdminController@dashboard');
        // update admin password
        Route::match(['get', 'post'], 'update-admin-password', 'AdminController@Update_Admin_Password');
        // check admin password
        Route::post('check-admin-password', 'AdminController@CheckAdminPassword');
        // update admin Details
        Route::match(['get', 'post'], 'update-admin-details', 'AdminController@Update_Admin_Details');
        //Update vender Details
        Route::match(['get', 'post'], 'update-vendor-details/{slug}', 'AdminController@Update_Vendor_Details');
        //view Admins /Subadmins /Vendors
        Route::get('admins/{type?}', 'AdminController@admins');
        //view vendor details
        Route::get('view-vendor-details/{id}', 'AdminController@ViewVendorDetails');
        // Update Admin status
        Route::post('update-admin-status', 'AdminController@UpdateAdminStatus');
        // Admin logout
        Route::get('logout', 'AdminController@logout');
        //Sections
        Route::get('sections', 'SectionController@sections');
        Route::post('update-section-status', 'SectionController@UpdateSectionStatus');
        Route::get('delete-section/{id}', 'SectionController@DeleteSection');
        Route::match(['get', 'post'], 'add-edit-section/{id?}', 'SectionController@addEditSection');
        //Category
        Route::get('categories', 'CategoryController@categorys');
        Route::post('update-categorys-status', 'CategoryController@UpdateCategorysStatus');
        Route::get('delete-category/{id}', 'CategoryController@Deletecategorys');
        Route::get('delete-category-image/{id}', 'CategoryController@DeletecategorysImage');
        Route::match(['get', 'post'], 'add-edit-categorys/{id?}', 'CategoryController@addEditCategorys');
        Route::get('append-categories-level', 'CategoryController@appendcategoryLevel');
        //Brands
        Route::get('brands', 'BrandController@Brands');
        Route::post('update-brands-status', 'BrandController@UpdateBrandStatus');
        Route::get('delete-brand/{id}', 'BrandController@DeleteBrand');
        Route::match(['get', 'post'], 'add-edit-brand/{id?}', 'BrandController@addEditBrand');
        //Product
        Route::get('products', 'ProductController@product');
        Route::post('update-products-status', 'ProductController@UpdateProductStatus');
        Route::get('delete-product/{id}', 'ProductController@DeleteProduct');
        Route::match(['get', 'post'], 'add-edit-product/{id?}', 'ProductController@addEditProduct');
        Route::match(['get', 'post'], 'add-attributes/{id?}', 'ProductController@addAttributes');
        Route::post('update-attribute-status', 'ProductController@updateAttributesStatus');
        Route::get('delete-attribute/{id}', 'ProductController@Deleteattribute');
        Route::match(['get', 'post'], 'edit-attributes/{id}', 'ProductController@Editattribute');
        Route::match(['get', 'post'], 'add-images/{id}', 'ProductController@AddImage');
        Route::post('update-images-status', 'ProductController@updateImageStatus');
        Route::get('delete-image/{id}', 'ProductController@DeleteImage');
        //Banner
        Route::get('banners', 'BannerController@Banners');
        Route::match(['get', 'post'], 'add-banner-image/{id?}', 'BannerController@AddBannerImage');
        Route::get('delete-banner/{id}', 'BannerController@DeleteBanner');
        //Filter
        Route::get('filters', 'FilterController@filters');
        Route::get('filters-values', 'FilterController@filtersValues');
        Route::post('update-filters-status', 'FilterController@UpdateFilterStatus');
        Route::post('update-filters-values-status', 'FilterController@UpdateFilterValuesStatus');
        Route::get('delete-filter/{id}', 'FilterController@DeleteFilter');
        Route::get('delete-filterValues/{id}', 'FilterController@DeleteFilterValues');
        Route::match(['get', 'post'], 'add-edit-filter/{id?}', 'FilterController@addEditFilter');
        Route::match(['get', 'post'], 'add-edit-filter-value/{id?}', 'FilterController@addEditFilterValue');
        Route::post('category-filters', 'FilterController@categoryFilters');

        //Coupon
        Route::get('coupons','CouponController@Couponds');
        Route::post('update-coupon-status', 'CouponController@UpdateCouponStatus');
        Route::get('delete-coupon/{id}','CouponController@DeleteCoupon');
        Route::match(['get','post'],'add-edit-coupon/{id?}','CouponController@AddEditCoupon');

        Route::controller(OrderController::class)->group(function(){
            Route::get('orders','Orders');
            Route::get('orders/{id}','OrdersDetails');
            Route::post('update-order-status','UpdateOrderStatus');
            Route::post('update-order-item-status','UpdateOrderItemStatus');
              // Order Invoices
            Route::get('view-order-invoice/{id}','viewOrderInvoice');
            Route::get('view-order-invoice-pdf/{id}','viewOrderInvoicePdf');

        });
        Route::controller(CmsController::class)->group(function(){
            Route::get('cms-Page','cmsPages');
            Route::get('delete-page/{id}','DeleteCmsPage');
            Route::post('update-cmsPage-status','UpdateCmsPageStatus');
            Route::match(['get', 'post'], 'add-edit-cmspages/{id?}', 'AddEditCmsPages');

        });
    });
});

Route::get('download-invoice/{id}','App\Http\Controllers\Admin\OrderController@viewOrderInvoicePdf');

Route::namespace('App\Http\Controllers\Front')->group(function () {

    Route::get('/', 'IndexController@index');

    //Listing/Categories Routes
    $caturls = Category::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    // dd( $caturls); die;
    foreach ($caturls as $key => $url) {
        Route::match(['get', 'post'], '/' . $url, 'ProductsController@listing');

    }
    //cms Pages
    $cmsurls = CmsPage::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    foreach ($cmsurls as $key => $url) {
        Route::get($url, 'CmsController@cmsPage');
    }
    Route::controller(ProductsController::class)->group(function(){
           Route::get('product/{id}','productDetails');
           Route::get('new-arravials','newArravial');
           Route::get('best-seller','bestSeller');
           Route::get('discount-product','discountProduct');
           Route::get('featured-product','featuredProduct');
           Route::post('get-productPrice-withSize','ProductPriceWithSize');
           // Vendor Products
           Route::get('/productvendor/{vendorid}','VendorListingProduct');
           //ADD TO Carts
           Route::post('cart/add','AddToCart');
           Route::get('/cart','Cart');
           // update Cart Item Quantity
           Route::post('cart/update','cartUpdate');
           // update Cart Item Quantity
           Route::post('cart/delete','deleteUpdate');
    });

         // Vendor Login Register in Front website
    Route::controller(App\Http\Controllers\Front\VendorController::class)->group(function () {
            Route::get('/vendor/login-register','loginRegister');
            Route::match(['get', 'post'],'/vendor/register','vendorRegister');
            //Confirm Vendor Account
            Route::match(['get', 'post'],'/vendor/confirm/{code}','vendorConfirm');

    });

    Route::group(['middleware'=>['auth']],function(){
        Route::match(['get', 'post'],'user/account','UserController@userAccount');
        Route::post('user/update-password','UserController@userUpdatePassword');
        Route::match(['get', 'post'],'/apply-coupon','ProductsController@ApplyCoupon');
        Route::match(['get','post'],'checkout','ProductsController@checkout');
        Route::match(['get','post'], '/get-delivery-address','AddressController@getDeliveryAddress');
        Route::match(['get','post'],'save-delivery-address','AddressController@SaveDeliveryAddress');
        Route::match(['get','post'],'remove-delivery-address','AddressController@removeDeliveryAddress');
        Route::get('thanks','ProductsController@thanks');
        Route::get('user/orders/{id?}','OrderController@UserOrder');
        //paypal Route
        Route::get('paypal','PaypalController@paypal');
        Route::post('pay','PaypalController@pay')->name('payment');
        Route::get('success','PaypalController@success');
        Route::get('error','PaypalController@error');

        


    });
        Route::get('user/login-register',['as'=>'login','uses'=>'UserController@loginRegister']);
        Route::match(['get', 'post'],'/user/register','UserController@userRegister');
        // user Logout
        Route::get('user/logout','UserController@UserLogout');
        Route::post('user/login','UserController@UserLogin');
        // Confirm  user Account
        Route::get('user/confirm/{code}','UserController@UserConfirmAccount');
        //forget password
        Route::match(['get','post'],'user/forget-password', 'UserController@forgetPassword');
        //search Products
        Route::get('search-products','ProductsController@listing');




});
