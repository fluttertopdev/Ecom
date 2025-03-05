<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Shippingrate_type extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "shippingratestypes";


   

   
   
    public static function updateColumn($id){
        try {
            $data = Shippingrate_type::where('id', $id)->first();

            // Assuming 'status' is an ENUM column with values '0' and '1'
            $newStatus = ($data->status == '1') ? '0' : '1';

            $data->update(['status' => $newStatus]);

            return ['status' => true, 'message' => __('lang.admin_data_change_msg')];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
        }
    }



  


}
