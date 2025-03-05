<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;
use DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categoryArr = [
            array(
                'id'=>1,
                'name' => 'Indore', 
                'countryid' => '1', 
                 'stateid' => '1', 
           
            ),
            
              array(
                'id'=>2,
                'name' => 'Bhopal', 
                'countryid' => '1', 
                 'stateid' => '1', 
           
            ),
            
             array(
                'id'=>3,
                'name' => 'RAJGARH', 
                'countryid' => '1', 
                 'stateid' => '2', 
           
            ),
        ];


        // Insert data into the countries table if the title does not exist
        foreach ($categoryArr as $cat) {
            $existingCategory = DB::table('cities')->where('name', $cat['name'])->first();

            if (!$existingCategory) {
                DB::table('cities')->insert($cat);
            }
        }
    }
}
