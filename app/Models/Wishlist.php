<?php

namespace App\Models; 


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;

class Wishlist extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $table = "wishlist";


   public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
   

     public function productVariantValue()
    {
        return $this->belongsTo(Product_variants_values::class, 'variants_id');
    }
  
  public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }
    
    /**
     * Fetch list of categories from here
    **/
 public static function userwishlistproduct()
{
    $currentLanguage = Session::get('website_locale', App::getLocale());
    $user_id = Auth::guard('customer')->user()?->id ?? null;

    return self::where('userid', $user_id)
        ->with([
            'product' => function ($query) use ($currentLanguage) {
                $query->with(['translations' => function ($translationQuery) use ($currentLanguage) {
                    $translationQuery->where('language_code', $currentLanguage);
                }]);
            },
            'productVariantValue',
            'product.product_images' => function ($query) {
                $query->where('is_default', 1);
            },
            'user'
        ])
        ->get()
        ->each(function ($wishlist) use ($currentLanguage) {
            // Set translated product name
            if ($wishlist->product && $wishlist->product->translations) {
                $translatedName = $wishlist->product->translations->first()?->name;
                $wishlist->product->name = $translatedName ?? $wishlist->product->name;
            }
        });
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

        // Fetching categories
        $categories = $obj->where('status', 1)
                          ->where('is_featured', 1)
                          ->orderBy('id', 'DESC')
                          ->get();

        // Fetching subcategories
        $subcategories = \App\Models\Subcategory::where('status', 1)
                                                ->where('is_popular', 1)
                                                ->get()
                                                ->map(function ($subcategory) {
                                                    // Ensure subcategory image and name are correctly set
                                                    $subcategory->image = $subcategory->image; // Ensure it's using the correct image field
                                                    $subcategory->name = $subcategory->name; // Use the correct field for subcategory name
                                                    $subcategory->slug = $subcategory->slug; // Assuming slug is used
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
