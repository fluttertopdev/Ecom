<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class Product_variants_values extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
      protected $table = "product_variant_values";
    protected $fillable = [
        'product_id',
        'price',
         'sku',
         'specialprice',
         'stockavailability',
         'specialricestart',
          'specialpriceend',
           'isdefault',
          'unique_id',
          'variant',
          'status',
          'inventoryManagement',
          'qty',
          'images',
          'combinevariant'
     
    ];
    
    

  

   
}
