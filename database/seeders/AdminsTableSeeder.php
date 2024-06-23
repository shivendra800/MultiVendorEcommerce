<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRecords = [
            [

                'id' => 1,
                'name' => 'admin',
                'type' => 'super_admin',
                'vendor_id' => 0,
                'mobile' => '9999999999',
                'email' => 'admin@admin.com',
                'password' => '$2a$12$A/DpYAu649z5Zn648FHpXOlgJU21EGYsus1CyEbJJv33iO6Jtw/xW',
                'image' => '',
                'status' => 0
            ],
            [

                'id' => 2,
                'name' => 'Vendor',
                'type' => 'vendor',
                'vendor_id' => 1,
                'mobile' => '9999999999',
                'email' => 'vendor@admin.com',
                'password' => '$2a$12$A/DpYAu649z5Zn648FHpXOlgJU21EGYsus1CyEbJJv33iO6Jtw/xW',
                'image' => '',
                'status' => 0
            ],

        ];
        Admin::insert($adminRecords);
    }
}