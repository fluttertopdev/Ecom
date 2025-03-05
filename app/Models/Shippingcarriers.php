<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use DB;

class Shippingcarriers extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $table = "shippingcarriers";


   

 
    public static function getLists($search){
        try {
            
            $obj = new self;

            $pagination = (isset($search['perpage']))?$search['perpage']:config('constant.pagination');

            if(isset($search['name']) && !empty($search['name'])){
                $obj = $obj->where('name', 'like', '%'.trim($search['name']).'%');
                $cat = Shippingcarriers::where('name', 'like', '%'.trim($search['name']).'%')->get();
            } 

            if(isset($search['status']) && $search['status']!=''){
                $obj = $obj->where('status',$search['status']);
            } 
    
            $data = $obj->orderBy('id', 'DESC')->paginate($pagination)->appends('perpage', $pagination);

            return $data;
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }

    /**
     * Add or update category
    **/
    public static function addUpdate($data,$id=0) {
      
        try {
            $obj = new self;
            unset($data['_token']);

            if(isset($data['image']) && $data['image']!=''){
                $uploadImage = \Helpers::uploadFiles($data['image'],'carriers/');
                if($uploadImage['status']==true){
                    $data['image'] = $uploadImage['file_name'];
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
     * Delete particular category
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
            $data = Shippingcarriers::where('id', $id)->first();

            // Assuming 'status' is an ENUM column with values '0' and '1'
            $newStatus = ($data->status == '1') ? '0' : '1';

            $data->update(['status' => $newStatus]);

            return ['status' => true, 'message' => __('lang.admin_data_change_msg')];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
        }
    }




}
