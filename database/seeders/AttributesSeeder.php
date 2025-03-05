<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Attribute;
use DB;

class AttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categoryArr = [
            array(
                'id'=>1,
                'name' => 'Test Attribute', 
               
           
            ),
        ];


        // Insert data into the attributes table if the title does not exist
        foreach ($categoryArr as $cat) {
            $existingCategory = DB::table('attributes')->where('name', $cat['name'])->first();

            if (!$existingCategory) {
                DB::table('attributes')->insert($cat);
            }
        }
    }
}
