<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(AdminsTableSeeder::class);
        // $this->call(VendorsTableSeeder::class);
        // $this->call(VendorsBusinessDetailsTableSeeder::class);
        // $this->call(VendorsBankDetailsTableSeeder::class);
        // $this->call(SectionTableSeeder::class);
        // $this->call(CategoryTableSeeder::class);
        // $this->call(BrandTableSeeder::class);
        // $this->call(ProductTableSeeder::class);
        // $this->call(ProductsAttributesTableSeeder::class);
        // $this->call(BannersTableSeeder::class);
        // $this->call(FiltersTableSeeder::class);
        // $this->call(FiltersValuesTableSeeder::class);
        // $this->call(CouponTableSeeder::class);
        // $this->call(DeliveryAddressTableSeeder::class);
        $this->call(OrderStatusTableSeeder::class);
    }
}
