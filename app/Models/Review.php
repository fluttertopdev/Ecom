<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Review extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "reviews";


   
public function user()
{
    return $this->belongsTo(User::class);
}
   
  


public static function reviewsgetLists($id)
{
    try {
        // Query the reviews with related user information
        $data = self::with(['user']) // Ensure 'user' relationship exists in the model
            ->where('product_id', $id) // Filter by product_id
            ->orderBy('id', 'DESC') // Order by descending ID
            ->get();

        return $data;
    } catch (\Exception $e) {
        // Handle exceptions and return detailed error information
        return [
            'status' => false,
            'message' => $e->getMessage() . ' on line ' . $e->getLine() . ' in file ' . $e->getFile(),
        ];
    }
}



  


}
