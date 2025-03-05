<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class ProductImages extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
      protected $table = "products_image";
    protected $fillable = [
        'image',
        'product_id',
        'uniqueId',
        'is_default'
     
    ];
    
    

  

   
}
