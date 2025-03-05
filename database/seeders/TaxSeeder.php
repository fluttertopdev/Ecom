<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tax;
use DB;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categoryArr = [
            array(
                'id'=>1,
                'name' => 'GST', 
                  'status'=> '1',
            ),
        ];


        // Insert data into the  taxes table if the title does not exist
        foreach ($categoryArr as $cat) {
            $existingCategory = DB::table('taxes')->where('name', $cat['name'])->first();

            if (!$existingCategory) {
                DB::table('taxes')->insert($cat);
            }
        }
    }
}
