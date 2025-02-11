<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryRecords = [
            [

                'id' => 1,
                'parent_id' => '0',
                'section_id' => '1',
                'category_name' => 'Women',
                'category_image' => '',
                'category_discount' => '0',
                'description' => '',
                'url' => 'Women',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
                'status' => 0
            ],

            [

                'id' => 2,
                'parent_id' => '0',
                'section_id' => '1',
                'category_name' => 'kid',
                'category_image' => '',
                'category_discount' => '0',
                'description' => '',
                'url' => 'kid',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
                'status' => 0
            ],

            [

                'id' => 3,
                'parent_id' => '0',
                'section_id' => '1',
                'category_name' => 'Men',
                'category_image' => '',
                'category_discount' => '0',
                'description' => '',
                'url' => 'men',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
                'status' => 0
            ],
        ];

        Category::insert($categoryRecords);
    }
}