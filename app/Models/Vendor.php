<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory;

    public function vendorBusinessDetails()
    {
        return $this->belongsTo('App\Models\VendorsBusinessDetail','id', 'vendor_id');
    }

    public static function getVendorShop($vendorid)
    {
        $getVendorShop= VendorsBusinessDetail::select('shop_name')->where('vendor_id',$vendorid)->first()->toArray();
//dd($getVendorShop);
      return $getVendorShop['shop_name'];

    }
}


