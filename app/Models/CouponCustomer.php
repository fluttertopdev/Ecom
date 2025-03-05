<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class CouponCustomer extends Model
{
    
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = "coupon_customers";
    

}
