<?php
use App\Models\User;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Cuisine;
use App\Models\Item;
use App\Models\Order;
use App\Models\Deliveryman;
use App\Models\Restaurant;
use App\Models\Wallet;
use App\Models\Brand;
use App\Models\Review;
use GuzzleHttp\Client;
use App\Models\ProductImages;
use App\Models\Cms;
use App\Models\Currencies;

use App\Models\Homepage;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Language;

use Illuminate\Support\Facades\Session;

class Helpers {

    /*
     * function for check price response
     */
    public static function commonPriceFormate($price = null)
    {
        if ($price == '' || $price == null) {
            return '--';
        } else {
            return '$ ' .$price;
        }
    }


    /*
     * function for check price response
     */
    public static function commonCurrencyFormate()
    {
        return '$';
    }
    
    public static function getActiveCurrencySymbol()
    {
        $currency = Currencies::where('status', 1)->first();

        return $currency ? $currency->symbol : null; // Return null if no active currency found
    }
    
      public static function getAllLangList(){
        $list  = Language::where('status',1)->get();
        return $list;
    }

    public static function getAssignedPermissions()
    {
        return Session::get('permissions', []); // Return an empty array if 'permissions' is not set
    }
public static function sellergetAssignedPermissions()
    {
        return Session::get('sellerpermissions', []); // Return an empty array if 'permissions' is not set
    }

    public static function getPriceFormate($price = null)
    {
        if ($price == '' || $price == null) {
            return '$';
        } else {
            return '$';
        }
    }
    
   
    

    
    // public static function getProducts($visibilityId, $categoryId = null, $subcategoryId = null)
    // {
    //     // Start with products filtered by visibility
    //     $query = Product::query();

    //     // If visibility is provided, filter by visibility
    //     if ($visibilityId) {
    //         $query->where('visibilityid', $visibilityId);
    //     }

    //     // Apply category filter if provided
    //     if ($categoryId) {
    //         $query->where('categories_id', $categoryId);
    //     }

    //     // Apply subcategory filter if provided
    //     if ($subcategoryId) {
    //         $query->where('subcategories_id', $subcategoryId);
    //     }

    //     return $query->get();
    // }
    
    
// public static function getProducts($visibilityId, $categoryId = null, $subcategoryId = null)
// {
//     try {
//         // Start with the base query for products filtered by visibility
//         $query = Product::where('status', 1); // Make sure only active products are considered

//         // If visibility is provided, filter by visibility
//         if ($visibilityId) {
//             $query->where('visibilityid', $visibilityId);
//         }

//         // Apply category filter if provided
//         if ($categoryId) {
//             $query->where('categories_id', $categoryId);
//         }

//         // Apply subcategory filter if provided
//         if ($subcategoryId) {
//             $query->where('subcategories_id', $subcategoryId);
//         }

//         // Eager load related models
//         $data = $query->with(['category', 'productVariants', 'brand', 'reviews'])
//                       ->limit(5)
//                       ->get();

//         // Add product image and rating information to each product
//         $data->each(function ($product) {
//             // Fetch the latest product image
//             $product_image = ProductImages::where('product_id', $product->id)
//                                           ->orderBy('id', 'DESC')
//                                           ->first();
//             $product->product_image = $product_image ? $product_image->image : "";

//             // Get the average rating for the product from the Review model (1 to 5)
//             $product->averageRating = Review::where('product_id', $product->id)->avg('rating');
//             $product->reviewCount = Review::where('product_id', $product->id)->count();

//             // If there's no rating, set it to a default (for example, 0)
//             if (is_null($product->averageRating)) {
//                 $product->averageRating = 0; // Default rating if no rating exists
//             }
//         });

//         // Return the data with additional attributes
//         return $data;
//     } catch (\Exception $e) {
//         // Return error if exception occurs
//         return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
//     }
// }

  public static function getProducts($visibilityId, $categoryId = null, $subcategoryId = null)
{
    try {
        // Get the current language code
        $languageCode = Session::get('website_locale', App::getLocale());

        // Start with the base query for products filtered by visibility
        $query = Product::where('status', 1); // Make sure only active products are considered

        // If visibility is provided, filter by visibility
        if ($visibilityId) {
            $query->where('visibilityid', $visibilityId);
        }

        // Apply category filter if provided
        if ($categoryId) {
            $query->where('categories_id', $categoryId);
        }

        // Apply subcategory filter if provided
        if ($subcategoryId) {
            $query->where('subcategories_id', $subcategoryId);
        }

        // Eager load related models, including translations
        $data = $query->with([
            'category',
            'productVariants',
            'brand.translations' => function ($query) use ($languageCode) {
                $query->where('language_code', $languageCode);
            },
            'translations' => function ($query) use ($languageCode) {
                $query->where('language_code', $languageCode);
            },
            'reviews',
        ])->limit(5)->get();

        // Add product image and rating information to each product
        $data->each(function ($product) {
            // Fetch the latest product image
            $product_image = ProductImages::where('product_id', $product->id)
                                          ->where('is_default', '1')
                                          ->first();
            $product->product_image = $product_image ? $product_image->image : "";

            // Get the average rating for the product from the Review model (1 to 5)
            $product->averageRating = Review::where('product_id', $product->id)->avg('rating');
            $product->reviewCount = Review::where('product_id', $product->id)->count();

            // If there's no rating, set it to a default (for example, 0)
            if (is_null($product->averageRating)) {
                $product->averageRating = 0; // Default rating if no rating exists
            }
        });

        // Return the data with additional attributes
        return $data;
    } catch (\Exception $e) {
        // Return error if exception occurs
        return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
    }
}
  
    

    /*
     * function for check price response
     */
    public static function commonItemTypeFormate($type = null)
    {
        if ($type == 'veg') {
            return 'Veg';
        } else {
            return 'Non Veg';
        }
    }

    
    /*
     * function for check null response
     */
    public static function checkNull($val = null)
    {
        if ($val == '' || $val == null) {
            return '--';
        } else {
            return $val;
        }
    }

    /*
     * function for common date format with time
     */
    public static function commonDateFormateWithTime($value = null)
    {
        if (isset($value) && !empty($value) && ($value != '0000-00-00' && $value != '0000-00-00 00:00:00' && $value != '1970-01-01')) {
            $value = trim($value);
            return date('d-m-Y h:i A', strtotime($value));
        } else {
            return 'NA';
        }
    }


    /*
     * function for common date format
     */
    public static function commonDateFormate($value = null)
    {
        if (isset($value) && !empty($value) && ($value != '0000-00-00' && $value != '0000-00-00 00:00:00' && $value != '1970-01-01')) {
            $value = trim($value);
            return date('d-m-Y', strtotime($value));
        } else {
            return 'NA';
        }
    }

    /*
     * function for common time format
     */
        public static function commonTimeFormate($value = null)
    {
        if (isset($value) && !empty($value) && ($value != '0000-00-00' && $value != '0000-00-00 00:00:00' && $value != '1970-01-01')) {
            $value = trim($value);
            return date('g:i A', strtotime($value));
        } else {
            return 'NA';
        }
    }



    /**
     * Create slug 
    **/

    public static function createSlug($title,$in='category',$whr=0,$alphaNum = false){
        if($alphaNum){
            $slug = Str::slug($title, '-');
        }else{
            $slug = Str::slug($title, '-');
        }
        if($in == 'subcategory'){           
            $slugExist = Subcategory::where(DB::raw('LOWER(slug)'),strtolower($slug))->where('id','!=',$whr)->get();
        }else if($in == 'category'){
            $slugExist = Category::where(DB::raw('LOWER(slug)'),strtolower($slug))->where('id','!=',$whr)->get();
        }else if($in == 'cuisine'){
            $slugExist = Cuisine::where(DB::raw('LOWER(slug)'),strtolower($slug))->where('id','!=',$whr)->get();
        }
        else if($in == 'brand'){
            $slugExist = Brand::where(DB::raw('LOWER(slug)'),strtolower($slug))->where('id','!=',$whr)->get();
        }
        
         else if($in == 'coustomproduct'){
            $slugExist = Homepage::where(DB::raw('LOWER(slug)'),strtolower($slug))->where('id','!=',$whr)->get();
        }
         else if($in == 'cms'){
            $slugExist = Cms::where(DB::raw('LOWER(slug)'),strtolower($slug))->where('id','!=',$whr)->get();
        }
        
        else if($in == 'blog'){
       $slugExist = Blog::where(DB::raw('LOWER(slug)'),strtolower($slug))->where('id','!=',$whr)->get();
        }
        if(count($slugExist)){
            $slug = Str::slug($title.'-'.Str::random(5).'-'.Str::random(5), '-');
            return $slug;
        }else{
            return $slug;
        }
    }


    /**
     * Upload file
    **/
    public static function uploadFiles($file, $folderName)
    {
        try {
            // Get the uploaded file
            $image = $file;

            // Generate a unique name for the file
            $rand=rand('9999','1000');
            $imageName = $rand.time().'.'.$image->extension();
            
            // Move the file to the public folder
            $image->move(public_path('uploads/'.$folderName), $imageName);

            // Return the path to the uploaded image
            $imagePath = 'uploads/'.$folderName.'/'.$imageName;

            return [
                'status' => true,
                'message' => config('constant.common.messages.success_image'),
                'file_name' => $imageName, // Fix this line
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile(),
            ];
        }
    }

    // this is for get food type
    public static function getFoodType()
    {
        return [
            'veg' => __('lang.admin_veg_label'),
            'nonveg' => __('lang.admin_nonveg_label'),
        ];
    }

    // this is for get discount type
    public static function getDiscountType()
    {
        return [
            'amount' => __('lang.admin_amount_label'),
            'percent' => __('lang.admin_percent_label'),
        ];
    }

    // this is for get status type
    public static function getStatusType()
    {
        return [
            '1' => __('lang.admin_active_label'),
            '0' => __('lang.admin_deactive_label'),
        ];
    }

     public static function getpaymentstatusType()
    {
        return [
            'pending' => 'pending',
            'confirmed' => 'confirmed',
            'Picked-up' => 'Picked-up',
            'On-the-way' => 'On-the-way',
             'delivered' => 'delivered',
         
        ];
    }


    // this is for get order status type
    public static function getOrderStatusType()
    {
        return [
            'pending' => 'Pending',
            'accepted' => 'Accepted',
            'confirmed' => 'Confirmed',
            'processing' => 'Processing',
            'out_for_delivery' => 'Out For Delivery',
            'delivered' => 'Delivered',
            'failed' => 'Failed',
            'cancelled' => 'Cancelled',
            'handover' => 'Handover',
            'refund_request' => 'Refund Request',
            'refunded' => 'Refunded',
            'refund_request_canceled' => 'Refund request canceled',
            'payment_failed' => 'Payment failed',
        ];
    }


    // this is for get live order status type
    public static function getLiveOrderStatusType()
    {
        return [
            'accepted' => 'Accepted',
            'confirmed' => 'Confirmed',
            'processing' => 'Processing',
            'out_for_delivery' => 'Out For Delivery',
            'handover' => 'Handover',
        ];
    }



    // this is for get export type
    public static function getExportType()
    {
        return [
            'all_data' => __('lang.admin_all_data_label'),
            'date_wise' => __('lang.admin_date_wise_label'),
            'id_wise' => __('lang.admin_id_wise_label'),
        ];
    }

    // this is for get time type
    public static function getTimeType()
    {
        return [
            'minutes' => __('lang.admin_minutes_label'),
            'hours' => __('lang.admin_hour_label'),
        ];
    }


    // this is for get radius type
    public static function getRadiusTypes()
    {
        return [
            '1' => 1,
            '2' => 2,
            '3' => 3,
            '4' => 4,
            '5' => 5,
        ];
    }

    // this is for get coupon type
    public static function getCouponTypes()
    {
        return [
            'default' => 'Default'
        ];
    }

    // this is for get wallet type
    public static function getWalletTypes()
    {
        return [
            'credit' => 'Credit',
            'debit' => 'Debit'
        ];
    }

    // get customer wallet
    public static function getCustomerWallet($customer_id){
        $walletAmount = Wallet::select(
                DB::raw('SUM(CASE WHEN type = "credit" THEN amount ELSE 0 END) AS total_credit'),
                DB::raw('SUM(CASE WHEN type = "debit" THEN amount ELSE 0 END) AS total_debit')
                )
                ->where('customer_id', $customer_id)
                ->groupBy('customer_id')
                ->first();
        return $walletAmount;
    }
    
    
    // this is for get identity type
    public static function getIdentityType()
    {
        return [
            'Passport' => 'Passport',
            'aadhar_card' => 'Aadhar Card',
            'driving_licence' => 'Driving Licence',
            'voter_id_card' => 'Voter ID Card'
        ];
    }


    // this is for get vehicle type
    public static function getVehicleType()
    {
        return [
            'car' => 'Car',
            'bike' => 'Bike',
        ];
    }


    // this is for get duration type
    public static function getDurationTypes()
    {
        return [
            'all_time' => 'All Time',
            'this_year' => 'This Year',
            'previous_year' => 'Previous Year',
            'this_month' => 'This Month',
            'this_week' => 'This Week',
            'custom' => 'Custom',
        ];
    }


    // this is for get items count
    public static function getResturantTotalItemCount($restaurant_id){
        $count  = Item::where('restaurant_id',$restaurant_id)->count();
        return $count;
    }

    // this is for get order count
    public static function getResturantTotalOrderCount($restaurant_id){
        $count  = Order::where('restaurant_id',$restaurant_id)->count();
        return $count;
    }


    // this is for get order amount
    public static function getResturantTotalOrderAmount($restaurant_id){
        $final_amount  = Order::where('restaurant_id',$restaurant_id)->sum('final_amount');
        return $final_amount;
    }


    // this is for total admin commission
    public static function getAdminCommissionAmount($restaurant_id, $default_commission)
    {
        // Get the total final amount of all orders for the restaurant
        $final_amount = Order::where('restaurant_id', $restaurant_id)->sum('final_amount');

        // Ensure both final_amount and default_commission are numeric
        $final_amount = floatval($final_amount);
        $default_commission = floatval($default_commission);

        // Calculate the commission amount
        $commission_amount = ($final_amount * $default_commission) / 100;

        // Return the calculated commission amount
        return $commission_amount;
    }



    // this is for generate api token
    public static function generateApiToken(){
        mt_srand((double)microtime()*10000);
        $uuid = rand(1,99999).time();
        $salt = substr(sha1(uniqid(mt_rand(), true)), 0, 40);
        return substr(sha1($salt) . $salt,1,85).$uuid;
    }

    // this is for validate api token
    public static function validateAuthToken($token){
        $tokenExist  = User::where('api_token',$token)->first();
        if($tokenExist){
            return $tokenExist;
        }
        return false;
    }

    // this is for get item data
    public static function getItemDataPrice($item_id){
        $itemExist = Item::where('id', $item_id)->first();
        if($itemExist){
            return $itemExist;
        }
        return null;
    }

     // this is for get item discount price
    public static function calculateItemPrice($price, $discountType, $discountValue){
        if ($discountType == 'amount') {
            // If discount type is 'amount', subtract discount value from the price
            return $price - $discountValue;
        } elseif ($discountType == 'percent') {
            // If discount type is 'percent', calculate the discounted price
            return $price - ($price * ($discountValue / 100));
        } else {
            // Default to original price if discount type is not recognized
            return $price;
        }
    }


    // this is for get item discount price
    public static function getTotalPrice($perItemAmount, $quantity)
    {
        // Calculate the total price
        $totalPrice = $perItemAmount * $quantity;

        return $totalPrice;
    }


    /**
     * Check Role has selected that permission
    **/
    public static function checkRoleHasPermission($role_id,$permission_id) {
        // $language = setting('preferred_site_language');
        $permission = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role_id)
            ->where("role_has_permissions.permission_id",$permission_id)->count();
        if ($permission>0) {
           return 1;
        }else{
            return 0;
        }        
    }

    // check assign delivery man
    public static function checkAssignDeliveryMan($deliveryman_id)
    {
        $name = Deliveryman::where('id', $deliveryman_id)->value('name');

        return $name ? $name : '--';
    }


    // for convert key
    public static function maskApiKey($key) {
        if($key && strlen($key) >= 5){
            return str_repeat('*', strlen($key) - 5) . substr($key, -5);
        }else{
            return '';
        }
    }
    
    // for get version
     public static function getVersion($filePath)
    {
        return json_decode(file_get_contents($filePath), true)['version'];
    }
    
    // for get language direction
     public static function getLanguageDirection($langCode)
    {
         $lang = Language::where('code',$langCode)->first();
        if($lang){
         $direction = $lang->position;
        }else{
         $direction = 'ltr';
        }
        return $direction;
    }

    // for reviews limit
    public static function getReviewLimit($review)
    {
        if($review){
           $review = substr($review,0,100);
        }

        return $review;
    }

    // this is for get banner type
    public static function getBannerType()
    {
        return [
            'restaurant_wise' => __('lang.admin_restaurant_wise'),
            'item_wise' => __('lang.admin_item_wise'),
        ];
    }

    // return banner type
    public static function checkBannerType($banner_type)
    {
        if ($banner_type == 'item_wise') {
            return __('lang.admin_item_wise');
        }else if($banner_type == 'restaurant_wise') {
           return __('lang.admin_restaurant_wise');
        }else{
            return '--';
        }
    }


    // return banner type
    public static function checkSendTo($send_to)
    {
        if ($send_to == 'deliveryman') {
            return 'Deliveryman';
        }else if($send_to == 'restaurant') {
           return 'Restaurant';
        }else if($send_to == 'customer'){
            return 'Customer';
        }
    }

   // for send to
    public static function getSendTo()
    {
        return [
            'restaurant' => __('lang.admin_restaurant'),
            'deliveryman' => __('lang.admin_deliveryman'),
            'customer' => __('lang.admin_customer'),
        ];
    }



}

?>