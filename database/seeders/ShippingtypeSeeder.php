<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shippingrate_type;
use DB;

class ShippingtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categoryArr = [
            array(
                'id'=>1,
                'name' => 'Per Orders', 
                 'des' => 'Shipping rates as per orders', 
               
                'status'=> '1',
            ),
        ];


        // Insert data into the shippingratestypes table if the title does not exist
        foreach ($categoryArr as $cat) {
            $existingCategory = DB::table('shippingratestypes')->where('name', $cat['name'])->first();

            if (!$existingCategory) {
                DB::table('shippingratestypes')->insert($cat);
            }
        }
    }
}
