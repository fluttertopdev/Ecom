<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Banner;
use DB;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categoryArr = [
            array(
                'id'=>1,
                'name' => 'lorem',
                'image' => '10731739366805.png',
                'type' => 'mainbanner', 
                'link' => 'www', 
                'status'=> '1',
            ),
        ];


        // Insert data into the banners table if the title does not exist
        foreach ($categoryArr as $cat) {
            $existingCategory = DB::table('banners')->where('name', $cat['name'])->first();

            if (!$existingCategory) {
                DB::table('banners')->insert($cat);
            }
        }
    }
}
