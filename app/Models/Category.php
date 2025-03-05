<?php

namespace App\Models; 


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use DB;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $table = "categories";


    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'category_id', 'id');
    }


    public function items()
    {
        return $this->hasMany(Item::class);
    }
    
    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class, 'category_id');
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
                $cat = Category::where('name', 'like', '%'.trim($search['name']).'%')->get();
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
                $uploadImage = \Helpers::uploadFiles($data['image'],'category/');
                if($uploadImage['status']==true){
                    $data['image'] = $uploadImage['file_name'];
                }
            }

          
            $slug = \Helpers::createSlug($data['name'],'category',$id,false);
          
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
            $data = Category::where('id', $id)->first();

            // Assuming 'status' is an ENUM column with values '0' and '1'
            $newStatus = ($data->status == '1') ? '0' : '1';

            $data->update(['status' => $newStatus]);

            return ['status' => true, 'message' => __('lang.admin_data_change_msg')];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
        }
    }


    /**
     * Update Featured Columns 
    **/
    public static function updateFeaturedColumn($id){
        try {
            $data = Category::where('id', $id)->first();

            // Assuming 'is_featured' is an ENUM column with values '0' and '1'
            $newStatus = ($data->is_featured == '1') ? '0' : '1';

            $data->update(['is_featured' => $newStatus]);

            return ['status' => true, 'message' => __('lang.admin_data_change_msg')];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
        }
    }

public static function frontendgetLists()
{
    try {
        $obj = new self;

        // Get the current language code from the session or fallback to the default locale
        $languageCode = Session::get('website_locale', App::getLocale());
        
        

        // Fetch categories with translations
        $categories = $obj->where('status', 1)
                          ->where('is_featured', 1)
                          ->orderBy('id', 'DESC')
                          ->get()
                          ->map(function ($category) use ($languageCode) {
                              // Fetch category translation for the current language
                              $translation = $category->translations()
                                                      ->where('language_code', $languageCode)
                                                      ->first();
                              // Update category name if translation exists
                              $category->name = $translation ? $translation->name : $category->name;
                              return $category;
                          });

        // Fetch subcategories with translations
        $subcategories = \App\Models\Subcategory::where('status', 1)
                                                ->where('is_popular', 1)
                                                ->get()
                                                ->map(function ($subcategory) use ($languageCode) {
                                                    // Fetch subcategory translation for the current language
                                                    $translation = $subcategory->translations()
                                                                               ->where('language_code', $languageCode)
                                                                               ->first();
                                                    // Update subcategory name if translation exists
                                                    $subcategory->name = $translation ? $translation->name : $subcategory->name;

                                                    // Ensure other fields are correctly set
                                                    $subcategory->image = $subcategory->image;
                                                    $subcategory->slug = $subcategory->slug;

                                                    return $subcategory;
                                                });

        // Merge categories and subcategories into one collection
        $data = $categories->merge($subcategories);

        // Return merged data
        return $data;
    } catch (\Exception $e) {
        return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
    }
}


}
