<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;


class Orders extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $table = "orders";



    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
   
  public static function getLists($search) {
    try {
        $obj = new self;

        $pagination = (isset($search['perpage'])) ? $search['perpage'] : config('constant.pagination');

        // Eager load the user relationship
        $obj = $obj->with('user'); 

        if (isset($search['name']) && !empty($search['name'])) {
            $obj = $obj->where('name', 'like', '%' . trim($search['name']) . '%');
            $cat = Orders::where('name', 'like', '%' . trim($search['name']) . '%')->get();
        }

        if (isset($search['status']) && $search['status'] != '') {
            $obj = $obj->where('status', $search['status']);
        }

        // Paginate the results
        $data = $obj->orderBy('id', 'DESC')->paginate($pagination)->appends('perpage', $pagination);

        return $data;
    } catch (\Exception $e) {
        return [
            'status' => false,
            'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()
        ];
    }
}


  public static function inhouseordergetLists($search) {
    try {
        $obj = new self;

        $pagination = (isset($search['perpage'])) ? $search['perpage'] : config('constant.pagination');

        // Eager load the user relationship
        $obj = $obj->with('user'); 

        if (isset($search['name']) && !empty($search['name'])) {
            $obj = $obj->where('name', 'like', '%' . trim($search['name']) . '%');
            $cat = Orders::where('name', 'like', '%' . trim($search['name']) . '%')->get();
        }

        // Add condition for status = 1
        $obj = $obj->where('seller_id', 1);

        // If a specific status is provided in the search, overwrite the status = 1 condition
        if (isset($search['status']) && $search['status'] != '') {
            $obj = $obj->where('status', $search['status']);
        }

        // Paginate the results
        $data = $obj->orderBy('id', 'DESC')->paginate($pagination)->appends('perpage', $pagination);

        return $data;
    } catch (\Exception $e) {
        return [
            'status' => false,
            'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()
        ];
    }
}

public static function sellersordergetLists($search) {
    try {
        $obj = new self;

        $pagination = (isset($search['perpage'])) ? $search['perpage'] : config('constant.pagination');

        // Eager load the user relationship
        $obj = $obj->with('user'); 

        if (isset($search['name']) && !empty($search['name'])) {
            $obj = $obj->where('name', 'like', '%' . trim($search['name']) . '%');
            $cat = Orders::where('name', 'like', '%' . trim($search['name']) . '%')->get();
        }

        // Add condition for status = 1
        $obj = $obj->where('seller_id', '!=', 1);

        // If a specific status is provided in the search, overwrite the status = 1 condition
        if (isset($search['status']) && $search['status'] != '') {
            $obj = $obj->where('status', $search['status']);
        }

        // Paginate the results
        $data = $obj->orderBy('id', 'DESC')->paginate($pagination)->appends('perpage', $pagination);

        return $data;
    } catch (\Exception $e) {
        return [
            'status' => false,
            'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()
        ];
    }
}



          
   public static function orderdetailsgetLists($orderId)
{
    return self::with([
            'orderProducts.product', // Fetch multiple products for an order
            'orderProducts.productVariantValue', // Fetch multiple product variant values
            'user' // Fetch a single user
        ])
        ->where('id', $orderId)
        ->first(); // Use first() to get a single order record with its relationships
}


 // this is for user orders 

public static function userOrdersGetLists()
{   
    // Get the user_id if the user is authenticated and is of type 'customer'
    $user_id = Auth::check() && Auth::user()->type == 'customer' ? Auth::user()->id : null;

    // Return the orders with the specified user_id and related data
    return self::where('user_id', $user_id)
        ->whereHas('orderProducts', function($query) use ($user_id) {
            $query->where('userid', $user_id);
        })
        ->with([
            'orderProducts.product', // Fetch associated products for the order
            'orderProducts.productVariantValue', // Fetch associated product variant values
            'orderProducts.product.product_images' => function ($query) {
                $query->where('is_default', 1); // Fetch only images with status = 1
            },
            'user' // Fetch associated user
        ])
        ->get(); // Use get() to fetch multiple records
}




public static function userOrdersdetailsGetLists($orderProductId)
{
    return self::whereHas('orderProducts', function($query) use ($orderProductId) {
            $query->where('id', $orderProductId); // Filter directly by orderProduct's primary key
        })
        ->with([
            'orderProducts' => function ($query) use ($orderProductId) {
                $query->where('id', $orderProductId); // Fetch only the specific orderProduct
            },
            'orderProducts.product', // Fetch associated products for the order
            'orderProducts.productVariantValue', // Fetch associated product variant values
            'orderProducts.product.product_images' => function ($query) {
                $query->where('is_default', 1); // Fetch only default images
            },
            'user' // Fetch associated user
        ])
        ->first(); // Use first() to fetch a single order record
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


}
