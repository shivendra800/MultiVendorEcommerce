<?php

use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('App\Http\Controllers\API')->group(function(){
    // Rehister User For React APP
    Route::post('register-user','APIController@registerUser');
    //Login USer Fro React App
    Route::post('login-user','APIController@loginUser');
    //updated user details /Prfile API 
    Route::post('updated-user','APIController@updatedUser');
        //cms Pages
        $cmsurls = CmsPage::select('url')->where('status', 1)->get()->pluck('url')->toArray();
        foreach ($cmsurls as $key => $url) {
            Route::get($url, 'APIController@cmsPage');
        }
    // Categories Menu API
    Route::get('menu','APIController@menu');
    // Listing Product API
    Route::get('listing/{url}','APIController@listing');   
      //  Product Detail API
      Route::get('detail/{id}','APIController@detail'); 
      // ADD To Cart Api
      Route::post('add-to-cart','APIController@addtoCart');   
      // shopping Cart Api 
      Route::get('cart/{userid}','APIController@cart');  
       // Delete Cart item Api 
       Route::get('delete-cart-item/{cartid}','APIController@deleteCartItem'); 
           // Checkout  Api 
       Route::get('checkout/{userid}','APIController@checkout');   

});

