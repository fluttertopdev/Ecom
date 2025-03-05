<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;



class VariantImage extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
      protected $table = "variantimage";
    protected $fillable = [
        'variant_id',
        'image_path',
         'unique_id',
         'product_unique_id'
       
     
    ];
    
    

  

   
}
