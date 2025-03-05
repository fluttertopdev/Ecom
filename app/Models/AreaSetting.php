<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaSetting extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = "area_settings";

    public function area()
    {
        return $this->belongsTo(Area::class);
    }



    /**
     * Fetch list of from here
    **/
    public static function getData($id){
        try {
            
            $obj = new self;
    
            $data = $obj->where('area_id',$id)->with('area')->first();

            return $data;
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }



    /**
     * update
    **/
    public static function updateRecord($data) {
      
        try {
            $obj = new self;
            unset($data['_token']);

            $check = $obj::where('area_id',$data['area_id'])->first();

            if (isset($data['is_increase_delivery_charge_enable'])) {
                if($data['is_increase_delivery_charge_enable']=='on'){
                $data['is_increase_delivery_charge_enable'] = 1;
                }else{
                $data['is_increase_delivery_charge_enable'] = $data['is_increase_delivery_charge_enable'];
                }
            }else{
                $data['is_increase_delivery_charge_enable'] = 0;
            }

            if(!$check){
                $data['created_at'] = date('Y-m-d H:i:s');
                $obj->insertGetId($data);
                return ['status' => true, 'message' => __('lang.admin_data_add_msg')];
            }
            else{
                $data['updated_at'] = date('Y-m-d H:i:s');
                $obj->where('area_id',$data['area_id'])->update($data);
                return ['status' => true, 'message' => __('lang.admin_data_update_msg')];
            }  
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }

}
