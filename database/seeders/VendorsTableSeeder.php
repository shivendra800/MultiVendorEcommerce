<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorsTableSeeder extends Seeder
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
                'id' => 1,
                'name' => 'Vendor',
                'address' => 'lucnkow',
                'city' => 'lucnkow',
                'state' => 'up',
                'country' => 'indian',
                'pincode' => '112234',
                'mobile' => '9999999999',
                'email' => 'vendor@admin.com',

                'status' => 0
            ],

        ];
        Vendor::insert($vendorRecords);
    }
}