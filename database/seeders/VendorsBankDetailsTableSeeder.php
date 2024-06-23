<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VendorsBankDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VendorsBankDetailsTableSeeder extends Seeder
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
                'id' => 1, 'vendor_id' => 1, 'account_holder_name' => 'vendor', 'account_number' => '1234567890', 'bank_name' => 'sbi', 'bank_ifsc_code' => 'ewewf43'

            ],
        ];
        VendorsBankDetail::insert($vendorRecords);
    }
}