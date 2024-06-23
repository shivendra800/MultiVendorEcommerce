<?php

namespace Database\Seeders;

use App\Models\VendorsBusinessDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorsBusinessDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRecords = [
            [
                'id' => 1, 'vendor_id' => 1, 'shop_name' => 'vendor Electronics Store', 'shop_address' => 'adads', 'shop_city' => 'lucknow', 'shop_state' => 'up', 'shop_country' => 'India', 'shop_pincode' => '111111', 'shop_mobile' => '9876543210', 'shop_website' => 'sss.in', 'shop_email' => 'vendor@admin.com', 'address_proof' => 'Passport',
                'address_proof_image' => 'test.jpg', 'business_license_number' => '1234567890', 'gst_number' => '44444444', 'pan_number' => '23232323'
            ],
        ];
        VendorsBusinessDetail::insert($vendorRecords);
    }
}