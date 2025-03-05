<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        
       

        $this->call(CategorySeeder::class);
         $this->call(SubcategorySeeder::class);
           $this->call(BrandSeeder::class);
         $this->call(AttributesSeeder::class);
         $this->call(BannerSeeder::class);
           $this->call(TaxSeeder::class);
            $this->call(CountrySeeder::class);
             $this->call(StateSeeder::class);
             $this->call(CitySeeder::class);
              $this->call(CMSSeeder::class);
                $this->call(CurrencySeeder::class);
        
           
        //      $this->call(ProductSeeder::class);
        //   $this->call(ProductImageSeeder::class);
          $this->call(CoustombannerSeeder::class);
         $this->call(LanguageCodesSeeder::class);
        $this->call(LanguagesSeeder::class);
        $this->call(UserSeeder::class);
           $this->call(SettingsSeeder::class);
         $this->call(ShippingtypeSeeder::class);
              $this->call(LocationSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(RoleHasPermissionSeeder::class);
      
        
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
