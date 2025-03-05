<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AppliedCoupon extends Model
{
    
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = "applied_coupons";
    

}
