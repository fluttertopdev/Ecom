<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use DB;

class Deliveryman extends Model
{
    
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $table = "deliverymans";

    // Define the relationship with area
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    
    /**
     * Fetch list of from here
    **/
    public static function getLists($search){
        try {
            
            $obj = new self;

            $pagination = (isset($search['perpage']))?$search['perpage']:config('constant.pagination');

            if(isset($search['name']) && !empty($search['name'])){
                $obj = $obj->where('name', 'like', '%'.trim($search['name']).'%');
            } 


            if(isset($search['status']) && $search['status']!=''){
                $obj = $obj->where('status',$search['status']);
            } 

            if(isset($search['area_id']) && $search['area_id']!=''){
                $obj = $obj->where('area_id',$search['area_id']);
            } 
    
            $data = $obj->with('area')->orderBy('id', 'DESC')->paginate($pagination)->appends('perpage', $pagination);

            return $data;
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }

    /**
     * Add or update
    **/
    public static function addUpdate($data,$id=0) {
         
         
        
        try {
            $obj = new self;
            unset($data['_token']);
            unset($data['confirm_password']);

            if(isset($data['image']) && $data['image']!=''){
                $uploadImage = \Helpers::uploadFiles($data['image'],'deliveryman/');
                if($uploadImage['status']==true){
                    $data['image'] = $uploadImage['file_name'];
                }
            }

            if(isset($data['identity_front_image']) && $data['identity_front_image']!=''){
                $uploadImage = \Helpers::uploadFiles($data['identity_front_image'],'identity_front_image/');
                if($uploadImage['status']==true){
                    $data['identity_front_image'] = $uploadImage['file_name'];
                }
            }

             if(isset($data['identity_back_image']) && $data['identity_back_image']!=''){
                $uploadImage = \Helpers::uploadFiles($data['identity_back_image'],'identity_back_image/');
                if($uploadImage['status']==true){
                    $data['identity_back_image'] = $uploadImage['file_name'];
                }
            }

            if(isset($data['driving_license']) && $data['driving_license']!=''){
                $uploadImage = \Helpers::uploadFiles($data['driving_license'],'driving_license/');
                if($uploadImage['status']==true){
                    $data['driving_license'] = $uploadImage['file_name'];
                }
            }
          
            if($id==0){
                $data['created_at'] = date('Y-m-d H:i:s');
                $category_id = $obj->insertGetId($data);
                return ['status' => true, 'message' => __('lang.admin_data_add_msg')];
            }
            else{
                $data['updated_at'] = date('Y-m-d H:i:s');
                $obj->where('id',$id)->update($data);
                return ['status' => true, 'message' => __('lang.admin_data_update_msg')];
            }  
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }

    /**
     * Delete particular
    **/
    public static function deleteRecord($id) {
        try {
            $obj = new self;    
            $obj->where('id',$id)->delete();   
            return ['status' => true, 'message' => __('lang.admin_data_delete_msg')];
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }

    /**
     * Update Columns 
    **/
    public static function updateColumn($id){
        try {
            $data = self::where('id', $id)->first();

            // Assuming 'status' is an ENUM column with values '0' and '1'
            $newStatus = ($data->status == '1') ? '0' : '1';

            $data->update(['status' => $newStatus]);

            return ['status' => true, 'message' => __('lang.admin_data_change_msg')];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
        }
    }

}
