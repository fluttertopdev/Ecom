<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shipping;
use DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categoryArr = [
            array(
                'id'=>1,
                'country_id' => '1', 
                 'state_id' => '1', 
                'city_id' => '1',
                'post_code'=> '452001',
               
                'status'=> '1',
            ),
            
              array(
                'id'=>2,
                'country_id' => '1', 
                 'state_id' => '1', 
                'city_id' => '2',
                'post_code'=> '23232',
               
                'status'=> '1',
            ),
            
              array(
                'id'=>3,
                'country_id' => '1', 
                 'state_id' => '1', 
                'city_id' => '3',
                'post_code'=> '999999',
               
                'status'=> '1',
            ),
        ];


        // Insert data into the location table if the title does not exist
        foreach ($categoryArr as $cat) {
            $existingCategory = DB::table('shippings')->where('post_code', $cat['post_code'])->first();

            if (!$existingCategory) {
                DB::table('shippings')->insert($cat);
            }
        }
    }
}
