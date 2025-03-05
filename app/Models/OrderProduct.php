<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
class OrderProduct extends Model
{
    use HasFactory;


    protected $guarded = ['id'];
    protected $table = "order_products";


   
 public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
   
public function taxrates()
{
    return $this->hasMany(Taxrate::class, 'product_id', 'product_id');
}
     public function productVariantValue()
    {
        return $this->belongsTo(Product_variants_values::class, 'variantsid');
    }
  
  public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

        public function seller()
{
    return $this->belongsTo(User::class, 'seller_id')->where('type', 'seller');
}


   public static function getLists($search) {
    try {
        $obj = new self;

        $pagination = isset($search['perpage']) ? $search['perpage'] : config('constant.pagination');

        // Eager load both user and seller relationships
        $obj = $obj->with(['user', 'seller']); 

        if (isset($search['order_key']) && !empty($search['order_key'])) {
            $obj = $obj->where('order_key', 'like', '%' . trim($search['order_key']) . '%');
            $cat = OrderProduct::where('order_key', 'like', '%' . trim($search['order_key']) . '%')->get();
        }

         if(isset($search['status']) && $search['status']!=''){
                $obj = $obj->where('status',$search['status']);
            } 

            if(isset($search['paymentmethod']) && $search['paymentmethod']!=''){
                $obj = $obj->where('payment_method',$search['paymentmethod']);
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
         $obj = $obj->with(['user', 'seller']); 

         if (isset($search['order_key']) && !empty($search['order_key'])) {
            $obj = $obj->where('order_key', 'like', '%' . trim($search['order_key']) . '%');
            $cat = OrderProduct::where('order_key', 'like', '%' . trim($search['order_key']) . '%')->get();
        }

         if(isset($search['status']) && $search['status']!=''){
                $obj = $obj->where('status',$search['status']);
            } 

            if(isset($search['paymentmethod']) && $search['paymentmethod']!=''){
                $obj = $obj->where('payment_method',$search['paymentmethod']);
            } 

              if(isset($search['seller_id']) && $search['seller_id']!=''){
                $obj = $obj->where('seller_id',$search['seller_id']);
            } 

        // Add condition for status = 1
        $obj = $obj->where('seller_id', '!=', 1);

       

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

          
public static function orderDetailsGetList($orderId)
{
    // Fetch the order along with related models
    $order = self::with([
        'product',
        'productVariantValue',
        'user',
        'taxrates' => function ($query) {
            $query->with([
                'tax' => function ($taxQuery) {
                    $taxQuery->select('id', 'name'); // Fetch only tax name and ID
                }
            ])->select('product_id', 'tax_id', 'rate', 'ratetype'); // Fetch necessary columns
        }
    ])->where('id', $orderId)->first(); // Retrieve the order record

    if ($order && $order->taxrates) {
        $taxDetails = [];
        $basePrice = $order->product_price; // Base price for tax calculations
        
        

        foreach ($order->taxrates as $taxrate) {
            $taxAmount = 0;

            // Calculate tax based on its rate type
            if ($taxrate->ratetype === 'percentage') {
                $taxAmount = ($basePrice * $taxrate->rate) / 100; // Percentage calculation
            } elseif ($taxrate->ratetype === 'flat') {
                $taxAmount = $taxrate->rate; // Flat tax value
            }
            
             
            $taxDetails[] = [
                'tax_name' => $taxrate->tax->name ?? 'No Tax',
                'tax_value' => round($taxAmount, 2), // Round tax amount to 2 decimal places
                'ratetype' => $taxrate->ratetype,
            ];
        }

        // Attach the calculated tax details to the order object
        $order->tax_details = $taxDetails;
    }

    return $order;
}



public static function userOrdersdetailsGetLists($orderId)
{
    $currentLanguage = Session::get('website_locale', App::getLocale());
    $user_id = Auth::guard('customer')->user()?->id ?? null;

    $order = self::with([
        'product' => function ($query) use ($currentLanguage) {
            $query->with(['translations' => function ($translationQuery) use ($currentLanguage) {
                $translationQuery->where('language_code', $currentLanguage);
            }]);
        },
        'productVariantValue',
        'user',
        // Include Taxrate relationship
        'taxrates' => function ($query) {
            $query->with(['tax' => function ($taxQuery) {
                $taxQuery->select('id', 'name'); // Fetch tax name
            }])->select('product_id', 'tax_id', 'rate', 'ratetype'); // Fetch rate and ratetype
        }
    ])
    ->where('id', $orderId)
    ->where('userid', $user_id)
    ->first();

    // Check if the order exists and set the translated product name
    if ($order && $order->product) {
        $translatedName = $order->product->translations->first()?->name;
        $order->product->name = $translatedName ?? $order->product->name;
    }

    // Include tax details if available
    if ($order && $order->taxrates) {
        $taxDetails = [];

        // Subtract producttax from product_price before calculating taxes
        
       
     
            
          $basePrice = $order->product_price;
        


        foreach ($order->taxrates as $taxrate) {
            $taxAmount = 0;

            if ($taxrate->ratetype === 'percentage') {
                // Calculate tax as percentage of the base price
                $taxAmount = ($basePrice * $taxrate->rate) / 100;
            } elseif ($taxrate->ratetype === 'flat') {
                // Fixed tax amount
                $taxAmount = $taxrate->rate;
            }

            $taxDetails[] = [
                'tax_name' => $taxrate->tax->name ?? 'No Tax',
                'tax_value' => $taxAmount,
                'ratetype' => $taxrate->ratetype,
            ];
        }

        // Attach tax details to the order object
        $order->tax_details = $taxDetails;
    }

    return $order;
}






  public static function sellerordergetLists($search) {
    try {
        
          $sellersid = Auth::guard('seller')->user()?->id ?? null;
         
        $obj = new self;


        $pagination = (isset($search['perpage'])) ? $search['perpage'] : config('constant.pagination');

        // Eager load the user relationship
         $obj = $obj->with(['user', 'seller']);

         if (isset($search['order_key']) && !empty($search['order_key'])) {
            $obj = $obj->where('order_key', 'like', '%' . trim($search['order_key']) . '%');
            $cat = OrderProduct::where('order_key', 'like', '%' . trim($search['order_key']) . '%')->get();
        }

         if(isset($search['status']) && $search['status']!=''){
                $obj = $obj->where('status',$search['status']);
            } 

            if(isset($search['paymentmethod']) && $search['paymentmethod']!=''){
                $obj = $obj->where('payment_method',$search['paymentmethod']);
            } 

          $obj = $obj->where('seller_id', $sellersid);
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


 public static function admindeliveredordergetLists($search) {
    try {
     
        $obj = new self;

        $pagination = (isset($search['perpage'])) ? $search['perpage'] : config('constant.pagination');

        // Eager load the user relationship
         $obj = $obj->with(['user', 'seller']);

        if (isset($search['name']) && !empty($search['name'])) {
            $obj = $obj->where('name', 'like', '%' . trim($search['name']) . '%');
            $cat = OrderProduct::where('name', 'like', '%' . trim($search['name']) . '%')->get();
        }

        // Add condition for status = 1
        $obj = $obj->where('status', 'delivered');
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
 public static function deliveredordergetLists($search) {
    try {
         $userid = Auth::guard('seller')->user()?->id ?? null;
        $obj = new self;

        $pagination = (isset($search['perpage'])) ? $search['perpage'] : config('constant.pagination');

        // Eager load the user relationship
         $obj = $obj->with(['user', 'seller']);

        if (isset($search['name']) && !empty($search['name'])) {
            $obj = $obj->where('name', 'like', '%' . trim($search['name']) . '%');
            $cat = OrderProduct::where('name', 'like', '%' . trim($search['name']) . '%')->get();
        }

        // Add condition for status = 1
        $obj = $obj->where('status', 'delivered')->where('seller_id', $userid );

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


public static function userOrdersGetLists()
{
    $currentLanguage = Session::get('website_locale', App::getLocale());
    $user_id = Auth::guard('customer')->user()?->id ?? null;

   return self::where('userid', $user_id)
        ->where(function ($query) {
            $query->where('payment_method', 'cash')
                  ->orWhere(function ($query) {
                      $query->where('payment_method', '!=', 'cash')
                            ->where('payment_status', 'paid');
                  });
        })
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
        ->orderBy('created_at', 'desc')
        ->get()
        ->each(function ($order) use ($currentLanguage) {
            // Set translated product name
            if ($order->product && $order->product->translations) {
                $translatedName = $order->product->translations->first()?->name;
                $order->product->name = $translatedName ?? $order->product->name;
            }
        });
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


public static function inhouseordergetLists($search) {
    try {
        
        $obj = new self;


        $pagination = (isset($search['perpage'])) ? $search['perpage'] : config('constant.pagination');

        // Eager load the user relationship
         $obj = $obj->with(['user', 'seller']);

         if (isset($search['order_key']) && !empty($search['order_key'])) {
            $obj = $obj->where('order_key', 'like', '%' . trim($search['order_key']) . '%');
            $cat = OrderProduct::where('order_key', 'like', '%' . trim($search['order_key']) . '%')->get();
        }

         if(isset($search['status']) && $search['status']!=''){
                $obj = $obj->where('status',$search['status']);
            } 

            if(isset($search['paymentmethod']) && $search['paymentmethod']!=''){
                $obj = $obj->where('payment_method',$search['paymentmethod']);
            } 

          $obj = $obj->where('seller_id', '1');
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
  


}
