<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Homepage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use DB;






class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'name',
        'categories_id',
        'subcategories_id',
        'brand_id',
        'description',
        'image',
        'price',
        'discount',
        'qty',
        'status',
        'is_featured',
        'slug',
        'created_by',
        'unique_id',
        'refundable',
        'stockqty',
        'producttype',
        'short_des',
        'bestseller',
        'visibilityid',
        'EncInc',
         'discountamount',
         'variant_id',
          'producttaxprice',
 
    ];
    
    
public function reviews()
{
    return $this->hasMany(Review::class, 'product_id');
}


 public function category()
{
    return $this->belongsTo(Category::class, 'categories_id');
}

 public function subcategory()
{
    return $this->belongsTo(Subcategory::class, 'subcategories_id');
}

 public function visibility()
{
    return $this->belongsTo(Visibilitie::class, 'visibilityid');
}
public function brand()
{
    return $this->belongsTo(Brand::class, 'brand_id');
}

public function Banner()
{
    return $this->belongsTo(Banner::class, 'tag_id');
}

    public function product_image()
    {
        return $this->hasOne('\App\Models\ProductImages','product_id','id');
    }

    public function product_images()
    {
        return $this->hasMany('\App\Models\ProductImages','product_id','id');
    }

public function productVariants()
{
    return $this->hasMany(Product_variants_values::class, 'product_id');
}
 
public function user()
{
    return $this->belongsTo(User::class);
}

public function translations()
{
    return $this->hasMany(ProductTranslation::class);
}
public function taxRates()
{
    return $this->hasMany(Taxrate::class, 'product_id');
}

    

    public static function getLists()
    {
        try {
            $query = new Self;

          if(isset($_GET['name']) && trim($_GET['name']) != '') {
    $query = $query->where(DB::raw('LOWER(name)'), 'like', '%' . strtolower(trim($_GET['name'])) . '%');
}
            if(isset($_GET['categories_id']) && $_GET['categories_id'] != ''){
            $query = $query->where('categories_id', $_GET['categories_id']);
        }
        if(isset($_GET['brand_id']) && $_GET['brand_id'] != ''){
            $query = $query->where('brand_id', $_GET['brand_id']);
        }
            if(isset($_GET['is_subscribe']) && $_GET['is_subscribe']!=''){
                $query = $query->where('is_subscribe',$_GET['is_subscribe']);
            }
            if(isset($_GET['status']) && $_GET['status']!=''){
                $query = $query->where('status',$_GET['status']);
            }
           $data = $query->with(['category', 'productVariants']) // Join with product variant values model
                      ->orderBy('id', 'DESC')
                      ->paginate(config('constant.paginate.num_per_page'));
            if(count($data)){
                foreach($data as $row){
                     $product_image = ProductImages::where('product_id',$row->id)->where('is_default','1')->first();
                    $row->product_image = "";
                    if($product_image){
                        $row->product_image = $product_image->image;
                    }
                }
            }
            return $data;
        }catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }







public static function sellersgetLists()
{
  
     
     
   
    try {
        $query = new Self;
       
        $query = $query->where('created_by','!=',1); 
              if(isset($_GET['name']) && trim($_GET['name']) != '') {
    $query = $query->where(DB::raw('LOWER(name)'), 'like', '%' . strtolower(trim($_GET['name'])) . '%');
}
            if(isset($_GET['categories_id']) && $_GET['categories_id'] != ''){
            $query = $query->where('categories_id', $_GET['categories_id']);
        }
        if(isset($_GET['brand_id']) && $_GET['brand_id'] != ''){
            $query = $query->where('brand_id', $_GET['brand_id']);
        }
            if(isset($_GET['is_subscribe']) && $_GET['is_subscribe']!=''){
                $query = $query->where('is_subscribe',$_GET['is_subscribe']);
            }
            if(isset($_GET['status']) && $_GET['status']!=''){
                $query = $query->where('status',$_GET['status']);
            }
            
            if(isset($_GET['seller_id']) && $_GET['seller_id'] != ''){
            $query = $query->where('created_by', $_GET['seller_id']);
        }
        // Load related category data with the query
        $data = $query->with('category')->orderBy('id', 'DESC')->paginate(config('constant.paginate.num_per_page'));

        if(count($data)){
            foreach($data as $row){
                $product_image = ProductImages::where('product_id', $row->id)->where('is_default', '1')->first();
                $row->product_image = "";
                if($product_image){
                    $row->product_image = $product_image->image;
                }
            }
        }

        return $data;
    } catch (\Exception $e) {
        return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
    }
}



public static function sellersproductgetLists()
{
  
     
     $userid = Auth::guard('seller')->user()?->id ?? null;
     
   
    try {
        $query = new Self;
       
        $query = $query->where('created_by',$userid); 
              if(isset($_GET['name']) && trim($_GET['name']) != '') {
    $query = $query->where(DB::raw('LOWER(name)'), 'like', '%' . strtolower(trim($_GET['name'])) . '%');
}
            if(isset($_GET['categories_id']) && $_GET['categories_id'] != ''){
            $query = $query->where('categories_id', $_GET['categories_id']);
        }
        if(isset($_GET['brand_id']) && $_GET['brand_id'] != ''){
            $query = $query->where('brand_id', $_GET['brand_id']);
        }
            if(isset($_GET['is_subscribe']) && $_GET['is_subscribe']!=''){
                $query = $query->where('is_subscribe',$_GET['is_subscribe']);
            }
            if(isset($_GET['status']) && $_GET['status']!=''){
                $query = $query->where('status',$_GET['status']);
            }
            
            if(isset($_GET['seller_id']) && $_GET['seller_id'] != ''){
            $query = $query->where('created_by', $_GET['seller_id']);
        }
        // Load related category data with the query
        $data = $query->with('category')->orderBy('id', 'DESC')->paginate(config('constant.paginate.num_per_page'));

        if(count($data)){
            foreach($data as $row){
                $product_image = ProductImages::where('product_id', $row->id)->where('is_default','1')->first();
                $row->product_image = "";
                if($product_image){
                    $row->product_image = $product_image->image;
                }
            }
        }

        return $data;
    } catch (\Exception $e) {
        return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
    }
}


public static function sellersmyproduct($seller_id,$request)
{
  
     
     $userid = Auth::guard('seller')->user()?->id ?? null;
   
    try {
        $query = new Self;
       
        $query = $query->where('created_by',$seller_id); 
              if(isset($_GET['name']) && trim($_GET['name']) != '') {
    $query = $query->where(DB::raw('LOWER(name)'), 'like', '%' . strtolower(trim($_GET['name'])) . '%');
}
            if(isset($_GET['categories_id']) && $_GET['categories_id'] != ''){
            $query = $query->where('categories_id', $_GET['categories_id']);
        }
        if(isset($_GET['brand_id']) && $_GET['brand_id'] != ''){
            $query = $query->where('brand_id', $_GET['brand_id']);
        }
            if(isset($_GET['is_subscribe']) && $_GET['is_subscribe']!=''){
                $query = $query->where('is_subscribe',$_GET['is_subscribe']);
            }
            if(isset($_GET['status']) && $_GET['status']!=''){
                $query = $query->where('status',$_GET['status']);
            }
            
            if(isset($_GET['seller_id']) && $_GET['seller_id'] != ''){
            $query = $query->where('created_by', $_GET['seller_id']);
        }
        // Load related category data with the query
        $data = $query->with('category')->orderBy('id', 'DESC')->paginate(config('constant.paginate.num_per_page'));

        if(count($data)){
            foreach($data as $row){
                $product_image = ProductImages::where('product_id', $row->id)->orderBy('id', 'DESC')->first();
                $row->product_image = "";
                if($product_image){
                    $row->product_image = $product_image->image;
                }
            }
        }

        return $data;
    } catch (\Exception $e) {
        return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
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

     public static function updateColumn($id){
        try {
            $data = Product::where('id', $id)->first();

            // Assuming 'status' is an ENUM column with values '0' and '1'
            $newStatus = ($data->status == '1') ? '0' : '1';

            $data->update(['status' => $newStatus]);

            return ['status' => true, 'message' => __('lang.admin_data_change_msg')];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
        }
    }

     public static function updateFeaturedColumn($id){
        try {
            $data = Product::where('id', $id)->first();

            // Assuming 'is_featured' is an ENUM column with values '0' and '1'
            $newStatus = ($data->is_featured == '1') ? '0' : '1';

            $data->update(['is_featured' => $newStatus]);

            return ['status' => true, 'message' => __('lang.admin_data_change_msg')];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
        }
    }

      public static function updatebestsellerColumn($id){
        try {
            $data = Product::where('id', $id)->first();
            
          

            // Assuming 'is_featured' is an ENUM column with values '0' and '1'
            $newStatus = ($data->bestseller == '1') ? '0' : '1';


              
            $data->update(['bestseller' => $newStatus]);



            return ['status' => true, 'message' => __('lang.admin_data_change_msg')];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
        }
    }

 public static function sellersupdateColumn($id){
        try {
            $data = Product::where('id', $id)->first();

            // Assuming 'status' is an ENUM column with values '0' and '1'
            $newStatus = ($data->status == '1') ? '0' : '1';

            $data->update(['status' => $newStatus]);

            return ['status' => true, 'message' => __('lang.admin_data_change_msg')];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
        }
    }


 public static function sellerupdateFeaturedColumn($id){
        try {
            $data = Product::where('id', $id)->first();

            // Assuming 'is_featured' is an ENUM column with values '0' and '1'
            $newStatus = ($data->is_featured == '1') ? '0' : '1';

            $data->update(['is_featured' => $newStatus]);

            return ['status' => true, 'message' => __('lang.admin_data_change_msg')];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
        }
    }




public static function frontendgetLists($slug = null) 
{
    try {
        // Start building the query
        $query = Self::where('status', 1)
                     ->whereHas('category', function ($query) use ($slug) {
                         $query->where('slug', $slug);
                     });

        // Check for category filter
        if (!empty($_GET['categories_id'])) {
            $query = $query->where('categories_id', $_GET['categories_id']);
        }

        // Check for brand filter
        if (!empty($_GET['brand_id'])) {
            $query = $query->where('brand_id', $_GET['brand_id']);
        }

        // Check for price range filter
        if (isset($_GET['min-value']) && isset($_GET['max-value']) && 
            is_numeric($_GET['min-value']) && is_numeric($_GET['max-value'])) {
            
            $minValue = $_GET['min-value'];
            $maxValue = $_GET['max-value'];

            // Check the 'including_tax' setting
            if (setting('including_tax') == 0) {
                // Adjust price filter when including_tax is 0
                $query = $query->whereRaw('(price - discountamount + producttaxprice) BETWEEN ? AND ?', 
                                          [$minValue, $maxValue]);
            } else {
                // Regular price filter (just subtract discountamount)
                $query = $query->whereRaw('(price - discountamount) BETWEEN ? AND ?', 
                                          [$minValue, $maxValue]);
            }
        }

        // Sorting logic for dates and price (latest/oldest, low-high, high-low)
        if (!empty($_GET['sort'])) {
            if ($_GET['sort'] === 'latest') {
                $query = $query->orderBy('created_at', 'DESC');
            } elseif ($_GET['sort'] === 'oldest') {
                $query = $query->orderBy('created_at', 'ASC');
            } elseif ($_GET['sort'] === 'high-low') {
                // Sort by adjusted price from high to low
                if (setting('including_tax') == 0) {
                    $query = $query->orderByRaw('(price - discountamount + producttaxprice) DESC');
                } else {
                    $query = $query->orderByRaw('(price - discountamount) DESC');
                }
            } elseif ($_GET['sort'] === 'low-high') {
                // Sort by adjusted price from low to high
                if (setting('including_tax') == 0) {
                    $query = $query->orderByRaw('(price - discountamount + producttaxprice) ASC');
                } else {
                    $query = $query->orderByRaw('(price - discountamount) ASC');
                }
            }
        }

        // Eager load related models and apply pagination
        $data = $query->with(['category', 'productVariants', 'brand', 'reviews'])
                      ->paginate(config('constant.paginate.num_per_page'));

        // Add product image to each product row
        foreach ($data as $row) {
            $product_image = ProductImages::where('product_id', $row->id)
                                          ->where('is_default', '1')
                                          ->first();
            $row->product_image = $product_image ? $product_image->image : "";
        }

        return $data;
    } catch (\Exception $e) {
        return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
    }
}



public static function coustomproductlist($slug = null) 
{
    try {
        // Fetch visibilityid from Homepage model based on slug
        $visibility = Homepage::where('slug', $slug)->first();

        if (!$visibility) {
            return ['status' => false, 'message' => 'Invalid slug provided.'];
        }
        $visibilityid = $visibility->visibilitieid; // Assuming 'id' is the correct field

        

        $query = Self::where('status', 1)
                     ->where('visibilityid', $visibilityid); // Apply visibility filter

        // Check for category filter
        if (!empty($_GET['categories_id'])) {
            $query->where('categories_id', $_GET['categories_id']);
        }

           // Check for brand filter
        if (!empty($_GET['brand_id'])) {
            $query = $query->where('brand_id', $_GET['brand_id']);
        }

        // Check for price range filter
        if (isset($_GET['min-value']) && isset($_GET['max-value']) && 
            is_numeric($_GET['min-value']) && is_numeric($_GET['max-value'])) {
            
            $minValue = $_GET['min-value'];
            $maxValue = $_GET['max-value'];

            // Check the 'including_tax' setting
            if (setting('including_tax') == 0) {
                // Adjust price filter when including_tax is 0
                $query = $query->whereRaw('(price - discountamount + producttaxprice) BETWEEN ? AND ?', 
                                          [$minValue, $maxValue]);
            } else {
                // Regular price filter (just subtract discountamount)
                $query = $query->whereRaw('(price - discountamount) BETWEEN ? AND ?', 
                                          [$minValue, $maxValue]);
            }
        }

        // Sorting logic for dates and price (latest/oldest, low-high, high-low)
        if (!empty($_GET['sort'])) {
            if ($_GET['sort'] === 'latest') {
                $query = $query->orderBy('created_at', 'DESC');
            } elseif ($_GET['sort'] === 'oldest') {
                $query = $query->orderBy('created_at', 'ASC');
            } elseif ($_GET['sort'] === 'high-low') {
                // Sort by adjusted price from high to low
                if (setting('including_tax') == 0) {
                    $query = $query->orderByRaw('(price - discountamount + producttaxprice) DESC');
                } else {
                    $query = $query->orderByRaw('(price - discountamount) DESC');
                }
            } elseif ($_GET['sort'] === 'low-high') {
                // Sort by adjusted price from low to high
                if (setting('including_tax') == 0) {
                    $query = $query->orderByRaw('(price - discountamount + producttaxprice) ASC');
                } else {
                    $query = $query->orderByRaw('(price - discountamount) ASC');
                }
            }
        }

        // Eager load related models and apply pagination
        $data = $query->with(['category', 'productVariants', 'brand', 'reviews'])
                      ->paginate(config('constant.paginate.num_per_page'));

        // Add product image to each product row
        foreach ($data as $row) {
            $product_image = ProductImages::where('product_id', $row->id)
                                          ->where('is_default', '1')
                                          ->first();
            $row->product_image = $product_image ? $product_image->image : "";
        }

        return $data;
    } catch (\Exception $e) {
        return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
    }
}






public static function frontendgetListssubcategory($slug = null) 
{
    try {
          $query = Self::where('status', 1)
                     ->whereHas('subcategory', function ($query) use ($slug) {
                         $query->where('slug', $slug);
                     });

        // Check for category filter
         if (isset($_GET['subcategories_id']) && $_GET['subcategories_id'] != '') {
            $query = $query->where('subcategories_id', $_GET['subcategories_id']);
        }

        // Check for brand filter (allow multiple brands)
          // Check for brand filter
        if (!empty($_GET['brand_id'])) {
            $query = $query->where('brand_id', $_GET['brand_id']);
        }

          // Check for price range filter
        if (isset($_GET['min-value']) && isset($_GET['max-value']) && 
            is_numeric($_GET['min-value']) && is_numeric($_GET['max-value'])) {
            
            $minValue = $_GET['min-value'];
            $maxValue = $_GET['max-value'];

            // Check the 'including_tax' setting
            if (setting('including_tax') == 0) {
                // Adjust price filter when including_tax is 0
                $query = $query->whereRaw('(price - discountamount + producttaxprice) BETWEEN ? AND ?', 
                                          [$minValue, $maxValue]);
            } else {
                // Regular price filter (just subtract discountamount)
                $query = $query->whereRaw('(price - discountamount) BETWEEN ? AND ?', 
                                          [$minValue, $maxValue]);
            }
        }

        // Sorting logic for dates and price (latest/oldest, low-high, high-low)
        if (!empty($_GET['sort'])) {
            if ($_GET['sort'] === 'latest') {
                $query = $query->orderBy('created_at', 'DESC');
            } elseif ($_GET['sort'] === 'oldest') {
                $query = $query->orderBy('created_at', 'ASC');
            } elseif ($_GET['sort'] === 'high-low') {
                // Sort by adjusted price from high to low
                if (setting('including_tax') == 0) {
                    $query = $query->orderByRaw('(price - discountamount + producttaxprice) DESC');
                } else {
                    $query = $query->orderByRaw('(price - discountamount) DESC');
                }
            } elseif ($_GET['sort'] === 'low-high') {
                // Sort by adjusted price from low to high
                if (setting('including_tax') == 0) {
                    $query = $query->orderByRaw('(price - discountamount + producttaxprice) ASC');
                } else {
                    $query = $query->orderByRaw('(price - discountamount) ASC');
                }
            }
        }
        // Eager load related models and apply pagination
         $data = $query->with(['subcategory', 'productVariants', 'brand','reviews'])
                    ->paginate(config('constant.paginate.num_per_page'));

        // Add product image to each product row
        if (count($data)) {
            foreach ($data as $row) {
                // Fetch the latest product image
                $product_image = ProductImages::where('product_id', $row->id)
                                              ->where('is_default', '1')
                                              ->first();
                $row->product_image = $product_image ? $product_image->image : "";
            }
        }

        return $data;
    } catch (\Exception $e) {
        return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
    }
}




public static function frontendproductsearch($categoryId = null, $searchName = null) 
{
    try {
        $query = Self::where('status', 1);

         // Apply category filter if specified
        if ($categoryId) {
            $query = $query->where('categories_id', $categoryId);
        }

        // Apply search filter for name if specified
        if ($searchName && trim($searchName) !== '') {
            $query = $query->where(DB::raw('LOWER(name)'), 'like', '%' . strtolower(trim($searchName)) . '%');
        }

        // Check for brand filter (allow multiple brands)
        if (isset($_GET['brand_id']) && !empty($_GET['brand_id'])) {
            $brandIds = (array) $_GET['brand_id'];
            $query = $query->whereIn('brand_id', $brandIds);
        }

        // Check for price range filter
       if (isset($_GET['min-value']) && isset($_GET['max-value']) && 
            is_numeric($_GET['min-value']) && is_numeric($_GET['max-value'])) {
            $query = $query->whereRaw('CAST(price AS DECIMAL(10, 2)) BETWEEN ? AND ?', 
                                      [$_GET['min-value'], $_GET['max-value']]);
        }

        // Sorting logic for dates (latest/oldest)
        if (isset($_GET['sort']) && in_array($_GET['sort'], ['latest', 'oldest'])) {
            $dateSortOrder = $_GET['sort'] === 'latest' ? 'DESC' : 'ASC';
            $query = $query->orderBy('created_at', $dateSortOrder);
        }

        // Sorting logic for price (high-low, low-high)
        if (isset($_GET['sort']) && in_array($_GET['sort'], ['high-low', 'low-high'])) {
            $sortOrder = $_GET['sort'] === 'high-low' ? 'DESC' : 'ASC';
            
            // Ensure price is treated as numeric and ordered properly
            $query = $query->orderByRaw('CAST(price AS DECIMAL(10, 2)) ' . $sortOrder);
        }

        // Eager load related models and apply pagination
          $data = $query->with(['category', 'productVariants', 'brand','reviews'])
                     ->paginate(config('constant.paginate.num_per_page'));

        // Add product image to each product row
        if (count($data)) {
            foreach ($data as $row) {
                // Fetch the latest product image
                $product_image = ProductImages::where('product_id', $row->id)
                                              ->where('is_default', '1')
                                              ->first();
                $row->product_image = $product_image ? $product_image->image : "";
            }
        }

        return $data;
    } catch (\Exception $e) {
        return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
    }
}





public static function frontendGetProductDetails($slug,$currentLanguage)
{
    try {
        // Fetch the product by ID and load the related category and subcategory
        $product = (new self)->with(['category', 'subcategory','translations'])->where('slug', $slug)->first();

        // Check if the product exists
        if (!$product) {
            return null; // or handle it as you wish
        }


        // Get the product image
        $product_image = ProductImages::where('product_id', $product->id)
                                      ->orderBy('id', 'DESC')
                                      ->first();
        $product->product_image = $product_image ? $product_image->image : "";
        $product->name = $product->translations->where('language_code', $currentLanguage)->first()->name ?? $product->name;
        $product->short_description = $product->translations->where('language_code', $currentLanguage)->first()->short_description ?? $product->short_description;
        $product->description = $product->translations->where('language_code', $currentLanguage)->first()->description ?? $product->description;
        $product->brand_name = $product->brand->translations->where('language_code', $currentLanguage)->first()->name ?? $product->brand->name;

        // Get the user who created the product
        $user = User::find($product->created_by);
        $product->user_name = $user ? $user->name : null;
         $product->user_description = $user ? $user->description : null;
        return $product;
    } catch (\Exception $e) {
        return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
    }
}

public static function customproductsection()
{
    try {
        // Fetch all active banners with their associated tag_id
        $banners = Banner::where('status', 1)->where('type', 'product_tag')->get();

        
        // Initialize an array to store products for each tag (based on tag_id)
        $taggedProducts = [];

        // Loop through each banner to fetch products that match the banner's tag_id
        foreach ($banners as $banner) {
            // Fetch products that have the matching tag_id
            $products = self::where('tag_id', $banner->id)  // Match the products with the banner's tag_id
                ->with(['category', 'productVariants', 'brand', 'Banner','reviews'])  // Load related models
                ->take(5)  // Limit the results to 5 products
                ->get();  // Paginate the results

            // If products exist, process them
            if (count($products)) {
                // Loop through each product to load product images and assign the correct image
                foreach ($products as $product) {
                    $product_image = ProductImages::where('product_id', $product->id)
                                                  ->orderBy('id', 'DESC')
                                                  ->first();
                    $product->product_image = "";  // Default to an empty string if no image is found
                    if ($product_image) {
                        $product->product_image = $product_image->image;  // Assign product image if available
                    }
                }
            }

            // Store the products for each banner's tag_id (using the banner's name as the key)
            $taggedProducts[$banner->name] = $products;
        }

        // Return the products grouped by tag_id
        return $taggedProducts;

    } catch (\Exception $e) {
        return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
    }
}









}
