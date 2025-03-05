<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class CouponRestaurant extends Model
{
    
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = "coupon_restaurants";

}
