<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class Product_variants extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
      protected $table = "product_variant";
    protected $fillable = [
        'name',
        'type',
         'text_inputs',
         'color_inputs',
         'product_id',
         'unique_id'
     
    ];
    
    

  

   
}
