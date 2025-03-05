<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductImages;
use DB;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categoryArr = [
            array(
                'id'=>1,
                'image' => '88941739425809.jpg', 
                 'product_id' => '1', 
                'uniqueId' => '11002148',
                'is_default'=>'1',
              
            ),
        ];


        // Insert data into the products_image table if the title does not exist
        foreach ($categoryArr as $cat) {
            $existingCategory = DB::table('products_image')->where('image', $cat['image'])->first();

            if (!$existingCategory) {
                DB::table('products_image')->insert($cat);
            }
        }
    }
}
