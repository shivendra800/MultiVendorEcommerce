<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $gurad = 'product';

    public function section()
    {
        return $this->belongsTo('App\Models\Section', 'section_id');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }
    public function attributes()
    {
        return $this->hasMany('App\Models\ProductsAttribute');
    }

    public function images()
    {
        return $this->hasMany('App\Models\ProductsImage');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id')->with('vendorBusinessDetails');
    }



    public static function getDiscountPrice($product_id){
        $proDetails=Product::select('product_price','product_discount','category_id')->where('id',$product_id)->first();
        $proDetails =json_decode(json_encode($proDetails),true);

        $catDetails=Category::select('category_discount')->where('id',$proDetails['category_id'])->first();
        $catDetails =json_decode(json_encode($catDetails),true);

        if($proDetails['product_discount']>0){
            // If product discount is added from admin panel
            $discounted_price=$proDetails['product_price']-($proDetails['product_price']*$proDetails['product_discount']/100);
        }
        elseif($catDetails['category_discount']>0){
            // If Product Discount is not added but Category discount is added from admin panel
            $discounted_price=$proDetails['product_price']-($proDetails['product_price']*$catDetails['category_discount']/100);
        }else{
            $discounted_price=0;
        }
        return $discounted_price;
    }

    public static function getDiscountAttributePrice($product_id,$size)
    {
            $proAtrrPrice= ProductsAttribute::where(['product_id'=>$product_id,'size'=>$size])->first()->toArray();
            $proDetails=Product::select('product_discount','category_id')->where('id',$product_id)->first();
            $proDetails =json_decode(json_encode($proDetails),true);
            $catDetails=Category::select('category_discount')->where('id',$proDetails['category_id'])->first();
            $catDetails =json_decode(json_encode($catDetails),true);
            if($proDetails['product_discount']>0){
                // If product discount is added from admin panel
                $final_price=$proAtrrPrice['price']-($proAtrrPrice['price']*$proDetails['product_discount']/100);
                $discount=$proAtrrPrice['price']-$final_price;
            }
            elseif($catDetails['category_discount']>0){
                // If Product Discount is not added but Category discount is added from admin panel
                $final_price=$proAtrrPrice['price']-($proAtrrPrice['price']*$catDetails['category_discount']/100);
                $discount=$proAtrrPrice['price']-$final_price;
            }else{
                $final_price= $proAtrrPrice['price'];
                $discount=0;
            }
             return array('product_price'=>$proAtrrPrice['price'],'final_price'=>$final_price,'discount'=>$discount);
    }

    public static function isProductNew($product_id){
        //Get Last 3 Products as new
        $productIds=Product::select('id')->where('status',1)->orderby('id','Desc')->limit(3)->pluck('id');
         $productIds=json_decode(json_encode($productIds),true);
         if(in_array($product_id,$productIds)){
            $isProductNew ="Yes";
         }else{
            $isProductNew ="No";
         }

         return $isProductNew;

    }
    public static function getProductImage($product_id)
    {
        $getProductImage = Product::select('product_image')->where('id',$product_id)->first()->toArray();
        return $getProductImage['product_image'];
    }
    public static function getProductStatus($product_id)
    {
        $getProductStatus=Product::select('status')->where('id',$product_id)->first();
        return $getProductStatus->status;
    }
    public static function deleteCartProduct($product_id)
    {
        Carts::where('product_id',$product_id)->delete();
    }

}
