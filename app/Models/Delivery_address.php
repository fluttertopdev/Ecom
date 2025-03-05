<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
class Delivery_address extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "delivery_address";


   
public function country()
{
    return $this->belongsTo(Country::class, 'country_id');
}

public function state()
{
    return $this->belongsTo(State::class, 'state_id');
}


public function city()
{
    return $this->belongsTo(City::class, 'city_id');
}
   

  public static function deliverygetLists()
{
    try {
        // Check if user is authenticated and is a customer
      
     
         $user_id = Auth::guard('customer')->user()?->id ?? null;
        // Initialize query
        $query = self::query();

        // Apply where clause if user_id is set
        if ($user_id) {
            $query->where('user_id', $user_id);
        }

        // Fetch data with relationships and paginate
        $data = $query->with(['country', 'state', 'city'])
                      ->orderBy('id', 'DESC')
                      ->paginate(config('constant.paginate.num_per_page'));

        return $data;

    } catch (\Exception $e) {
        // Return error information
        return [
            'status' => false,
            'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()
        ];
    }
}




  


}
