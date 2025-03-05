<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use DB;

class Banner extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $table = "banners";


  
    public static function getLists($search){
        try {
            
            $obj = new self;
      
            $pagination = (isset($search['perpage']))?$search['perpage']:config('constant.pagination');

          

            
             $obj = $obj->where('type', 'mainbanner');
            $data = $obj->orderBy('id', 'DESC')->paginate($pagination)->appends('perpage', $pagination);

            return $data;
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }

      public static function producttaggetLists($search){
        try {
            
            $obj = new self;
      
            $pagination = (isset($search['perpage']))?$search['perpage']:config('constant.pagination');

          

            
             $obj = $obj->where('type', 'product_tag');
            $data = $obj->orderBy('id', 'DESC')->paginate($pagination)->appends('perpage', $pagination);

            return $data;
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }


   public static function midsizedgetLists($search)
{
    try {
        $obj = new self;

        // Query to fetch a single record where banner_type is 'midsized'
        $data = $obj->where('type', 'midsized')->first();
        return $data;
    } 
    catch (\Exception $e) {
        return [
            'status' => false, 
            'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()
        ];
    }
}

   public static function homepageicongetlist($search)
{
    try {
        $obj = new self;

        // Query to fetch a single record where banner_type is 'midsized'
        $data = $obj->where('type', 'icon')->get();
        return $data;
    } 
    catch (\Exception $e) {
        return [
            'status' => false, 
            'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()
        ];
    }
}


   
       public static function addUpdate($data,$id=0) {
      
        try {
            $obj = new self;
            unset($data['_token']);

            if(isset($data['image']) && $data['image']!=''){
                $uploadImage = \Helpers::uploadFiles($data['image'],'banner/website_banner');
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

   

    public static function midsizedaddUpdate($data, $id = 0)
{
    try {
        $obj = new self;
        unset($data['_token']);

        // Delete all records with banner_type == 'midsized'
        $obj->where('type', 'midsized')->forceDelete();

        // Process the single_banner_img upload
        if (isset($data['single_banner_img']) && $data['single_banner_img'] != '') {
            $uploadImage = \Helpers::uploadFiles($data['single_banner_img'], 'banner/midsized');
            if ($uploadImage['status'] == true) {
                $data['single_banner_img'] = $uploadImage['file_name'];
            }
        }

        // Process the combo_banner_1 upload
        if (isset($data['combo_banner_1']) && $data['combo_banner_1'] != '') {
            $uploadImage = \Helpers::uploadFiles($data['combo_banner_1'], 'banner/midsized');
            if ($uploadImage['status'] == true) {
                $data['combo_banner_1'] = $uploadImage['file_name'];
            }
        }

        // Process the combo_banner_2 upload
        if (isset($data['combo_banner_2']) && $data['combo_banner_2'] != '') {
            $uploadImage = \Helpers::uploadFiles($data['combo_banner_2'], 'banner/midsized');
            if ($uploadImage['status'] == true) {
                $data['combo_banner_2'] = $uploadImage['file_name'];
            }
        }

        // Insert or update record
        if ($id == 0) {
            // Insert new record
            $data['created_at'] = date('Y-m-d H:i:s');
             $data['type'] = 'midsized';
            $obj->insertGetId($data);
            return ['status' => true, 'message' => __('lang.admin_data_add_msg')];
        } else {
            // Update existing record
            $data['updated_at'] = date('Y-m-d H:i:s');
            $obj->where('id', $id)->update($data);
            return ['status' => true, 'message' => __('lang.admin_data_update_msg')];
        }
    } catch (\Exception $e) {
        return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
    }
}

   
      public static function addUpdatetags($data,$id=0) {
      
        try {
            $obj = new self;
            unset($data['_token']);

          

          
          
          
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


   
    
    public static function updateColumn($id){
        try {
            $data = Banner::where('id', $id)->first();

            // Assuming 'status' is an ENUM column with values '0' and '1'
            $newStatus = ($data->status == '1') ? '0' : '1';

            $data->update(['status' => $newStatus]);

            return ['status' => true, 'message' => __('lang.admin_data_change_msg')];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
        }
    }
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

   

}
