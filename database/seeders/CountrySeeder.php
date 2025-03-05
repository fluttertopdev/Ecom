<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;
use DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categoryArr = [
            array(
                'id'=>1,
                'name' => 'India', 
           
            ),
        ];


        // Insert data into the countries table if the title does not exist
        foreach ($categoryArr as $cat) {
            $existingCategory = DB::table('countries')->where('name', $cat['name'])->first();

            if (!$existingCategory) {
                DB::table('countries')->insert($cat);
            }
        }
    }
}
