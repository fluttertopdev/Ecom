<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cms;
use DB;

class CMSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categoryArr = [
            array(
                'id'=>1,
                'title' => 'Term and Condition', 
                 'type' => 'user', 
                'slug' => 'term-and-condition',
                'des'=>'<p><strong>1. Collection of Personal Data.</strong></p><p><strong>1.1 Definition of personal data</strong></p><p>Personal data means any information relating to an identified or identifiable natural person (‘data subject’); an identifiable natural person is one who can be identified, directly or indirectly, in particular by reference to an identifier such as a name, an identification number, location data.Personal data does not include data that has been irreversibly anonymized or aggregated so that it can no longer enable us, whether in combination with other information or otherwise, to identify you..</p><p>Here is a description of the types of personal data we may collect and how we may use it:.</p><p><strong>1.2 What Personal Data We Collect</strong></p><p>Depending on the products and services you choose, we collect different kinds of personal data from or about you..</p><p><strong>(a) Data you provide.</strong>We collect the personal data you provide when you create an account to use our products and services or otherwise interact with us, such as when you fill in account information, participate in our online survey or promotional operations, leave a comments about the products, and use our online help or online chat tool or email us.</p><p>&nbsp;</p>',
                'status'=> '1',
            ),
            
            
             array(
                'id'=>2,
                'title' => 'Seller Term and Condition', 
                 'type' => 'seller', 
                'slug' => 'seller-term-and-condition',
                'des'=>'<p><strong>1.1 Definition of personal data</strong></p><p>Personal data means any information relating to an identified or identifiable natural person (‘data subject’); an identifiable natural person is one who can be identified, directly or indirectly, in particular by reference to an identifier such as a name, an identification number, location data.Personal data does not include data that has been irreversibly anonymized or aggregated so that it can no longer enable us, whether in combination with other information or otherwise, to identify you..</p><p>Here is a description of the types of personal data we may collect and how we may use it:.</p><p><strong>1.2 What Personal Data We Collect</strong></p><p>Depending on the products and services you choose, we collect different kinds of personal data from or about you..</p><p><strong>(a) Data you provide.</strong>We collect the personal data you provide when you create an account to use our products and services or otherwise interact with us, such as when you fill in account information, participate in our online survey or promotional operations, leave a comments about the products, and use our online help or online chat tool or email us.</p>',
                'status'=> '1',
            ),
        ];


        // Insert data into the category table if the title does not exist
        foreach ($categoryArr as $cat) {
            $existingCategory = DB::table('cms_managements')->where('title', $cat['title'])->first();

            if (!$existingCategory) {
                DB::table('cms_managements')->insert($cat);
            }
        }
    }
}
