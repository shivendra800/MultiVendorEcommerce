<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $gurad = 'admin';

    public function vendorPersonal()
    {
        return $this->belongsTo('App\Models\Vendor',  'vendor_id');
    }
    public function vendorBusiness()
    {

        return $this->belongsTo('App\Models\VendorsBusinessDetail','id', 'vendor_id');

    }
    public function vendorBank()
    {
        return $this->belongsTo('App\Models\VendorsBankDetail', 'id', 'vendor_id');
    }
}
