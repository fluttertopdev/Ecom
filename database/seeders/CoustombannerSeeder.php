<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Homepage;
use DB;

class CoustombannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categoryArr = [
            array(
                'id'=>1,
                'title' => 'single banner', 
                'slug' => \Helpers::createSlug('single banner','coustomproduct',0,false),
                 'section_type' => 'Banner',
                 'banner_type' => 'single',
                 'single_bannerimg' => '95611739366959.jpg',
                'singlebanner_url' => 'wwwwwww',
                    'status'=> '1',
            ),
        ];


        // Insert data into the category table if the title does not exist
        foreach ($categoryArr as $cat) {
            $existingCategory = DB::table('homepages')->where('title', $cat['title'])->first();

            if (!$existingCategory) {
                DB::table('homepages')->insert($cat);
            }
        }
    }
}
