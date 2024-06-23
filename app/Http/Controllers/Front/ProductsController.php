<?php

namespace App\Http\Controllers\Front;

use COM;
use App\Models\Sms;
use App\Models\User;
use App\Models\Carts;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Vendor;
use App\Models\Country;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\OrdersProduct;
use App\Models\ProductsFilter;
use App\Models\DeliveryAddress;
use App\Models\ProductsAttribute;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    public function listing(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            $url = $data['url'];
            $_GET['sort'] = $data['sort'];
            $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
            if ($categoryCount > 0) {
                //Get Category Details
                $categoryDetails = Category::categoryDetails($url);
                // dd($categoryDetails);
                $categoryProduct = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);

                // Checking For Dayming Filter
                $productFilters = ProductsFilter::productFilters();
                foreach ($productFilters as $key => $filter) {
                    if (
                        isset($filter['filter_column']) && isset($data[$filter['filter_column']]) &&
                        !empty($filter['filter_column']) && !empty($data[$filter['filter_column']])
                    ) {
                        $categoryProduct->whereIn($filter['filter_column'], $data[$filter['filter_column']]);
                    }
                }



                //checking for sort
                if (isset($_GET['sort']) && !empty($_GET['sort'])) {
                    if ($_GET['sort'] == "product_latest") {
                        $categoryProduct->orderby('products.id', 'Desc');
                    } else if ($_GET['sort'] == "price_lowest") {
                        $categoryProduct->orderby('products.product_price', 'Asc');
                    } else if ($_GET['sort'] == "price_highest") {
                        $categoryProduct->orderby('products.product_price', 'Desc');
                    } else if ($_GET['sort'] == "name_a_z") {
                        $categoryProduct->orderby('products.product_name', 'Asc');
                    } else if ($_GET['sort'] == "name_z_a") {
                        $categoryProduct->orderby('products.product_name', 'Desc');
                    }
                }

                // Checking for Size
                if (isset($data['size']) && !empty($data['size'])) {
                    $productIds = ProductsAttribute::select('product_id')->whereIn('size', $data['size'])->pluck('product_id')->toArray();
                    $categoryProduct->whereIn('products.id', $productIds);
                }

                // Checking for Color
                if (isset($data['color']) && !empty($data['color'])) {
                    $productIds = Product::select('id')->whereIn('product_color', $data['color'])->pluck('id')->toArray();
                    $categoryProduct->whereIn('products.id', $productIds);
                }
                // Checking for brand
                if (isset($data['brand']) && !empty($data['brand'])) {
                    $productIds = Product::select('id')->whereIn('brand_id', $data['brand'])->pluck('id')->toArray();
                    $categoryProduct->whereIn('products.id', $productIds);
                }
                // Checking for Price
             /*   if (isset($data['price']) && !empty($data['price'])) {
                    foreach ($data['price'] as $key => $price) {
                        $priceArr = explode("-", $price);
                        $productIds[] = Product::select('id')->whereBetween('product_price', [$priceArr[0], $priceArr[1]])->pluck('id')->toArray();


                        //   $implodePrices= implode('-',$data['price']);
                        //   $explodePrices= explode('-',$implodePrices);
                        //   $min=reset($explodePrices);
                        //   $max=end($explodePrices);
                        //   $productIds =Product::select('id')->whereBetween('product_price',[$min,$max])->pluck('id')->toArray();
                        //  $categoryProduct->whereIn('products.id', $productIds);
                        //   echo"<pre>"; print_r( $productIds);die;
                    }
                    $productIds = call_user_func_array('array_merge',  $productIds);
                    // echo"<pre>"; print_r( $productIds);die;
                    $categoryProduct->whereIn('products.id', $productIds);
                }  */

                     // Checking for Price
                     $productIds = array();
                     if (isset($data['price']) && !empty($data['price'])) {
                        foreach ($data['price'] as $key => $price) {
                            $priceArr = explode("-", $price);
                            if(isset($priceArr[0]) && isset($priceArr[1])){
                                $productIds[] = Product::select('id')->whereBetween('product_price', [$priceArr[0], $priceArr[1]])->pluck('id')->toArray();

                            }
                        }
                        $productIds = array_unique(array_flatten($productIds));
                        // echo"<pre>"; print_r( $productIds);die;
                        $categoryProduct->whereIn('products.id', $productIds);
                    }



                $categoryProduct = $categoryProduct->paginate(30);

                // dd($categoryProduct);
                // echo "Category Exists"; die;
                return view('front.products.ajax_products_listing')->with(compact('categoryDetails', 'categoryProduct', 'url'));
            } else {
                abort(404);
            }
        } else {
              if(isset($_REQUEST['search']) && !empty($_REQUEST['search'])){
                $search_product= $_REQUEST['search'];
                 $categoryDetails['breadcrumbs'] = $search_product;
                 $categoryDetails['categoryDetails']['category_name'] = $search_product;
                 $categoryDetails['categoryDetails']['description'] = "Search Product For". $search_product;
                 $categoryProducts = Product::with('brand')->join('categories','categories.id','=','products.category_id')->where(function($query)use($search_product) {
                    $query->where('products.product_name', 'like', '%' .$search_product. '%')->orWhere('products.product_code', 'like', '%' .$search_product. '%')
                    ->orWhere('products.product_color', 'like', '%' .$search_product. '%')
                    ->orWhere('products.description', 'like', '%'.$search_product. '%')->orWhere('categories.category_name', 'like', '%'.$search_product. '%');
                  })->where('products.status',1);
                  $categoryProduct = $categoryProducts->get();
                  return view('front.products.listing')->with(compact('categoryDetails', 'categoryProduct'));
              }else{
                $url = Route::getFacadeRoot()->current()->uri();
                $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
                if ($categoryCount > 0) {
                    //Get Category Details
                    $categoryDetails = Category::categoryDetails($url);
                    // dd($categoryDetails);
                    $categoryProduct = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);
    
                    //checking for sort
                    if (isset($_GET['sort']) && !empty($_GET['sort'])) {
                        if ($_GET['sort'] == "product_latest") {
                            $categoryProduct->orderby('products.id', 'Desc');
                        } else if ($_GET['sort'] == "price_lowest") {
                            $categoryProduct->orderby('products.product_price', 'Asc');
                        } else if ($_GET['sort'] == "price_highest") {
                            $categoryProduct->orderby('products.product_price', 'Desc');
                        } else if ($_GET['sort'] == "name_a_z") {
                            $categoryProduct->orderby('products.product_name', 'Asc');
                        } else if ($_GET['sort'] == "name_z_a") {
                            $categoryProduct->orderby('products.product_name', 'Desc');
                        }
                    }
    
                    $categoryProduct = $categoryProduct->paginate(30);
    
                    //dd($categoryProduct);
                    // echo "Category Exists"; die;
                    return view('front.products.listing')->with(compact('categoryDetails', 'categoryProduct', 'url'));
                } else {
                    abort(404);
                }
              }
         
        }
    }


    public function VendorListingProduct($vendorid)
    {
        // GEt Vendor Shop Name
      $getVendorShop = Vendor::getVendorShop($vendorid);

      // Get Vendor Product

      $vendorProducts = Product::with('brand')->where('vendor_id',$vendorid)->where('status',1);
      $vendorProducts =$vendorProducts->paginate(30);
    //   dd(  $getVendorShop);
      return view('front.products.vendor_listing')->with(compact('getVendorShop','vendorProducts'));


    }

    public function productDetails($id)
    {
        $productDetails = Product::with(['category', 'brand', 'attributes' => function ($query) {
            $query->where('stock', '>', 0)->where('status', 1);
        }, 'images', 'section' ,'vendor'])->find($id)->toArray();
        $categoryDetails = Category::categoryDetails($productDetails['category']['url']);
        $totalStocks = ProductsAttribute::where('product_id', $id)->sum('stock');
        // dd($productDetails);
        // Get Similar Products
         $similarProduct =Product::with('brand')->where('category_id',$productDetails['category']['id'])->where('id','!=',$id)->limit(4)->inRandomOrder()->get()->toArray();

         // Set Session for Recently Viewed Product
         if(empty(Session::get('session_id'))){
            $session_id = md5(uniqid(rand(),true));

         }
         else{
            $session_id=Session::get('session_id');
         }

          Session::put('session_id',$session_id);

         // Insert Recent view Product if it not exist
          $countRecentlyViewPrdocts=DB::table('recently_viewed_products')->where(['product_id'=>$id,'session_id'=>$session_id])->count();
          if($countRecentlyViewPrdocts==0)
          {
             DB::table('recently_viewed_products')->insert(['product_id'=>$id,'session_id'=>$session_id]);
          }
         // Get Recently Viewed Products
          $recentlyProductIds=  DB::table('recently_viewed_products')->select('product_id')->where('product_id','!=',$id)->where('session_id',$session_id)->inRandomOrder()->get()->take(8)->pluck('product_id');
     //    dd( $recentlyProductIds);
         $similarViewProduct =Product::with('brand')->whereIn('id',$recentlyProductIds)->where('id','!=',$id)->get();
          // Get Group Product (color)
          $groupProducts =array();
          if(!empty($productDetails['group_code'])){
            $groupProducts=Product::select('id','product_image')->where('id','!=',$id)->where(['group_code'=>$productDetails['group_code'],'status'=>1])->get()->toArray();
         //   dd($groupProducts);
          }
         return view('front.products.product_details')->with(compact('productDetails', 'categoryDetails', 'totalStocks','similarProduct','similarViewProduct','groupProducts'));
    }


    public function ProductPriceWithSize(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
           $getDiscountAttributePrice=Product::getDiscountAttributePrice($data['product_id'],$data['size']);
            return  $getDiscountAttributePrice;
        }

    }

    public function Cart()
    {
        $getCartItems=Carts::getCartItems();
       // dd($getCartItems);
        return view('front.products.view_cart')->with(compact('getCartItems'));
    }

    public function AddToCart(Request $request)
    {
          if($request->isMethod('post')){
            $data =$request->all();
            // echo "<pre>"; print_r($data); die;
            if($data['quantity']<=0){
                $data['quantity']=1;
            }

            // Check Product Stock is Available or Not
           $getProductStock =ProductsAttribute::isStockAvailable($data['product_id'],$data['size']);
             if($getProductStock<$data['quantity']){
                return redirect()->back()->with('error_message','Required Quantity Is Not Available!');
             }

             // Generate Session Id If Not Exist
             $session_id =Session::get('session_id');
             if(empty($session_id)){
                $session_id=Session::getId();
                Session::put('session_id',$session_id);
             }

             // Check Productc If Is Alreday Exist in bthe user cart
             if(Auth::check()){

                //User Is logged In
                $user_id=Auth::user()->id;
                $countProducts=Carts::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'user_id'=>$user_id])->count();

             }else{
                //User Is NOt Logged In
                $user_id=0;
                $countProducts=Carts::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'session_id'=>$session_id])->count();
             }
                if($countProducts>0){
                    return redirect()->back()->with('error_message','Product is already exists in cart!');
                }

             // Save Product In Cart Table
              $item = new Carts;
              $item->session_id=$session_id;
              $item->user_id=$user_id;
              $item->product_id=$data['product_id'];
              $item->size=$data['size'];
              $item->quantity=$data['quantity'];
              $item->save();
              return redirect()->back()->with('success_message', 'Product Has Been Added In Your Cart!');
          }
    }

    public function cartUpdate(Request $request)
    {
        if($request->ajax()){
            $data =$request->all();
            // echo "<pre>",print_r($data); die;

            // Get Cart Details
            $cartDetails= Carts::find($data['cartid']);

            //Get Available Product Stock
            $availableStock =ProductsAttribute::select('stock')->where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size']])->first()->toArray();
          //  echo "<pre>",print_r($availableStock); die;

          // Check If Desired Stock from User Is Available
            if($data['qty']>$availableStock['stock']){
                $getCartItems = Carts::getCartItems();
                return response()->json(['status'=>false,'message'=>'Product Stock is not Avaliable.','view'=>(String)View::make('front.products.cart_item')->with(compact('getCartItems'))]);

            }

            // Check if Size Is available
            $availableSize =ProductsAttribute::where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size'],'status'=>1])->count();
            if($availableSize==0){
                $getCartItems = Carts::getCartItems();
                return response()->json(['status'=>false,'message'=>'Product Is Out Of Stock .Select Any Order Product and remove Old Prduct.','view'=>(String)View::make('front.products.cart_item')->with(compact('getCartItems'))]);
            }
            //Update the Qty
            Carts::where('id',$data['cartid'])->update(['quantity'=>$data['qty']]);
            $getCartItems = Carts::getCartItems();
            $totalCartItems=totalCartItems();
            Session::forget('couponAmount');
            Session::forget('couponCode');
            return response()->json(['status'=>true,'totalCartItems'=>$totalCartItems,'view'=>(String)View::make('front.products.cart_item')->with(compact('getCartItems','totalCartItems'))
            ,'headerview'=>(String)View::make('front.layout.hearder_cart_items')->with(compact('getCartItems','totalCartItems'))
        ]);
        }

    }

    public function deleteUpdate(Request $request)
    {
        if($request->ajax()){
            Session::forget('couponAmount');
            Session::forget('couponCode');
            $data =$request->all();
           //  echo "<pre>",print_r($data); die;
           Carts::where('id',$data['cartid'])->delete();
           $getCartItems = Carts::getCartItems();
           $totalCartItems=totalCartItems();
           return response()->json(['totalCartItems'=>$totalCartItems,'view'=>(String)View::make('front.products.cart_item')->with(compact('getCartItems'))
           ,'headerview'=>(String)View::make('front.layout.hearder_cart_items')->with(compact('getCartItems','totalCartItems'))]);


         }
    }

    public function ApplyCoupon(Request $request)
    {
       if($request->ajax()){
        $data= $request->all();
        Session::forget('couponAmount');
        Session::forget('couponCode');
        // echo "<pre>",print_r($data); die;
        $getCartItems = Carts::getCartItems();
        $totalCartItems=totalCartItems();
        $coupomCount=Coupon::where('coupon_code',$data['code'])->count();
        if($coupomCount==0){
            return response()->json(['status'=>false,'totalCartItems'=>$totalCartItems,'message'=>'Coupon is Not Valid!','view'=>(String)View::make('front.products.cart_item')->with(compact('getCartItems'))
            ,'headerview'=>(String)View::make('front.layout.hearder_cart_items')->with(compact('getCartItems','totalCartItems'))]);
        }else{
            // check for other condition

            // Get Coupon Details
            $couponDetails=Coupon::where('coupon_code',$data['code'])->first();

            //check if coupon is active
            if($couponDetails->status==0){
                $message = "This Copuon Is Not Active";
            }

            // check if coupon is expired
            $expiry_date=$couponDetails->expiry_date;
            $current_date= date('d-m-Y');
            if($expiry_date < $current_date)
            {
                $message = "Coupon date is Expire!";
            }

            // Check if coupon is Single  Time
            if($couponDetails->coupon_type=="Single Time"){
                //check in order Table if Coupon already availed by the user
                $couponCount = Order::where(['coupon_code'=>$data['code'],'user_id'=>Auth::user()->id])->count();
                if($couponCount>=1){
                    $message = "This Coupon Code Is already Use by You!.";
                }
            }

            //Selct the copuon for category
            // get all category form coupon and convert to array
           $catArr =explode(",",$couponDetails->categories);
            //check if any cart item not belong to copuon category
            $total_amount = 0;
            foreach ($getCartItems as $key =>$item){
                if(!in_array($item['product']['category_id'],$catArr)){
                    $message = "This coupon is not for selected product only !";
                }
                $attrPirce = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                // echo "<pre>",print_r($attrPirce); die;
                $total_amount = $total_amount + ($attrPirce['final_price']*$item['quantity']);
            }

               //Selct the copuon for selected user
            // get all selected user form coupon and convert to array

             if(isset($couponDetails->users)&&!empty($couponDetails->users)){
                $usersArr =explode(",",$couponDetails->users);
                 if (count($usersArr)) {
                // get user id of all selected users
                 foreach ($usersArr as $key =>$user) {
                     $getUserId = User::select('id')->where('email', $user)->first()->toArray();
                     $usersId[] = $getUserId['id'];
                 }

                // check if any cart item not belong to coupon user
                 foreach ($getCartItems as $item) {
                       if (!in_array($item['user_id'], $usersId)) {
                             $message = "This coupon is not for you !";
                         }
                    }
                }
             }


             if($couponDetails->vendor_id=0){
                 $productIds = Product::select('id')->where('vendor_id',$couponDetails->vendor_id)->pluck('id')->toArray();
             }
             // check if Coupon belong to vendor
              foreach ($getCartItems as $item) {
                 if (!in_array($item['user_id'], $usersId)) {
                     $message = "This coupon is not for you ! It Is for other Product";
                 }
             }




            //if error message is there
            if(isset($message)){
                return response()->json(['status'=>false,'totalCartItems'=>$totalCartItems,'message'=>$message,'view'=>(String)View::make('front.products.cart_item')->with(compact('getCartItems'))
                ,'headerview'=>(String)View::make('front.layout.hearder_cart_items')->with(compact('getCartItems','totalCartItems'))]);
            }else{
                //coupon code is correct

                //check if Coupon Amount Type   is Fixed Or Percentage
                if($couponDetails->amount_type=="Fixed"){
                    $couponAmount = $couponDetails->amount;
                }else{
                    $couponAmount= $total_amount * ($couponDetails->amount/100);
                }
                $grand_total = $total_amount - $couponAmount;

                // Add  coupon Code $ Amount in session Varaiables
                Session::put('couponAmount',$couponAmount);
                Session::put('couponCode',$data['code']);

                $message = "Coupon Code Successfully Applied.";

                return response()->json([
                    'status'=>true,
                    'totalCartItems'=>$totalCartItems,
                    'couponAmount'=>$couponAmount,
                    'grand_total'=>$grand_total,
                    'message'=>'Coupon is Not Valid!',
                    'view'=>(String)View::make('front.products.cart_item')->with(compact('getCartItems')),
                    'headerview'=>(String)View::make('front.layout.hearder_cart_items')->with(compact('getCartItems','totalCartItems'))
            ]);

            }
        }
       }
    }
    public function checkout (Request $request)
    {
        $deliveryAddresses = DeliveryAddress::deliveryAddresses();
        $countries = Country::where('status', 1)->get()->toArray();
        $getCartItems=Carts::getCartItems();
      //   dd($getCartItems);
      if(count($getCartItems)==0){
        $message= "Shopping Cart Is Empty! Please Add Products For Shopping";
        return redirect('cart')->with('error_message',$message);
      }
        if($request->isMethod('post')){
            $data = $request->all();
            // echo"<pre>";print_r($data); die;
            //Website Security
            foreach($getCartItems as $item){
                    //Prevent Disable Products To Order
                    $product_status=Product::getProductStatus($item['product_id']);
                    if($product_status==0){
                        Product::deleteCartProduct($item['product_id']);
                        $message= "one Of the Product IS Disable Plz try Again!.";
                        return redirect('/cart')->with('error_message',$message);
                    }
                    //Prevent Sold Out Product To order
                    $getProductStock=ProductsAttribute::isStockAvailable($item['product_id'],$item['size']);
                    if($getProductStock==0){
                        Product::deleteCartProduct($item['product_id']);
                        $message= "one Of the Product is Sold Out Plz try Again!.";
                        return redirect('/cart')->with('error_message',$message);
                    }
                      //Prevent attribute disable  Product To Order
                      $getAttributeStatus=ProductsAttribute::getAttributeStatus($item['product_id'],$item['size']);
                      if($getAttributeStatus==0){
                          Product::deleteCartProduct($item['product_id']);
                          $message= "one Of the Product is attribute disable try Again!.";
                          return redirect('/cart')->with('error_message',$message);
                      }
                          //Prevent disable Category Product To Order
                          $getCategoryStatus=Category::getCategoryStatus($item['product']['category_id']);
                          if($getCategoryStatus==0){
                            //   Product::deleteCartProduct($item['product_id']);
                              $message = $item['product']['product_name']." with ".$item['size']." Size is not
                                        available.Please remove from Cart and choose another Product.";
                              return redirect('/cart')->with('error_message',$message);
                          }
            }
            // Delivery addresss Validation
            if(empty($data['address_id'])){
                $message = "Please Select Delivery Address!";
                return redirect()->back()->with('error_message',$message);
            }
            if(empty($data['payment_gateway'])){
                $message = "Please Select Any Payment Method!";
                return redirect()->back()->with('error_message',$message);
            }
            if(empty($data['accept'])){
                $message = "Please Accept T&C!";
                return redirect()->back()->with('error_message',$message);
            }
             // Get Delivery Address from address_id
             $deliveryAddresses = DeliveryAddress::where('id',$data['address_id'])->first()->toArray();
             //dd($deliveryAddresses);

             // set Payment Method as COD if COD is selected from user otherwise set as Prepaid
              if($data['payment_gateway']=="COD"){
                $payment_method = "COD";
                $order_status = "New";
              }else{
                $payment_method = "Prepaid";
                $order_status = "Pending";
              }

              DB::beginTransaction();
                 // Featch Order Total price
              $total_price=0;
              foreach($getCartItems as $item ){
                $getDiscountAttributePrice =Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                $total_price =  $total_price + ( $getDiscountAttributePrice['final_price'] *$item['quantity']);
              }
              // calculate Shipping Charges
              $shipping_charges=0;
              // Calaculate Grand Total
              $grand_total = $total_price + $shipping_charges - Session::get('couponAmount');

              //Insert Grand Total  in Session Varaible
              Session::put('grand_total',$grand_total);

              // Insert Order Details
              $order = new Order;
              $order->user_id = Auth::user()->id;
              $order->name = $deliveryAddresses['name'];
              $order->address = $deliveryAddresses['address'];
              $order->city = $deliveryAddresses['city'];
              $order->state = $deliveryAddresses['state'];
              $order->country = $deliveryAddresses['country'];
              $order->pincode = $deliveryAddresses['pincode'];
              $order->mobile = $deliveryAddresses['mobile'];
              $order->email = Auth::user()->email;
              $order->shipping_charges = $shipping_charges;
              $order->coupon_code = Session::get('couponCode');
              $order->coupon_amount = Session::get('couponAmount');
              $order->order_status = $order_status;
              $order->payment_method = $payment_method;
              $order->payment_gateway = $data['payment_gateway'];
              $order->grand_total = $grand_total;
              $order->save();
              $order_id = DB::getPdo()->lastInsertId();
              foreach($getCartItems as $item ){
                    $cartItem = new OrdersProduct;
                    $cartItem->order_id = $order_id;
                    $cartItem->user_id = Auth::user()->id;
                    $getProductDetails = Product::select('product_code','product_name','product_color','admin_id','vendor_id')->where('id',$item['product_id'])->first()->toArray();
                   // dd(  $getProductDetails);
                   $cartItem->admin_id = $getProductDetails['admin_id'];
                   $cartItem->vendor_id = $getProductDetails['vendor_id'];
                   $cartItem->product_id = $item['product_id'];
                   $cartItem->product_code = $getProductDetails['product_code'];
                   $cartItem->product_name = $getProductDetails['product_name'];
                   $cartItem->product_color = $getProductDetails['product_color'];
                   $cartItem->product_size = $item['size'];
                   $getDiscountAttributePrice =Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                   $cartItem->product_price = $getDiscountAttributePrice['final_price'];
                   $cartItem->product_qty = $item['quantity'];
                   $cartItem->save();

                   //Reduce Stock  Script Starts 
                    $getProductStock = ProductsAttribute::isStockAvailable($item['product_id'],$item['size']);
                      $newStock=  $getProductStock - $item['quantity'];
                      ProductsAttribute::where(['product_id'=>$item['product_id'],'size'=>$item['size']])->update([
                        'stock'=>$newStock]);
                          //Reduce Stock  Script Ends 
              }
                //Insert Order Id in Session varabile
                Session::put('order_id',$order_id);
                DB::commit();
                 $orderDetails = Order::with('orders_products')->where('id',$order_id)->first()->toArray();
                 if($data['payment_gateway']=="COD"){
                    // Send Order Email
                    $email = Auth::user()->email;
                    $messageData =[
                        'email' =>$email,
                        'name' =>Auth::user()->name,
                        'order_id' => $order_id,
                        'orderDetails' => $orderDetails
                    ];
                    Mail::send('emails.order',$messageData,function($message)use($email){
                        $message->to($email)->subject('Order Place Successfully!- Shivendra Developers.com');
                    });
                    
                    // Send Order SMS
                    // $message = "Dear Customer, you Order ".$order_id." has been successfully placed with ShivendraDeveloper.com.we will intimate you once your order is shipped.";
                    // $mobile = Auth::user()->mobile;
                    //  Sms::sendSms($message,$mobile);
                 }  if($data['payment_gateway']=="Paypal"){
                      // paypal - Redirect User TO paypal page after saving Order
                         return redirect('/paypal');
                  } else{
                    echo "Other Prepaid payment method is coming soon";
                 }

                return redirect('thanks');

        }
        return view('front.products.checkout')->with(compact('deliveryAddresses','countries','getCartItems'));
    }

    public function thanks()
    {
       if(Session::has('order_id')){
        //Empty the Cart
        Carts::where('user_id',Auth::user()->id)->delete();
        return view('front.products.thanks');
       }else{
        return redirect('cart');
       }
    }

    public function newArravial()
    {
        $newProducts = Product::with('category', 'brand', 'attributes', 'images', 'section')->orderBy('id', 'Desc')->where('status', 1)->cursorPaginate(32);
        return view('front.products.new_arravials')->with(compact('newProducts'));
    }

    public function bestSeller()
    {
        $bestSellerProducts = Product::with('category', 'brand', 'attributes', 'images', 'section')->where(['is_bestseller' => 'Yes', 'status' => 1])->inRandomOrder()->cursorPaginate(32);
        return view('front.products.bestSeller')->with(compact('bestSellerProducts'));
    }

    public function discountProduct()
    {
        $discountedProducts = Product::with('category', 'brand', 'attributes', 'images', 'section')->where('product_discount', '>', 0)->inRandomOrder()->cursorPaginate(32);
        return view('front.products.discountProduct')->with(compact('discountedProducts'));
    }

    public function featuredProduct()
    {
        $featureProducts = Product::with('category', 'brand', 'attributes', 'images', 'section')->where(['is_featured' => 'Yes', 'status' => 1])->inRandomOrder()->cursorPaginate(32);
        return view('front.products.featureProducts')->with(compact('featureProducts'));
    }
}
