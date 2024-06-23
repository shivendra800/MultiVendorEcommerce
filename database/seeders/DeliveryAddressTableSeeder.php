<?php

namespace Database\Seeders;

use App\Models\DeliveryAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deliveryAddressRecords = [
            ['id' => 1, 'user_id' => '1', 'name' => 'shivam', 'address' => 'indiranagar','city'=>'lucknow','state'=>'Uttar Pradesh','country'=>'India','pincode'=>'226012','mobile'=>'9876543211', 'status' => 1],
            ['id' => 2, 'user_id' => '1', 'name' => 'shiv', 'address' => 'sector-18,indiranagar','city'=>'lucknow','state'=>'Uttar Pradesh','country'=>'India','pincode'=>'226016','mobile'=>'9876543210', 'status' => 1],
        ];

        DeliveryAddress::insert($deliveryAddressRecords);
    }
}
