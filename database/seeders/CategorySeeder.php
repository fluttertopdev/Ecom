<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categoryArr = [
            array(
                'id'=>1,
                'name' => 'Test Category ', 
                 'image' => '36931739369523.jpg', 
                'slug' => \Helpers::createSlug('Test Category ','category',0,false),
                'status'=> '1',
            ),
        ];


        // Insert data into the category table if the title does not exist
        foreach ($categoryArr as $cat) {
            $existingCategory = DB::table('categories')->where('name', $cat['name'])->first();

            if (!$existingCategory) {
                DB::table('categories')->insert($cat);
            }
        }
    }
}
