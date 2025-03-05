<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use DB;



class Subcategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $table = "subcategories";

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
    
    public function translations()
    {
        return $this->hasMany(SubCategoryTranslation::class, 'subcategory_id');
    }
    
    /**
     * Fetch list of categories from here
    **/
    public static function getLists($search){
        try {
            
            $obj = new self;

            $pagination = (isset($search['perpage']))?$search['perpage']:config('constant.pagination');

            if(isset($search['name']) && !empty($search['name'])){
                $obj = $obj->where('name', 'like', '%'.trim($search['name']).'%');
                $cat = Subcategory::where('name', 'like', '%'.trim($search['name']).'%')->get();
            } 

            if(isset($search['status']) && $search['status']!=''){
                $obj = $obj->where('status',$search['status']);
            } 

            if(isset($search['category_id']) && $search['category_id']!=''){
                $obj = $obj->where('category_id',$search['category_id']);
            } 
    
            $data = $obj->with('category')->orderBy('id', 'DESC')->paginate($pagination)->appends('perpage', $pagination);

            return $data;
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }

    /**
     * Add or update Subcategory
    **/
    public static function addUpdate($data,$id=0) {
      
        try {
            $obj = new self;
            unset($data['_token']);
            
            if(isset($data['image']) && $data['image']!=''){
                $uploadImage = \Helpers::uploadFiles($data['image'],'category/');
                if($uploadImage['status']==true){
                    $data['image'] = $uploadImage['file_name'];
                }
            }
      
            $slug = \Helpers::createSlug($data['name'],'subcategory',$id,false);
          
            $data['slug'] = $slug;
          
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
            $data = Subcategory::where('id', $id)->first();

            // Assuming 'status' is an ENUM column with values '0' and '1'
            $newStatus = ($data->status == '1') ? '0' : '1';

            $data->update(['status' => $newStatus]);

            return ['status' => true, 'message' => __('lang.admin_data_change_msg')];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
        }
    }

     public static function updatepopular($id){
        try {
            $data = Subcategory::where('id', $id)->first();

            // Assuming 'status' is an ENUM column with values '0' and '1'
            $newStatus = ($data->is_popular == '1') ? '0' : '1';

            $data->update(['is_popular' => $newStatus]);

            return ['status' => true, 'message' => __('lang.admin_data_change_msg')];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
        }
    }




}
