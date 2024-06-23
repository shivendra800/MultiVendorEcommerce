<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Carts;
use App\Models\CmsPage;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductsFilter;
use App\Models\ProductsAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class APIController extends Controller
{
    public function registerUser(Request $request){
        if($request->isMethod('post')){
            $data = $request->input();
            // echo "<pre>"; print_r($data); die;
            $rules =[
                "name"=>"required",
                "email"=>"required|email|unique:users",
                "password"=>"required",
                "mobile"=>"required"
            ];
            $customMessage=[
                "name.required" =>  "Name Is Required",
                "email.required" =>  "Email Is Required",
                "email.unique" =>  "This Email Is Already Exists.",
                "password.required" =>  "Password Is Required",
                "mobile.required" =>  "mobile Is Required"
            ];
            $validator = Validator::make($data,$rules,$customMessage);
            if($validator->fails()){
                return response()->json($validator->errors(),422);
            }
            $user = new User;
            $user->name  = $data['name'];
            $user->email  = $data['email'];
            $user->mobile  = $data['mobile'];
            $user->password  = bcrypt($data['name']);
            $user->status  = 1;
            $user->save();
            return response()->json(['status'=>true,'message'=>'User Register Successfully!',201]);
        }
    }

    public function loginUser(Request $request)
    {
         if($request->isMethod('post')){
            $data = $request->input();
            // echo "<pre>"; print_r($data); die;
            $rules =[
                "email"=>"required|email|exists:users",
                "password"=>"required"
            ];
            $customMessage=[
                "email.required" =>  "Email Is Required",
                "email.exists" =>  "This Email Is Not Exists.",
                "password.required" =>  "Password Is Required"
            ];
            $validator = Validator::make($data,$rules,$customMessage);
            if($validator->fails()){
                return response()->json($validator->errors(),422);
            }

                    //Verify User Email
                    $userCount = User::where('email',$data['email'])->count();
                    if($userCount>0)
                    {
                                    //Featch User Details
                        $userDetails = User::where('email',$data['email'])->first();
                        // Verify the User Password
                        if(password_verify($data['password'],$userDetails->password)){
                            return response()->json([
                                 "userDetails" =>$userDetails,
                                "status"=>true,
                                "message"=>"User Login Successfully!"
                            ],201);
                        }else{
                            $message = "Password Is Incorrect!";
                            return response()->json([
                                "status"=>false,
                                "message"=>$message
                            ],422);
                        }
                    }else{
                        $message = "Email Is Incorrect!";
                        return response()->json([
                            "status"=>false,
                            "message"=>$message
                        ],422);
                     }
         }
    }
    public function updatedUser(Request $request)
    {
           if($request->isMethod('post')){
            $data=$request->input();
            // echo "<pre>"; print_r($data); die;
            $rules =[
                "name"=>"required",
                "mobile"=>"required",
                "pincode"=>"required",
                "country"=>"required",
                "state"=>"required",
                "city"=>"required",
                "address"=>"required",
            ];
            $customMessage=[
                "name.required" =>  "Name Is Required",
                "mobile.required" =>  "mobile Is Required",
                "address.required" =>  "address Is Required",
                "city.required" =>  "city Is Required",
                "state.required" =>  "state Is Required",
                "country.required" =>  "country Is Required",
                "pincode.required" =>  "pincode Is Required"
            ];
            $validator = Validator::make($data,$rules,$customMessage);
            if($validator->fails()){
                return response()->json($validator->errors(),422);
            }
            //verify user details by id
            $userCount = User::where('id',$data['id'])->count();
            if($userCount>0)
            {
                //updated user details
                User::where('id',$data['id'])->update(['name'=>$data['name'],'address'=>$data['address'],'city'=>$data['city'],'state'=>$data['state'],
                              'country'=>$data['country'],'pincode'=>$data['pincode'],'mobile'=>$data['mobile']
                            ]);

                            //Featch User Details
                $userDetails = User::where('id',$data['id'])->first();
                // Verify the User Password
              
                    return response()->json([
                         "userDetails" =>$userDetails,
                        "status"=>true,
                        "message"=>"User updated Successfully!"
                    ],201);
                }else{
                $message = "User Does Not Exits!";
                return response()->json([
                    "status"=>false,
                    "message"=>$message
                ],422);
             }
           }
    }
    public function cmsPage()
    {
        
        $currentRoute=url()->current();
         $currentRoute= str_replace("http://127.0.0.1:8000/api/","",$currentRoute);
         $cmsRoutes =CmsPage::select('url')->where('status', 1)->get()->pluck('url')->toArray();
         if(in_array($currentRoute,$cmsRoutes)){
                 $cmsPageDetails = CmsPage::where('url',$currentRoute)->get();
                 return response()->json([
                    'cmsPageDetails'=>$cmsPageDetails,
                    'status'=>true,
                    "message"=>"Page Details Fetched Successfully!"
                 ],200);
                 
         }else{
            $message = "Page Does Not Exist!";
            return response()->json([
                "status"=>false,
                "message"=>$message
            ],422);
         }
    }

    public function menu()
    {
        // header('Access-Control-Allow-Orign: *');
        $categories = Section::with('categories')->where('status', 1)->get();
        return response()->json(["categories"=>$categories],200);
    }
    public function listing($url)
    {
        $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
            if ($categoryCount > 0) 
            {
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
                                    $categoryProduct = $categoryProduct->get();
                                    foreach($categoryProduct as $key => $value){
                                        $getDiscountPrice= Product::getDiscountPrice($categoryProduct[$key]['id']);
                                        if($getDiscountPrice>0){
                                            $categoryProduct[$key]['final_price'] = "Rs.".$getDiscountPrice;
                                        }else{
                                            $categoryProduct[$key]['final_price'] = "Rs.".$categoryProduct[$key]['product_price'];
                                        }
                                        $categoryProduct[$key]['product_image']= url("/front/images/product_image/small/".$categoryProduct[$key]['product_image']);
                                    }
                                    return response()->json(['status'=>true,'products'=>$categoryProduct],200);
                                    }else{
                                        $message = "Category URL Is InCorrect";
                                        return response()->json(['status'=>false,'message'=>$message],422);
                                    }
    }
    public function detail($id)
    {
        $productCount = Product::where(['id'=>$id,'status'=>1])->count();
        if($productCount>0){
            $productDetails = Product::with(['category', 'brand', 'attributes' => function ($query) {
                $query->where('stock', '>', 0)->where('status', 1);
            }, 'images', 'section' ,'vendor'])->where('id',$id)->get();
            
            foreach($productDetails as $key => $value){
                $getDiscountPrice= Product::getDiscountPrice($productDetails[$key]['id']);
                if($getDiscountPrice>0){
                    $productDetails[$key]['final_price'] = "Rs.".$getDiscountPrice;
                }else{
                    $productDetails[$key]['final_price'] = "Rs.".$productDetails[$key]['product_price'];
                }
                $productDetails[$key]['product_image']= url("/front/images/product_image/small/".$productDetails[$key]['product_image']);
            }
            return response()->json(['status'=>true,'products'=>$productDetails],200);

        }else{
            $message = "Product Details  Is InCorrect";
            return response()->json(['status'=>false,'message'=>$message],422);
        }
    }

    public function addtoCart(Request $request)
    {

          if($request->isMethod('post')){
            $data = $request->input();
                  // check product if already exists in the user cart
                   $countProducts = Carts::where(['product_id'=>$data['productid'],'size'=>$data['size'],'user_id'=>$data['userid']])->count();
                     if($countProducts>0){
                        $message = "Product is already exists in Cart!";
                        return response()->json(['status'=>false,'message'=>$message],422);
                     }
               // save Product in carts table
               $item = new Carts;
               $item->session_id=0;
               $item->user_id=$data['userid'];
               $item->product_id=$data['productid'];
               $item->size=$data['size'];
               $item->quantity=1;
               $item->source="App";
               $item->save();
               return response()->json([
                'status'=>true,
                "message"=>"Product Successfully Added in User Cart Table!"
             ],200);
          }
    }
       public function cart($userid)
       {
        $getCartItems=Carts::with(['product'=>function($query){
            $query->select('id','category_id','product_name','product_code','product_color','product_image','product_price');
        }])->orderby('id','Desc')->where('user_id',$userid)->get();

        foreach($getCartItems as $key => $item){
            $getDiscountPrice= Product::getDiscountPrice($item['product_id']);
            if($getDiscountPrice>0){
                $getCartItems[$key]['product']['final_price'] = "Rs.".$getDiscountPrice;
            }else{
                $getCartItems[$key]['product']['final_price'] = "Rs.".$item['product']['product_price'];
            }
            $getCartItems[$key]['product']['product_image']= url("/front/images/product_image/small/".$item['product']['product_image']);
        }
        //  dd( $getCartItems);
        return response()->json(["products"=>$getCartItems],200);
       }
       public function deleteCartItem($cartid)
       {
           Carts::where('id',$cartid)->delete();
           return response()->json([
            'status'=>true,
            "message"=>"Product Successfully Added in User Cart Table!"
         ],200);
       }
    public function checkout($userid)
    {
        $getCartItems=Carts::with(['product'=>function($query){
            $query->select('id','category_id','product_name','product_code','product_color','product_image','product_price');
        }])->orderby('id','Desc')->where('user_id',$userid)->get();
         
        $total_price= 0;
        foreach($getCartItems as $key => $item){
            $getDiscountPrice= Product::getDiscountPrice($item['product_id']);
            if($getDiscountPrice>0){
                $getCartItems[$key]['product']['final_price'] = "Rs.".$getDiscountPrice;
                $total_price= $total_price + $getDiscountPrice;
            }else{
                $getCartItems[$key]['product']['final_price'] = "Rs.".$item['product']['product_price'];
                $total_price= $total_price + $item['product']['product_price'];
            }
            $getCartItems[$key]['product']['product_image']= url("/front/images/product_image/small/".$item['product']['product_image']);
        }
        foreach($getCartItems as $key => $item){
            $getCartItems[$key]['product']['total_price'] = $total_price;
            $getCartItems[$key]['product']['key'] = $key;
        }

        // echo $total_price; die;
        //  dd( $getCartItems);
        return response()->json(["products"=>$getCartItems],200);
    }
}


