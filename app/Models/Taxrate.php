<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Taxrate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "taxrates";


   
public function tax()
{
    return $this->belongsTo(Tax::class, 'tax_id', 'id');
}
   
  



  


}
