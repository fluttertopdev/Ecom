<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
use DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categoryArr = [
            array(
                'id'=>1,
                'name' => 'Test Brand', 
                 'image' => '88971739425767.jpg', 
                'slug' => 'test-brand',
                'status'=> '1',
            ),
        ];


        // Insert data into the brands table if the title does not exist
        foreach ($categoryArr as $cat) {
            $existingCategory = DB::table('brands')->where('name', $cat['name'])->first();

            if (!$existingCategory) {
                DB::table('brands')->insert($cat);
            }
        }
    }
}
