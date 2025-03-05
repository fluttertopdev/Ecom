<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class Productattribute extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
      protected $table = "products_attribute";
    protected $fillable = [
        'attributes_id',
        'attributes_value',
        'product_id'
     
    ];
    
    

  

   
}
