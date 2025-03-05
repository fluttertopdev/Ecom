<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;
use DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categoryArr = [
            array(
                'id'=>1,
                'name' => 'Madhya Pradesh', 
                'countryid' => '1',
              
           
            ),
            
              array(
                'id'=>2,
                'name' => 'UP', 
                'countryid' => '1',
              
           
            ),
        ];


        // Insert data into the countries table if the title does not exist
        foreach ($categoryArr as $cat) {
            $existingCategory = DB::table('states')->where('name', $cat['name'])->first();

            if (!$existingCategory) {
                DB::table('states')->insert($cat);
            }
        }
    }
}
