<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryAddress extends Model
{
    use HasFactory;

    protected $fillable = [
             'user_id','name','	address','city','state','country','pincode','mobile','status'
    ];

    public static function deliveryAddresses()
    {
        $deliveryAddresses = DeliveryAddress::where('user_id',Auth::user()->id)->get()->toArray();
        return $deliveryAddresses;
    }
}
