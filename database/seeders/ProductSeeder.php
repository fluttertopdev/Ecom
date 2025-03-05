<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categoryArr = [
            array(
                'id'=>1,
                'name' => 'test product', 
                
                'slug' => 'test-product',
                'categories_id'=>'1',
                'subcategories_id'=>'1',
                'brand_id'=>'1',
                'description'=>'<p>lorem</p>',
                 'short_des'=>'<p>lorem</p>',
                 'price'=>'80000',
               'unique_id'=>'11002148',
                  'discount'=>'3',
                    'discountamount'=>'2400',
                      'qty'=>'200',
                    'producttype'=>'admin',
                       'producttype'=>'admin',  
                     'created_by'=>'1',
                'status'=> '1',
            ),
        ];


        // Insert data into the subcategories table if the title does not exist
        foreach ($categoryArr as $cat) {
            $existingCategory = DB::table('products')->where('name', $cat['name'])->first();

            if (!$existingCategory) {
                DB::table('products')->insert($cat);
            }
        }
    }
}
