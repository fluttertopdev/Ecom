<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subcategory;
use DB;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categoryArr = [
            array(
                'id'=>1,
                'name' => 'test subcategory', 
                 'image' => '77451739425617.jpg', 
                'slug' => 'test-subcategory',
                'is_popular'=>'0',
                'category_id'=>'1',
                'status'=> '1',
            ),
        ];


        // Insert data into the subcategories table if the title does not exist
        foreach ($categoryArr as $cat) {
            $existingCategory = DB::table('subcategories')->where('name', $cat['name'])->first();

            if (!$existingCategory) {
                DB::table('subcategories')->insert($cat);
            }
        }
    }
}
