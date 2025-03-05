<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Currencies;
use DB;

class CurrencySeeder extends Seeder
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
                 'symbol' => '₹', 
                'code' => 'INR',
                'status'=> '1',
            ),
        ];


        // Insert data into the category table if the title does not exist
        foreach ($categoryArr as $cat) {
            $existingCategory = DB::table('currencies')->where('name', $cat['name'])->first();

            if (!$existingCategory) {
                DB::table('currencies')->insert($cat);
            }
        }
    }
}
