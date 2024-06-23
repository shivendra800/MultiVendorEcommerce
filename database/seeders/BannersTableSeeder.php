<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bannerRecords=[
                   ['id'=>1,'image'=>'banner-1.png','link'=>'uifstechnologies.com','title'=>'Spring Collection','alt'=>'Spring Collection','status'=>1],
                   ['id'=>2,'image'=>'banner-2.png','link'=>'uifstechnologies.com','title'=>'Tops','alt'=>'Tops','status'=>1]
        ];
        Banner::insert($bannerRecords);
    }
}
