<?php








namespace App\Http\Controllers\Website;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Banner;
use App\Models\ProductImages;
use App\Models\Product;
use App\Models\Productattribute;
use App\Models\Product_variants;
use App\Models\Product_variants_values;
use App\Models\Cart;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Shipping;
use App\Models\ShippingRate;
use App\Models\Brand;
use App\Models\Setting;
use App\Models\Taxrate;
use App\Models\Delivery_address;
use App\Models\Orders;
use App\Models\OrderProduct;
use App\Models\Homepage;
use App\Models\Cms;
use App\Models\Wishlist;
use App\Models\SellerIncome;
use App\Models\Review;
use App\Models\Coupon;
use App\Models\CmsTranslation;
use Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Illuminate\Support\Facades\Session;
use App\Mail\OrderPlacedMail;
use Illuminate\Support\Facades\Mail;



class HomeController extends Controller
{

public function index(Request $request)
{
    
   
   
   
try {
// Fetch all categories and subcategories (merged together)

$categories = Category::frontendgetLists(); // This will include both categories and subcategories
$languageCode = Session::get('website_locale', App::getLocale());
// Fetch banners for the view
$homepagebanners = Banner::where('status', 1)->where('type', 'mainbanner')->get();
$iconsdata = Banner::where('status', 1)->where('type', 'icon')->get();

$Homepagedata = Homepage::with([
    'translations' => function ($query) use ($languageCode) {
        $query->where('language_code', $languageCode);
    }
])->where('status', 1)
->orderBy('order', 'asc')->get();

$cartdata = Cart::cartgetlist($request);
$mywishlistproduct = Wishlist::userwishlistproduct();

// Return the view with necessary data
return view('website.index', compact('categories', 'homepagebanners', 'Homepagedata','mywishlistproduct','cartdata','iconsdata'));
} catch (\Exception $e) {
// Handle any errors (Optional: display an error message in your view)
return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
}
}











public function userregister(Request $request)
{

return view('website.register');
}




public function userlogin(Request $request)
{


return view('website.userlogin');
}

public function userlogout(Request $request)
{
Auth::logout();
$request->session()->invalidate();
$request->session()->regenerateToken();

return redirect('user-login')->with('status', 'Successfully logged out!');
}

public function userstore(Request $request)
{
    // Validate the incoming request
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'phone' => 'required',
        'password' => 'required|string|min:8|confirmed',
        'password_confirmation' => 'required|string|min:8',
        'terms_and_policy' => 'required',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Create a new user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'type' => 'customer',
        'password' => Hash::make($request->password),
    ]);

    // Log in the user after registration
    Auth::guard('customer')->login($user);

    // Associate session cart items with the logged-in user
    $session_id = $request->ip();
    $cartProductIds = Cart::where('session_id', $session_id)
        ->whereNull('user_id')
        ->pluck('product_id');

    // Remove duplicate cart items for the user
    Cart::whereIn('product_id', $cartProductIds)
        ->where('user_id', $user->id)
        ->delete();

    // Update cart items with the logged-in user ID
    $cartIds = Cart::where('session_id', $session_id)
        ->whereNull('user_id')
        ->pluck('id');

    Cart::whereIn('id', $cartIds)->update(['user_id' => $user->id]);

    return redirect()->to('/index')->with('success', 'User registered and logged in successfully.');
}


public function userupdate(Request $request) 
{
  
    $user_id = Auth::guard('customer')->user()?->id ?? null;


    // Find the user by ID
    $user = User::findOrFail($user_id);

    // Update the user data
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        // Only update the password if a new one is provided
        'password' => $request->password ? Hash::make($request->password) : $user->password,
    ]);

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Profile updated successfully.');
}





public function userauthenticate(Request $request)
{
    $session_id = $request->ip();
    $credentials = $request->only('email', 'password');

    if (Auth::guard('customer')->attempt($credentials)) {
        $user = Auth::guard('customer')->user();

        // Check if the logged-in user is a customer
        if ($user->type == 'customer') {
            // Get cart product IDs associated with the current session
            $cartProductIds = Cart::where('session_id', $session_id)
                ->whereNull('user_id')
                ->pluck('product_id');

            // Delete cart entries with the same user ID and product ID
            Cart::whereIn('product_id', $cartProductIds)
                ->where('user_id', $user->id)
                ->delete();

            // Update the session's cart items to associate with the logged-in user
            $cartIds = Cart::where('session_id', $session_id)
                ->whereNull('user_id')
                ->pluck('id');
            
            Cart::whereIn('id', $cartIds)->update(['user_id' => $user->id]);

            return redirect('index')->with('success', 'Login Successful.');
        } else {
            // If the user is not a customer, log them out and return an error
            Auth::guard('customer')->logout();
            return redirect()->back()->with('error', 'Invalid credentials.');
        }
    }

    return redirect()->back()->with('error', 'Invalid credentials');
}





public function productlist($slug,Request $request)
{



$currentLanguage = Session::get('website_locale', App::getLocale());
$cartdata = Cart::cartgetlist($request);
 $mywishlistproduct = Wishlist::userwishlistproduct();
 

$taxdata = Setting:: where('key', 'excluding_tax')->first();
$productlist = Product::frontendgetLists($slug);


 $categoryId = Category::where('slug', $slug)->value('id');



$maxPrice = Product::where('categories_id', $categoryId)->max('price');


$particualrbrandid = Product::where('categories_id', $categoryId)->pluck('brand_id');
$brand = Brand::where('status', 1)
              ->whereIn('id', $particualrbrandid) // Filter only matching brand IDs
              ->get();



 $categories = Category::with(['translations'])->where('status', 1)->get();

    // Map translations for the current language
    $categories->each(function ($category) use ($currentLanguage) {
        $category->name = $category->translations->where('language_code', $currentLanguage)->first()->name ?? $category->name;
    });

 $productlist->each(function ($product) use ($currentLanguage) {
    // Get the product's name based on the current language
    $product->name = $product->translations->where('language_code', $currentLanguage)->first()->name ?? $product->name;

    // Get the brand's name based on the current language
    $product->brand_name = $product->brand->translations->where('language_code', $currentLanguage)->first()->name ?? $product->brand->name;

    // Get the average rating for the product from the Review model (1 to 5)
    $product->averageRating = Review::where('product_id', $product->id)->avg('rating');
    $product->reviewCount = Review::where('product_id', $product->id)->count();

    // If there's no rating, set it to a default (e.g., 0)
    if (is_null($product->averageRating)) {
        $product->averageRating = 0;
    }
});

 
return view('website.productlist',compact('productlist','categories','brand','taxdata','maxPrice','cartdata','mywishlistproduct'));
}


public function productlistviasubcategory($slug,Request $request)
{
 $currentLanguage = Session::get('website_locale', App::getLocale());
 $cartdata = Cart::cartgetlist($request);
 $mywishlistproduct = Wishlist::userwishlistproduct();

 $taxdata = Setting:: where('key', 'excluding_tax')->first();

$productlist = Product::frontendgetListssubcategory($slug);
 $subcategoryId = Subcategory::where('slug', $slug)->value('id');
 $categoryid = Subcategory::where('slug', $slug)->value('category_id');
 $categoryname = Category::where('id', $categoryid)->value('slug');

$particualrbrandid = Product::where('subcategories_id', $subcategoryId)->pluck('brand_id');
$brand = Brand::where('status', 1)
              ->whereIn('id', $particualrbrandid) // Filter only matching brand IDs
              ->get();
$subcategories = Subcategory::where('status', 1)->get();
   // Map translations for the current language
    $subcategories->each(function ($subcategory) use ($currentLanguage) {
        $subcategory->name = $subcategory->translations->where('language_code', $currentLanguage)->first()->name ?? $subcategory->name;
    });
 $productlist->each(function ($product) use ($currentLanguage) {
    // Get the product's name based on the current language
    $product->name = $product->translations->where('language_code', $currentLanguage)->first()->name ?? $product->name;

    // Get the brand's name based on the current language
    $product->brand_name = $product->brand->translations->where('language_code', $currentLanguage)->first()->name ?? $product->brand->name;

    // Get the average rating for the product from the Review model (1 to 5)
    $product->averageRating = Review::where('product_id', $product->id)->avg('rating');
    $product->reviewCount = Review::where('product_id', $product->id)->count();

    // If there's no rating, set it to a default (e.g., 0)
    if (is_null($product->averageRating)) {
        $product->averageRating = 0;
    }
});



return view('website.productlistviasubcategory',compact('productlist','subcategories','brand','taxdata','cartdata','mywishlistproduct','categoryname'));
}

public function coustomproductlist($slug,Request $request)
{
    

   
$productlist = Product::coustomproductlist($slug);
$visibilityid = Homepage::where('slug', $slug)->value('visibilitieid');

$particualrbrandid = Product::where('visibilityid', $visibilityid )->pluck('brand_id');
$cartdata = Cart::cartgetlist($request);
 $mywishlistproduct = Wishlist::userwishlistproduct();
$brand = Brand::where('status', 1)
              ->whereIn('id', $particualrbrandid) // Filter only matching brand IDs
              ->get();
$categories = Category::where('status', 1)->get();
 $productlist->each(function ($product) {
        // Get the average rating for the product from the Review model (1 to 5)
        $product->averageRating = Review::where('product_id', $product->id)->avg('rating');
         $product->reviewCount = Review::where('product_id', $product->id)->count();
        // If there's no rating, set it to a default (for example, 4)
        if (is_null($product->averageRating)) {
            $product->averageRating = 0; // Default rating if no rating exists
        }
    });


return view('website.coustomproductlist',compact('productlist','categories','brand','cartdata','mywishlistproduct'));
}

public function productdetails($slug)
{
 $user_id = Auth::guard('customer')->user()?->id ?? null;
 $currentLanguage = Session::get('website_locale', App::getLocale());
  $id = Product::where('slug', $slug)->value('id');
   $mywishlistproduct = Wishlist::userwishlistproduct();
 $wishlist = Wishlist::where('product_id', $id)->where('userid', $user_id)->value('product_id');


  
$productDetails = Product::frontendGetProductDetails($slug, $currentLanguage);
$createdbyid=$productDetails->created_by;
$sellerProducts = Product::where('created_by', $createdbyid)->pluck('id');
  $sellerReviews = Review::whereIn('product_id', $sellerProducts)->get();
    
    // Calculate the seller's overall average rating
    $sellerAverageRating = $sellerReviews->avg('rating');
    
    

$product_images = ProductImages::where('product_id', $id)->orderByDesc('is_default')->get();
$reviewsDetails = Review::reviewsgetLists($id);
$reviewsDetailsid = Review::where('product_id', $id)->where('user_id', $user_id)->first();
$orderDetailsid=OrderProduct::where('product_id', $id)->where('userid', $user_id)->where('status', 'delivered')->first();

$averageRating = $reviewsDetails->avg('rating');


 $starCounts = [
        '5' => $reviewsDetails->where('rating', 5)->count(),
        '4' => $reviewsDetails->where('rating', 4)->count(),
        '3' => $reviewsDetails->where('rating', 3)->count(),
        '2' => $reviewsDetails->where('rating', 2)->count(),
        '1' => $reviewsDetails->where('rating', 1)->count(),
    ];
    
 $totalReviews = $reviewsDetails->count();
 $totalSellerReviews = $sellerReviews->count();
$taxdata = Setting:: where('key', 'excluding_tax')->first();
$attributesdata = DB::table('attributes')
->join('products_attribute', 'attributes.id', '=', 'products_attribute.attributes_id')
->where('products_attribute.product_id', $id) // specify product ID filter
->select('attributes.name', 'products_attribute.attributes_value', 'products_attribute.product_id')
->get();
$taxRates = Taxrate::where('product_id', $id)->pluck('rate');



$product_variantsid = Product_variants_values::where('product_id', $id)
->distinct()
->first('product_id');


$activevariants = Product_variants_values::where('product_id', $id)->where('status', '1')->first();




$variantimages = $activevariants ? explode(',', $activevariants->images) : [];


$product_variantscolor = Product_variants::where('product_id', $id)->where('type', 'Colors')->get(); 
$product_variantsother = Product_variants::where('product_id', $id)->where('type', 'Text')->get(); 
return view('website.productdetails',compact('productDetails','product_images','product_variantscolor','product_variantsother','product_variantsid','variantimages','activevariants','taxdata','attributesdata','reviewsDetails','totalReviews','starCounts','averageRating','reviewsDetailsid','orderDetailsid','taxRates','sellerAverageRating','totalSellerReviews','wishlist','mywishlistproduct'));
}



public function chnagevariant(Request $request)
{
$selectedColors = $request->input('selectedColor');
$activeStyles = $request->input('activeStyles');
$productId = $request->input('product_id'); 




$colorString = implode(', ', (array) $selectedColors);
$styleString = implode(', ', (array) $activeStyles);

// Combine them into the desired format
$result = "{$colorString}{$styleString}";

// Create the reverse of $result
$reverseResult = "{$styleString}{$colorString}";

// Retrieve product variant data based on exact match for both orders
$product_variantdata = Product_variants_values::where(function ($query) use ($result, $reverseResult) {
$query->where('combinevariant', $result)
->orWhere('combinevariant', $reverseResult);
})
->where('product_id', $productId)
->first();


$productDiscount = Product::where('id', $productId)->value('discount');
 $productdiscountamount = $product_variantdata->price * ($productDiscount / 100);
 

 $priceafterdiscount=$product_variantdata->price - $productdiscountamount;

 
 $taxRates = Taxrate::where('product_id', $productId)->get();
$totalTax = 0;
                            
 foreach ($taxRates as $taxRate) {
 if ($taxRate->ratetype === 'percentage') {
 $totalTax += ($priceafterdiscount * $taxRate->rate) / 100;
 } elseif ($taxRate->ratetype === 'flat') {
$totalTax += $taxRate->rate;
    }
}

     if (setting('including_tax') == 0) {
$finalPriceWithTax = $priceafterdiscount + $totalTax;
 $discountpricewithtax=$product_variantdata->price + $totalTax;
 } else {
$finalPriceWithTax = $priceafterdiscount;
$discountpricewithtax=$product_variantdata->price;
}

// Get the price from the variant data
$price = $product_variantdata ? round($discountpricewithtax) : null;  
$sku = $product_variantdata ? $product_variantdata->sku : null;
$id = $product_variantdata ? $product_variantdata->id : null;
$specialprice = $product_variantdata ? round($finalPriceWithTax) : null;
$images = $product_variantdata ? explode(',', $product_variantdata->images) : [];


return response()->json([
'success' => true,
'message' => 'Variants processed successfully',
'result' => $result,
'price' => $price,
'sku' => $sku,
'id' => $id,
'images' => $images,
'specialprice' => $specialprice,
]);
}




// public function addCart(Request $request)
// {

// $user_id = Auth::guard('customer')->user()?->id ?? null;
// // Get the session ID from the request's IP address
// $session_id = $request->ip();
// Session::put('session_id', $session_id);

// $qty = $request->input('qty');
// $productPrice = $request->input('productPrice');
// $created_by = $request->input('created_by');

// $product_id = $request->input('product_id');
// $productvariantid = $request->input('productvariantid');





// // Check stock based on whether a variant ID is present
// if ($productvariantid) {
// // If a variant ID is provided, check stock from the Product_variants_values table
// $productVariant = Product_variants_values::where('product_id', $product_id)
// ->where('id', $productvariantid)
// ->first();


// if (!$productVariant || $qty > $productVariant->qty) {
// return response()->json([
// 'msg' => 'Insufficient stock !',
// 'type' => 'info',
// 'title' => 'Out of Stock!',
// ]);
// }
// } else {
// // If no variant ID is provided, check stock from the Product table
// $product = Product::where('id', $product_id)->first();

// if (!$product || $qty > $product->qty) {
// return response()->json([
// 'msg' => 'Insufficient stock !',
// 'type' => 'info',
// 'title' => 'Out of Stock!',
// ]);
// }
// }

// // Check if the item is already in the cart
// $get_data = Cart::where('product_id', $product_id)
// ->where('session_id', $session_id)
// ->where('variants_id', $productvariantid) // Include variant ID in the cart check
// ->get();

// $data = [
// 'qty' => $qty,
// 'product_id' => $product_id,
// 'variants_id' => $productvariantid,
// 'session_id' => $session_id,
// 'user_id' => $user_id,
// 'productprice' => $productPrice,
// 'seller_id' => $created_by
// ];

// $response = [];
// $cart_count = $get_data->count();

// if (!$get_data->isEmpty()) {
// $response['msg'] = 'Already In Your Cart';
// $response['type'] = 'warning';
// $response['title'] = 'Oops!';
// $response['cart_count'] = $cart_count;
// } else {
// Cart::create($data);
// $response['msg'] = 'Add To Cart Successfully';
// $response['type'] = 'success';
// $response['title'] = 'Good job!';
// }

// return response()->json($response);
// }

public function addCart(Request $request)
{
    $user_id = Auth::guard('customer')->user()?->id ?? null;
    // Get the session ID from the request's IP address
    $session_id = $request->ip();
    Session::put('session_id', $session_id);

    $qty = $request->input('qty');
    $productPrice = $request->input('productPrice');
    $created_by = $request->input('created_by');
    $product_id = $request->input('product_id');
    $productvariantid = $request->input('productvariantid');
    $productdiscount = $request->input('productdiscount');
    $producttax = $request->input('producttax');

    // Check stock based on whether a variant ID is present
    if ($productvariantid) {
        // If a variant ID is provided, check stock from the Product_variants_values table
        $productVariant = Product_variants_values::where('product_id', $product_id)
            ->where('id', $productvariantid)
            ->first();

  
if ($productVariant && $productVariant->inventoryManagement !== 'Dont-track-inventory' && $qty > $productVariant->qty) {
            return response()->json([
                'msg' => 'Insufficient stock!',
                'type' => 'info',
                'title' => 'Out of Stock!',
            ]);
        }
    } else {
        // If no variant ID is provided, check stock from the Product table
        $product = Product::where('id', $product_id)->first();

        if (!$product || $qty > $product->qty) {
            return response()->json([
                'msg' => 'Insufficient stock!',
                'type' => 'info',
                'title' => 'Out of Stock!',
            ]);
        }
    }


    // Check if the item is already in the cart
    $get_data = Cart::where('product_id', $product_id)
        ->where(function ($query) use ($user_id, $session_id, $productvariantid) {
            if ($user_id) {
                // When the user is logged in, match with user_id
                $query->where('user_id', $user_id);
            } else {
                // When the user is not logged in, match with session_id and user_id == NULL
                $query->where('session_id', $session_id)
                      ->whereNull('user_id');
            }
            $query->where('variants_id', $productvariantid);
        })
        ->get();

    $data = [
        'qty' => $qty,
        'product_id' => $product_id,
        'variants_id' => $productvariantid,
        'session_id' => $session_id,
        'user_id' => $user_id,
        'productprice' => $productPrice,
        'discountprice'=>$productdiscount,
        'taxamount'=>$producttax,
        'seller_id' => $created_by,
    ];

    $response = [];
    $cart_count = $get_data->count();

    if (!$get_data->isEmpty()) {
        $response['msg'] = 'Already In Your Cart';
        $response['type'] = 'warning';
        $response['title'] = 'Oops!';
        $response['cart_count'] = $cart_count;
    } else {
        Cart::create($data);
        $response['msg'] = 'Add To Cart Successfully';
        $response['type'] = 'success';
        $response['title'] = 'Good job!';
    }

    return response()->json($response);
}




public function cartdetails(Request $request)
{





return view('website.cartsummary');
}


// ===========Get cart Data===========
public function cart_data(Request $request)
{
    try {
  
        $res_data = Cart::cartgetlist($request);
      
  
        $cart_count = $res_data->count();  

      
        return view('website.cartdetails', [
            'res_data' => $res_data,
            'cart_count' => $cart_count
        ]);
    } catch (\Exception $e) {
      
        return redirect()->back()->with('error', 'Error fetching cart data: ' . $e->getMessage());
    }
}



// ===========Get cart for nav Data===========
// public function cart_datanav(Request $request)
// {


// $user_id = Auth::guard('customer')->user()?->id ?? null;


// $session_id = $request->ip();



// $res_data = DB::table('carts')
// ->leftJoin('product_variant_values', 'carts.variants_id', '=', 'product_variant_values.id')
// ->join('products', function ($join) {
// $join->on('product_variant_values.product_id', '=', 'products.id')
// ->orOn('carts.product_id', '=', 'products.id'); // Join based on product_id when there are no variants
// })
// ->leftJoin('products_image', function ($join) {
// $join->on('products.id', '=', 'products_image.product_id')
// ->where('products_image.is_default', 1); // Optional: use `is_default` if available
// })
// ->where('carts.session_id', $session_id)
// ->select(
// 'carts.id as cart_id',
// 'carts.session_id',
// 'carts.qty',
// DB::raw('IFNULL(product_variant_values.specialprice, products.price) as variantprice'), // Using product price if variant special price is not available
// 'product_variant_values.id as variantid',
// 'products.name as product_name',
// 'products.id as product_id',
// 'products.price as product_price',
// DB::raw('COALESCE(SUBSTRING_INDEX(product_variant_values.images, ",", 1), products_image.image) as first_image'), // Extracting the first image
// DB::raw('IF(carts.variants_id IS NULL, CONCAT("product", "/"), "") as image_prefix') // Check for variant ID and set image prefix accordingly
// )
// ->get();






// $total = 0;

// if (!empty($res_data)) {
// foreach ($res_data as $list) {
// $total += $list->qty * $list->variantprice;
// }
// }


// return view('website.navcartdetails', [
// 'res_data' => $res_data,
// 'total' => $total
// ]);
// }

public function cart_datanav(Request $request)
{
    $user_id = Auth::guard('customer')->user()?->id ?? null;
    $session_id = $request->ip();

    $query = DB::table('carts')
        ->leftJoin('product_variant_values', 'carts.variants_id', '=', 'product_variant_values.id')
        ->join('products', function ($join) {
            $join->on('product_variant_values.product_id', '=', 'products.id')
                 ->orOn('carts.product_id', '=', 'products.id'); // Join based on product_id when there are no variants
        })
        ->leftJoin('products_image', function ($join) {
            $join->on('products.id', '=', 'products_image.product_id')
                 ->where('products_image.is_default', 1); // Optional: use `is_default` if available
        })
        ->select(
            'carts.id as cart_id',
            'carts.session_id',
            'carts.qty',
            DB::raw('IFNULL(product_variant_values.specialprice, products.price) as variantprice'), // Using product price if variant special price is not available
            'product_variant_values.id as variantid',
            'products.name as product_name',
            'products.id as product_id',
            'products.price as product_price',
            DB::raw('COALESCE(SUBSTRING_INDEX(product_variant_values.images, ",", 1), products_image.image) as first_image'), // Extracting the first image
            DB::raw('IF(carts.variants_id IS NULL, CONCAT("product", "/"), "") as image_prefix') // Check for variant ID and set image prefix accordingly
        );

    // Conditionally fetch data based on whether the user is logged in
    if ($user_id) {
        $query->where('carts.user_id', $user_id); // Fetch cart based on user_id if logged in
    } else {
        $query->where('carts.session_id', $session_id)
         ->whereNull('carts.user_id');
     
    }

    $res_data = $query->get();

    // Calculate total
    $total = 0;
    if (!empty($res_data)) {
        foreach ($res_data as $list) {
            $total += $list->qty * $list->variantprice;
        }
    }

    return view('website.navcartdetails', [
        'res_data' => $res_data,
        'total' => $total
    ]);
}


// ===========Update cart ===========
public function updateCart(Request $request)
{
$session_id = $request->ip();
$qty = $request->input('qty');
$productid = $request->input('productid');
$variantid = $request->input('variantid');



// Validate that quantity is greater than zero
if ($qty == 0) {
$response['msg'] = 'Quantity should be greater than 0';
$response['type'] = 'warning';
$response['title'] = 'Warning !';
echo json_encode($response);
exit();
}

// Handle case for products with variants
if (!empty($variantid)) {
$productVariant = Product_variants_values::where('id', $variantid)->first();



if ($productVariant && $productVariant->inventoryManagement !== 'Dont-track-inventory' && $qty > $productVariant->qty) {
$response['msg'] = 'Your product quantity is greater than stock';
$response['type'] = 'warning';
$response['title'] = 'Warning !';
echo json_encode($response);
exit();
}

// Update the cart for products with variants
Cart::where('variants_id', $variantid)
->where('session_id', $session_id)
->update([
'qty' => $qty
]);
} else {
// Handle case for products without variants
$product = Product::where('id', $productid)->first();

if ($qty > $product->qty) {
$response['msg'] = 'Your product quantity is greater than stock';
$response['type'] = 'warning';
$response['title'] = 'Warning !';
echo json_encode($response);
exit();
}

// Update the cart for products without variants
Cart::where('product_id', $productid)
->where('session_id', $session_id)
->whereNull('variants_id') // Ensure that the product does not have a variant ID in the cart
->update([
'qty' => $qty
]);
}

// Return a success response
$response['result'] = true;
echo json_encode($response);
}









public function removeCart(Request $request)
{
    $product_id = $request->input('product_id');
    $user = Auth::guard('customer')->user();
    
    $where = [
        'product_id' => $product_id,
    ];

    if ($user) {
        $where['user_id'] = $user->id;
    } else {
        $where['session_id'] = $request->ip();
    }

    $res = Cart::where($where)->delete();

    if ($res) {
        $response = [
            'msg' => 'Product removed from cart successfully!',
            'type' => 'success',
            'title' => 'Success!',
        ];
    } else {
        $response = [
            'msg' => 'Failed to remove product from cart.',
            'type' => 'error',
            'title' => 'Error!',
        ];
    }

    return response()->json($response);
}



public function cartCount(Request $request)
{

 $user_id = Auth::guard('customer')->user()?->id ?? null;
$session_id = $request->ip();



$res_data = Cart::where('session_id', $session_id)->get();
  if ($user_id) {
       $res_data = Cart::where('user_id', $user_id)->get();
    } else {
   
        $res_data = Cart::where('session_id', $session_id) ->whereNull('carts.user_id')->get();
        
              
    }
$cart_count = $res_data->count();

return response()->json(['cart_count' => $cart_count]);
}


public function checkout(Request $request)
{


$res_data = Cart::cartgetlist($request);
$country_data = Country::get(); 
$state_data = State::get();
$city_data = City::get();  
$deliveryadress = Delivery_address::deliverygetLists();  




return view('website.checkout',compact('res_data','country_data','state_data','city_data','deliveryadress'));
}

public function buycheckout($slug, Request $request)
{
// Check if 'productid' or 'variant_id' is present in the query string
$product_id = $request->query('productid');
$variant_id = $request->query('variant_id');

// Start the query for product_variant_values
$res_data = DB::table('products')
// Join with product_variant_values, but allow the possibility of no match (left join)
->leftJoin('product_variant_values', function ($join) {
$join->on('product_variant_values.product_id', '=', 'products.id');
})
// Join with products_image for the default image
->leftJoin('products_image', function ($join) {
$join->on('products.id', '=', 'products_image.product_id')
->where('products_image.is_default', 1);
})
// Apply conditional where clauses
->when($product_id, function ($query, $product_id) {
$query->where('products.id', $product_id); // Filter based on products table
})
->when($variant_id, function ($query, $variant_id) {
$query->where('product_variant_values.id', $variant_id); // Filter based on product_variant_values table
})
->select(
DB::raw('IFNULL(product_variant_values.price, products.price) as variantprice'),
'product_variant_values.id as variantid',
'product_variant_values.price as vprice',
'product_variant_values.qty as variantqty',
'products.name as product_name',
'products.id as product_id',
'products.price as product_price',
'products.discount as discount',
'products.slug as slug',
'products.qty as product_qty',
'products.variant_id as variant_id',
'products.created_by as created_byid',
DB::raw('COALESCE(SUBSTRING_INDEX(product_variant_values.images, ",", 1), products_image.image) as first_image'),
DB::raw('IFNULL(product_variant_values.id, "") as image_prefix') // Image prefix adjusted
)
->first();

$tax_rates = DB::table('taxrates')
        ->where('product_id', $product_id)
        ->get();

// Fetch address and location data
$country_data = Country::get();
$state_data = State::get();
$city_data = City::get();
$deliveryadress = Delivery_address::deliverygetLists();

// Return the view with data
return view('website.buycheckout', compact('res_data', 'country_data', 'state_data', 'city_data', 'deliveryadress','tax_rates'));
}


public function usercountrychange(Request $request)
{

$category_id = $request->input('category_id');






$statename = State::where('countryid', $category_id)->get();





// Return a response if needed
return response()->json([
'success' => true,
'statename' => $statename
]);
}

public function userstatechange(Request $request)
{
$stateId = $request->input('state_id');

// Fetch cities based on state ID
$cities = City::where('stateid', $stateId)->get();

return response()->json([
'success' => true,
'cities' => $cities
]);
}






// public function getuserdatawithproduct(Request $request)
// {
// $pincode = $request->input('pincode');
// $total = $request->input('total');




// $productIds = $request->input('product_ids'); // Array of product IDs

// // Get city_id and state_id from Shipping based on pincode
// $shipping = Shipping::where('post_code', $pincode)
// ->select('city_id', 'state_id')
// ->first();

// if (!$shipping) {
// return response()->json(['success' => false, 'message' => 'Invalid pincode']);
// }

// $cityid = $shipping->city_id;
// $stateid = $shipping->state_id;

// // Initialize total rates
// $cityUsersRate = 0;    // For users with matching city_id
// $stateUsersRate = 0;   // For users with matching state_id

// // Initialize array to store the shipping amounts for each product
// $productShipping = [];

// // Loop through each product to calculate the total rate based on qty and shipping rate
// foreach ($productIds as $productId) {
// // Get the created_by user for each product
// $createdBy = Product::where('id', $productId)
// ->value('created_by');

// // Check city_id for the user shipping
// $userShippingCities = ShippingRate::where('user_id', $createdBy)
// ->whereRaw("FIND_IN_SET(?, cityid)", [$cityid])
// ->get();

// // Default rate for the product
// $productRate = 0;

// // Loop through matching cities for the user
// foreach ($userShippingCities as $userShippingCity) {
// $rate = $userShippingCity->rate;
// $cityUsersRate += $rate; // Add the rate without multiplying by quantity

// // Store individual user data
// $productShipping[] = [
// 'product_id' => $productId,
// 'shipping_amount' => $rate, // Shipping amount for this product
// ];
// }

// // If no city match is found, fallback to state_id
// if ($userShippingCities->isEmpty()) {
// $userShippingStates = ShippingRate::where('user_id', $createdBy)
// ->whereRaw("FIND_IN_SET(?, stateid)", [$stateid])
// ->get();

// // Loop through matching states for the user
// foreach ($userShippingStates as $userShippingState) {
// $rate = $userShippingState->rate;
// $stateUsersRate += $rate; // Add the rate without multiplying by quantity

// // Store individual user data
// $productShipping[] = [
// 'product_id' => $productId,
// 'shipping_amount' => $rate, // Shipping amount for this product
// ];
// }
// }
// }

// // Calculate grand total and shipping total
// $grandTotal = floatval($cityUsersRate) + floatval($stateUsersRate) + floatval($total);

// $shippingTotal = floatval($cityUsersRate) + floatval($stateUsersRate);

// return response()->json([
// 'success' => true,
// 'grandTotal' => $grandTotal, 
// 'shippingTotal' => $shippingTotal,
// 'productShipping' => $productShipping,  // Send product-specific shipping amounts
// 'message' => 'Data processed successfully'
// ]);
// }

public function getuserdatawithproduct(Request $request)
{
    $pincode = $request->input('pincode');
    $total = $request->input('total');
    $totaltax = $request->input('totaltax');
    
    $productIds = $request->input('product_ids'); // Array of product IDs

    // Get city_id and state_id from Shipping based on pincode
    $shipping = Shipping::where('post_code', $pincode)
        ->select('city_id', 'state_id')
        ->first();

    if (!$shipping) {
        return response()->json(['success' => false, 'message' => 'Invalid pincode']);
    }

    $cityid = $shipping->city_id;
    $stateid = $shipping->state_id;

    // Array to store total shipping rate for each user
    $userShippingRates = [];

    // Initialize array to store the shipping amounts for each product
    $productShipping = [];

    // Group products by their creator (created_by)
    $productsGroupedByUser = [];

    foreach ($productIds as $productId) {
        // Get the created_by user for each product
        $createdBy = Product::where('id', $productId)
            ->value('created_by');

        // Add product to the user's list
        if (!isset($productsGroupedByUser[$createdBy])) {
            $productsGroupedByUser[$createdBy] = [];
        }
        $productsGroupedByUser[$createdBy][] = $productId;
    }

    // Loop through each user and calculate their shipping rate
    foreach ($productsGroupedByUser as $createdBy => $productIds) {
        // Check if we've already calculated shipping for this user
        if (!isset($userShippingRates[$createdBy])) {
            // Get user shipping details based on city_id
            $userShippingCities = ShippingRate::where('user_id', $createdBy)
                ->whereRaw("FIND_IN_SET(?, cityid)", [$cityid])
                ->get();

            // Default rate for the product
            $rate = 0;

            // If no city match, fallback to state_id
            if ($userShippingCities->isEmpty()) {
                $userShippingStates = ShippingRate::where('user_id', $createdBy)
                    ->whereRaw("FIND_IN_SET(?, stateid)", [$stateid])
                    ->get();

                foreach ($userShippingStates as $userShippingState) {
                    $rate = $userShippingState->rate;
                    break; // Use the first matching state rate
                }
            } else {
                // Use the first matching city rate
                foreach ($userShippingCities as $userShippingCity) {
                    $rate = $userShippingCity->rate;
                    break; // Use the first matching city rate
                }
            }

            // Store the calculated rate for this user
            $userShippingRates[$createdBy] = $rate;
        }

        // Now distribute the rate equally among all products from this user
        $shippingAmountPerProduct = $userShippingRates[$createdBy] / count($productIds);

        // Assign the calculated shipping amount for each product
        foreach ($productIds as $productId) {
            $productShipping[] = [
                'product_id' => $productId,
                'shipping_amount' => $shippingAmountPerProduct, // Distribute equally
            ];
        }
    }

    // Calculate grand total and shipping total
    $grandTotal = floatval($total) + floatval($totaltax) + floatval(array_sum($userShippingRates));
    $shippingTotal = floatval(array_sum($userShippingRates));

    return response()->json([
        'success' => true,
        'grandTotal' => $grandTotal,
        'shippingTotal' => $shippingTotal,
        'productShipping' => $productShipping,  // Send product-specific shipping amounts
        'message' => 'Data processed successfully'
    ]);
}



public function myaccount(Request $request)
{


$user_id = Auth::guard('customer')->user()?->id ?? null;
$deliveryadress = Delivery_address::deliverygetLists(); 
$myorders = OrderProduct::userOrdersGetLists();

$mywishlistproduct = Wishlist::userwishlistproduct();


 





$userinfo = User::where('id', $user_id)->first();
$country_data = Country::get(); 
$state_data = State::get();
$city_data = City::get();

return view('website.myaccount',compact('userinfo','country_data','state_data','city_data','deliveryadress','myorders','mywishlistproduct'));
}


public function userorderdetails($id)
{
$myordersdetails = OrderProduct::userOrdersdetailsGetLists($id);




$shippingid=$myordersdetails->deliveryaddress_id;


$reviews = Review::where('order_id', $id)->first();
   
   



$deliveryaddress = Delivery_address::where('id', $shippingid)->first();



return view('website.userorderdetails', compact('myordersdetails','deliveryaddress','reviews'));
}



public function editshippingaddress($id)
{


$user_id = Auth::guard('customer')->user()?->id ?? null;
$delivery_address = Delivery_address::where('id', $id)->first();
$zipcodes = Shipping::where('post_code', $delivery_address->zip_code)->pluck('post_code');

     $country_data = country::get();
    $state_data = state::where('countryid', $delivery_address->country_id)->get();
    $city_data = city::where('stateid', $delivery_address->state_id)->get();





return view('website.editshippingaddress',compact('country_data','state_data','city_data','delivery_address','zipcodes'));
}



public function UpdateShippingAddress(Request $request)
{


$user_id = Auth::guard('customer')->user()?->id ?? null;



// Check if a shipping address already exists for this user
$shippingAddress = Delivery_address::where('id', $request->shippingid)->where('user_id', $user_id)->first();


if ($shippingAddress) {
// Update the existing shipping address
$shippingAddress->update([
'name' => $request->input('name'),
'email' => $request->input('email'),
'phone' => $request->input('phone'),
'address' => $request->input('address'),
'landmark' => $request->input('landmark'),
'country_id' => $request->input('countryid'),
'state_id' => $request->input('stateid'),
'city_id' => $request->input('cityid'),
'zip_code' => $request->input('postCode'),
'user_id' =>  $user_id,
]);

return redirect()->to('my-account')->with('success', 'Shipping Update Successfully.');

} else {
// Insert a new shipping address
Delivery_address::create([

'name' => $request->input('name'),
'email' => $request->input('email'),
'phone' => $request->input('phone'),
'address' => $request->input('address'),
'landmark' => $request->input('landmark'),
'country_id' => $request->input('countryid'),
'state_id' => $request->input('stateid'),
'city_id' => $request->input('cityid'),
'zip_code' => $request->input('postCode'),
'user_id' =>  $user_id,
]);
return redirect()->to('my-account')->with('success', 'shipping Update successfully.');

}
}

public function deleteshippingaddress($id)
{

$deliveryAddress = Delivery_address::find($id);


if ($deliveryAddress) {

$deliveryAddress->delete();


return redirect()->to('my-account')->with('success', 'shipping Delete successfully.');
} else {

return redirect()->to('my-account')->with('error', 'Shipping address not found.');
}
}



public function AddnewShippingAddress(Request $request)
{

 $user_id = Auth::guard('customer')->user()?->id ?? null;



// Insert a new shipping address
Delivery_address::create([

'name' => $request->input('name'),
'email' => $request->input('email'),
'phone' => $request->input('phone'),
'address' => $request->input('address'),
'landmark' => $request->input('landmark'),
'country_id' => $request->input('countryid'),
'state_id' => $request->input('stateid'),
'city_id' => $request->input('cityid'),
'zip_code' => $request->input('postCode'),
'user_id' =>  $user_id,
]);
return redirect('checkout');


}



public function sellerregister(Request $request)
{
$country_data = Country::get(); 
$state_data = State::get();
$city_data = City::get();
$cms_data = Cms::get();
return view('website.sellersregister',compact('country_data','state_data','city_data','cms_data'));
}


public function storesellers(Request $request)
{
    
    
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email|max:255',
        'mobile' => 'required|string|max:15',
        'country' => 'required',
        'state' => 'required',
        'city' => 'required',
        'password' => 'required|min:6|confirmed',
        'terms_and_policy' => 'accepted',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()->toArray(),
        ], 422);
    }

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->mobile,
        'countryid' => $request->country,
        'stateid' => $request->state,
        'cityid' => $request->city,
        'type' => 'seller',
        'role_id' => '9',
        'password' => Hash::make($request->password),
    ]);
    session()->flash('success', 'Registration successful! You can now log in.');
    return response()->json([
       'type' => 'success',
        'msg' => 'Registration successful! You can now log in.',
    ]);
}

// this is for place order

public function placeOrders(Request $request)
{
 
    $user_id = Auth::guard('customer')->user()?->id ?? null;
    $session_id = $request->ip();
    $cusemail = User::where('id', $user_id)->value('email');
    $ordercount = OrderProduct::count() + 1;
   $orderprefix= Setting::where('key','order_prefix')->value('value');
   


    

    // Get request data
    $shippingamount = $request->input('shippingamount');
    $payment_method = $request->input('payment_method');
    $product_price = $request->input('product_price');
     $product_tax = $request->input('product_tax');
 
  
    $grandTotalamount = $request->input('grandTotalamount');
    $shippingAddressId = $request->input('shippingAddressId');
    $total = $request->input('total');
    $productshipping = $request->input('productshipping');
    $productcoupndiscount = $request->input('productcoupndiscount');
     
   
  
    
     
    // Retrieve the cart items for the current session
    $cart_items = Cart::where('session_id', $session_id)->get();
    
    

    // Check if there are items in the cart
    if ($cart_items->isEmpty()) {
        return response()->json(['status' => false, 'message' => 'No items in cart']);
    }
       $orderProducts = [];
    $shippingIndex = 0; // Track shipping cost index
     $coupndiscountgIndex = 0;
    $productpricetrack = 0;
     $product_taxtrack = 0;
     

    foreach ($cart_items as $each_cart) {
        $product_id = $each_cart->product_id;
        $quantity = $each_cart->qty;
        $variants_id = $each_cart->variants_id;
        $seller_id = $each_cart->seller_id;
      
        // Generate a unique order key
       $ordercount = OrderProduct::count() + 1; // Increment the order count by 1
$orderprefix = setting('order_prefix'); // Fetch the order prefix
$sixDigitId = str_pad($ordercount, 6, '0', STR_PAD_LEFT); // Ensure the ID is 6 digits long
$order_keyrandom = $orderprefix  . $sixDigitId;

        // Get shipping cost for the current product
        $shipping_cost = isset($productshipping[$shippingIndex]) ? $productshipping[$shippingIndex] : 0;
         $discount_amount = isset($productcoupndiscount[$coupndiscountgIndex]) ? $productcoupndiscount[$coupndiscountgIndex] : 0;
          $singleproductprice = isset($product_price[$productpricetrack]) ? $product_price[$productpricetrack] : 0;
          $singleproducttax = isset($product_tax[$product_taxtrack]) ? $product_tax[$product_taxtrack] : 0;

        // Fetch seller commission percentage from the User table
        $seller = User::find($seller_id);

$commissionAmount = 0; // Default to 0 if commison_status != 1
if ($seller && $seller->commison_status == 1) {
    $commissionPercentage = $seller->commison;
    $commissionAmount = ($singleproductprice * $commissionPercentage) / 100; // Calculate commission
} else {
    $commissionPercentage = 0; // Set commission percentage to 0 if status is not 1
}

        // Deduct commission from the product price
        $finalSellerAmount = $singleproductprice - $commissionAmount;
        $totalfinalSellerAmount=$finalSellerAmount+$shipping_cost;
        
         
   

if (setting('including_tax') == 0) {
   $orderTotal = (($singleproductprice * $quantity) + $shipping_cost) - $discount_amount;
} else {
   
  $orderTotal = (($singleproductprice * $quantity) + $shipping_cost + $singleproducttax) - $discount_amount;
}

if (setting('including_tax') == 0) {
     
     $totalproductprice = (($singleproductprice * $quantity) - $singleproducttax);

    
} else {
   
     $totalproductprice = (($singleproductprice * $quantity));
}

   



  

        $orderProduct = OrderProduct::create([
            'userid' => $user_id,
            'product_id' => $product_id,
            'variantsid' => $variants_id,
            'seller_id' => $seller_id,
            'order_quantity' => $quantity,
            'order_key' => $order_keyrandom,
            'product_price' => $totalproductprice,
            'deliveryaddress_id' => $shippingAddressId,
            'payment_status' => 'paid',
          'order_total' => $orderTotal,
            'producttax' => $singleproducttax,
          'singleproduct_price' => $singleproductprice,

            'payment_method' => $payment_method,
            'status' => 'pending',
            'shipping_amount' => $shipping_cost,
            'discountamount'=>$discount_amount,
        ]);

        // Insert commission details into SellerIncome
        SellerIncome::create([
            'seller_id' => $seller_id,
            'order_id' => $orderProduct->id,
            'commission_amount' => $commissionAmount,
             'income_amount' =>$totalfinalSellerAmount,
        ]);

 $orderProducts[] = [
            'product_name' => $each_cart->product->name,
            'qty' => $quantity,
            'product_price' => $singleproductprice,
        ];
        // Update stock for the product or variant
        if ($orderProduct) {
            if ($variants_id) {
                $variant = Product_variants_values::where('id', $variants_id)->first();
                if ($variant && $variant->qty >= $quantity) {
                    $variant->qty -= $quantity;
                    $variant->save();
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Insufficient stock for variant',
                    ]);
                }
            } else {
                $product = Product::find($product_id);
                if ($product && $product->qty >= $quantity) {
                    $product->qty -= $quantity;
                    $product->save();
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Insufficient stock for product',
                    ]);
                }
            }
            // Uncomment this line to delete the cart item after order creation
            Cart::destroy($each_cart->id);
        }

        $shippingIndex++;
         $coupndiscountgIndex++;
         $productpricetrack++;
         $product_taxtrack++;
    }
    $totalShippingAmount = array_sum($productshipping);
    $totalCouponDiscount = array_sum($productcoupndiscount);

// Final payable amount after deductions
$finalAmount = $grandTotalamount + $totalShippingAmount - $totalCouponDiscount;
     Mail::to($cusemail)->send(new OrderPlacedMail(compact( 'payment_method', 'grandTotalamount'), $orderProducts));
    return response()->json([
        'status' => true,
        'message' => 'Order has been placed successfully',
    ]);
}





public function createRazorpayOrders(Request $request)
{
    $user_id = Auth::guard('customer')->user()?->id ?? null;
    $session_id = $request->ip();
    $cusemail = User::where('id', $user_id)->value('email');
    $cart_items = Cart::where('session_id', $session_id)->get();
    $productshipping = $request->input('productshipping', []);
    $productcoupndiscount = $request->input('productcoupndiscount', []);
    $product_price = $request->input('product_price', []);


    $product_tax = $request->input('product_tax', []);
    $payment_method = $request->input('payment_method');

    if ($cart_items->isEmpty()) {
        return response()->json(['status' => false, 'message' => 'No items in cart']);
    }

    $apiKey = setting('razorpay_key');
    $apiSecret = setting('razorpay_secret');
    $totalOrderAmount = 0;
    $orderProducts = [];

    // Generate unique order key
     $ordercount = OrderProduct::count() + 1; // Increment the order count by 1
$orderprefix = setting('order_prefix'); // Fetch the order prefix
$sixDigitId = str_pad($ordercount, 6, '0', STR_PAD_LEFT); // Ensure the ID is 6 digits long
$order_keyrandom = $orderprefix  . $sixDigitId;

    foreach ($cart_items as $index => $each_cart) {
        $product_id = $each_cart->product_id;
        $quantity = $each_cart->qty;
        $variants_id = $each_cart->variants_id;
        $seller_id = $each_cart->seller_id;
        
        // Extract relevant values with default fallback
        $shipping_cost = $productshipping[$index] ?? 0;
        $discount_amount = $productcoupndiscount[$index] ?? 0;
        $singleproductprice = $product_price[$index] ?? 0;
        $singleproducttax = $product_tax[$index] ?? 0;

       

        // Calculate order total
        if (setting('including_tax') == 0) {
            $orderTotal = (($singleproductprice * $quantity) + $shipping_cost) - $discount_amount;
            $totalproductprice = (($singleproductprice * $quantity) - $singleproducttax);
        } else {
            $orderTotal = (($singleproductprice * $quantity) + $shipping_cost + $singleproducttax) - $discount_amount;
            $totalproductprice = ($singleproductprice * $quantity);
        }

        $totalOrderAmount += $orderTotal;

        // Create order product record
        $orderProduct = OrderProduct::create([
            'userid' => $user_id,
            'product_id' => $product_id,
            'variantsid' => $variants_id,
            'seller_id' => $seller_id,
            'producttax' => $singleproducttax,
            'singleproduct_price' => $singleproductprice,
            'order_quantity' => $quantity,
            'order_key' => $order_keyrandom,
            'product_price' => $totalproductprice,
            'deliveryaddress_id' => $request->input('shippingAddressId'),
            'payment_status' => 'pending',
            'order_total' => $orderTotal,
            'payment_method' => 'razorpay',
            'status' => 'pending',
            'shipping_amount' => $shipping_cost,
            'discountamount' => $discount_amount,
        ]);

       

        $orderProducts[] = [
            'product_name' => $each_cart->product->name,
            'qty' => $quantity,
            'product_price' => $singleproductprice,
        ];
    }

    // Create Razorpay order
    $razorpayOrderId = $this->createRazorpayOrder($totalOrderAmount, $order_keyrandom, $apiKey, $apiSecret);

    if ($razorpayOrderId) {
       

        // Update orders with Razorpay order ID
        OrderProduct::where('order_key', $order_keyrandom)->update(['onlinepay_order_id' => $razorpayOrderId]);

        return response()->json(['status' => true, 'message' => 'Order created successfully', 'razorpay_order_id' => $razorpayOrderId]);
    }

    return response()->json(['status' => false, 'message' => 'Failed to create Razorpay order']);
}


 public function createRazorpayOrder($totalAmount, $order_keyrandom, $apiKey, $apiSecret)
{
    
    
    $data = [
        'amount' => intval($totalAmount * 100), // Convert to paise
        'currency' => 'INR',
        'receipt' => $order_keyrandom,
        'payment_capture' => 1,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/orders');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ':' . $apiSecret);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $result = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($result, true);

    return $response['id'] ?? null;  // Return Razorpay order ID
}



public function updatePaymentStatus(Request $request)
{
    $apiKey = setting('razorpay_key');
    $apiSecret = setting('razorpay_secret');
    $user_id = Auth::guard('customer')->user()?->id ?? null;

    // Find all order products related to the order
    $orderProducts = OrderProduct::where('onlinepay_order_id', $request->razorpay_order_id)->get();

    if ($orderProducts->isEmpty()) {
        return response()->json(['status' => false, 'message' => 'Order not found']);
    }

    try {
        // Fetch user email
        $cusemail = User::where('id', $user_id)->value('email');

        $totalOrderAmount = 0;
        $orderedProducts = [];

        // If signature is valid, update payment status for the order products
        foreach ($orderProducts as $orderProduct) {
            $seller_id = $orderProduct->seller_id;
            $product_price = $orderProduct->product_price;
            $shipping_cost = $orderProduct->shipping_amount;

            // Fetch seller commission percentage
            $seller = User::find($seller_id);
            $commissionPercentage = ($seller && $seller->commison_status == 1) ? $seller->commison : 0;
            $commissionAmount = ($product_price * $commissionPercentage) / 100;
            $finalSellerAmount = $product_price - $commissionAmount;
            $totalfinalSellerAmount = $finalSellerAmount + $shipping_cost;

            // Update order product status
            $orderProduct->update([
                'payment_status' => 'paid',
                'transaction_id' => $request->razorpay_payment_id, // Save the Razorpay payment ID
                'status' => 'pending', // You can set it to 'processing' or any other status you want
            ]);

            // Insert Seller Income after payment confirmation
            SellerIncome::create([
                'seller_id' => $seller_id,
                'order_id' => $orderProduct->id,
                'commission_amount' => $commissionAmount,
                'income_amount' => $totalfinalSellerAmount,
            ]);

            // Prepare email data
            $orderedProducts[] = [
                'product_name' => $orderProduct->product->name,
                'qty' => $orderProduct->order_quantity,
                'product_price' => $orderProduct->singleproduct_price 
            ];

            $totalOrderAmount += $orderProduct->order_total;
        }

        // Send order confirmation email
        Mail::to($cusemail)->send(new OrderPlacedMail([
            'payment_method' => 'razorpay',
            'grandTotalamount' => $totalOrderAmount,
            'transaction_id' => $request->razorpay_payment_id,
        ], $orderedProducts));

        return response()->json(['status' => true, 'message' => 'Payment successful and email sent']);

    } catch (\Exception $e) {
        // If payment verification fails or any exception occurs, update status to 'failed'
        foreach ($orderProducts as $orderProduct) {
            $orderProduct->update([
                'payment_status' => 'failed',
                'status' => 'failed', // Set the order product status to 'failed' as well
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Payment verification failed']);
    }
}


public function orderdeleteCart(Request $request)
{
    $userId = $request->user_id;

    if ($userId) {
        Cart::where('user_id', $userId)->delete(); // Assuming Cart model is set up with user_id
        return response()->json(['status' => true, 'message' => 'Cart cleared successfully']);
    }
    return response()->json(['status' => false, 'message' => 'User not found']);
}


// this is for place order direct


public function placeOrderdirect(Request $request)
{

$user_id = Auth::guard('customer')->user()?->id ?? null;

$session_id = $request->ip();
 $cusemail = User::where('id', $user_id)->value('email');
  $ordercount = User::where('id', $user_id)->value('email');
// Get request data
$shippingamount = $request->input('shippingamount');
$grandTotalamount = $request->input('grandTotalamount');



$shippingAddressId = $request->input('shippingAddressId');
$total = $request->input('total');
$variantsid = $request->input('variantsid');
$created_byid = $request->input('created_byid');
$productqty = $request->input('productqty');

$paymentMethod = $request->input('paymentMethod');
$producttax = $request->input('producttax');
$productprice = $request->input('productprice');


$productid = $request->input('productid');
$discountofproduct = $request->input('discountofproduct');




// Generate a unique order key for each product
 $ordercount = OrderProduct::count() + 1; // Increment the order count by 1
$orderprefix = setting('order_prefix'); // Fetch the order prefix
$sixDigitId = str_pad($ordercount, 6, '0', STR_PAD_LEFT); // Ensure the ID is 6 digits long
$order_keyrandom = $orderprefix  . $sixDigitId;

$totalproducttax=$producttax*$productqty;

 
    
    if (setting('including_tax') == 0) {
   $orderTotal = (($productprice * $productqty) + $shippingamount) - $discountofproduct;
} else {
   
  $orderTotal = (($productprice * $productqty) + $shippingamount + $totalproducttax) - $discountofproduct;
}

if (setting('including_tax') == 0) {
     
     $totalproductprice = (($productprice * $productqty) - $totalproducttax);


    
} else {
   
     $totalproductprice = (($productprice * $productqty));
}


        $seller = User::find($created_byid);

$commissionAmount = 0; // Default to 0 if commison_status != 1
if ($seller && $seller->commison_status == 1) {
    $commissionPercentage = $seller->commison;
    $commissionAmount = ($productprice * $commissionPercentage) / 100; // Calculate commission
} else {
    $commissionPercentage = 0; // Set commission percentage to 0 if status is not 1
}

        // Deduct commission from the product price
        $finalSellerAmount = $productprice - $commissionAmount;
        $totalfinalSellerAmount=$finalSellerAmount+$shippingamount;
// Create a new OrderProduct entry
$orderProduct = OrderProduct::create([
'userid' => $user_id,
'product_id' => $productid,
'variantsid' => $variantsid,
'seller_id' => $created_byid,
'order_quantity' => $productqty,
'order_key' => $order_keyrandom,
'product_price' => $totalproductprice,
'deliveryaddress_id' => $shippingAddressId,
'payment_status' => 'paid',
'order_total' => $orderTotal,
'producttax' => $totalproducttax,
 'singleproduct_price' => $productprice,
'discountamount' => $discountofproduct,
'payment_method' => 'cash',
'status' => 'pending',
'shipping_amount' => $shippingamount,  // Added shipping cost here
]);

    SellerIncome::create([
            'seller_id' => $created_byid,
            'order_id' => $orderProduct->id,
            'commission_amount' => $commissionAmount,
             'income_amount' =>$totalfinalSellerAmount,
        ]);

// Check and update product or variant quantity
if ($orderProduct) {
if ($variantsid) {
// Handle variant stock deduction
$variant = Product_variants_values::where('id', $variantsid)->first();

if ($variant && $variant->qty >= $productqty) {
// Deduct the quantity from variant stock
$variant->qty -= $productqty;
$variant->save();
} else {
// Variant stock not available
return response()->json([
'status' => false,
'message' => 'Insufficient stock for variant',
]);
}
} else {
// Handle product stock deduction
$product = Product::find($productid);

if ($product && $product->qty >= $productqty) {
// Deduct the quantity from product stock
$product->qty -= $productqty;
$product->save();
} else {
// Product stock not available

return response()->json([
'status' => false,
'message' => 'Insufficient stock for product',
]);
}
}


}



    // Send email to the customer
    if ($cusemail) {
        $orderDetails = [
            'payment_method' => $paymentMethod,
            'grandTotalamount' => $grandTotalamount,
        ];

        $cartItems = [
            [
                'product_name' => Product::where('id', $productid)->value('name'),
                'qty' => $productqty,
                'product_price' => $productprice,
            ]
        ];

        Mail::to($cusemail)->send(new OrderPlacedMail($orderDetails, $cartItems));
    }


// Return a success response after all items are inserted

return response()->json([
 'status' => true,
'message' => 'Order has been placed successfully',
]);
}




// direct order with regerpay

public function createRazorpaysingleOrders(Request $request)
{
    $user_id = Auth::guard('customer')->user()?->id ?? null;
    
   
    $session_id = $request->ip();
    $shippingamount = $request->input('shippingamount');
$grandTotalamount = $request->input('grandTotalamount');

$shippingAddressId = $request->input('shippingAddressId');
$total = $request->input('total');
$variantsid = $request->input('variantsid');
$created_byid = $request->input('created_byid');
$productqty = $request->input('productqty');

$paymentMethod = $request->input('paymentMethod');
$producttax = $request->input('producttax');
$productprice = $request->input('productprice');


$productid = $request->input('productid');
$discountofproduct = $request->input('discountofproduct');

    

   $apiKey = setting('razorpay_key');
   $apiSecret = setting('razorpay_secret');

   
    
  

    // Create the order first
     $ordercount = OrderProduct::count() + 1; // Increment the order count by 1
$orderprefix = setting('order_prefix'); // Fetch the order prefix
$sixDigitId = str_pad($ordercount, 6, '0', STR_PAD_LEFT); // Ensure the ID is 6 digits long
$order_keyrandom = $orderprefix  . $sixDigitId;

        if (setting('including_tax') == 0) {
   $orderTotal = (($productprice * $productqty) + $shippingamount) - $discountofproduct;
} else {
   
  $orderTotal = (($productprice * $productqty) + $shippingamount + $producttax) - $discountofproduct;
}

if (setting('including_tax') == 0) {
     
     $totalproductprice = (($productprice * $productqty) - $producttax);

    
} else {
   
     $totalproductprice = (($productprice * $productqty));
}
     
     
     $orderProduct = OrderProduct::create([
'userid' => $user_id,
'product_id' => $productid,
'variantsid' => $variantsid,
'seller_id' => $created_byid,
'order_quantity' => $productqty,
'order_key' => $order_keyrandom,
'product_price' => $totalproductprice,
'deliveryaddress_id' => $shippingAddressId,
'payment_status' => 'pending',
'order_total' => $orderTotal,
'producttax' => $producttax,
'singleproduct_price' => $productprice,
'discountamount' => $discountofproduct,
'payment_method' => 'razorpay',
'status' => 'pending',
'shipping_amount' => $shippingamount,  // Added shipping cost here
]);

    // Create Razorpay order after creating all order records
    $razorpayOrderId = $this->createRazorpayOrder($orderTotal, $order_keyrandom, $apiKey, $apiSecret);
    
   

    if ($razorpayOrderId) {
        // Update the order records with the Razorpay order ID
        OrderProduct::where('order_key', $order_keyrandom)->update(['onlinepay_order_id' => $razorpayOrderId]);

        return response()->json(['status' => true, 'message' => 'Order created successfully', 'razorpay_order_id' => $razorpayOrderId]);
    } else {
        return response()->json(['status' => false, 'message' => 'Failed to create Razorpay order']);
    }
}

public function ordercomplete(Request $request)
{

return view('website.orderthankyou');
}




public function homepagefilter(Request $request)
{
// Retrieve the category ID and name (search keyword) from the query parameters
$categoryId = $request->input('categoryid');
$searchName = $request->input('name');
 $mywishlistproduct = Wishlist::userwishlistproduct();
 $cartdata = Cart::cartgetlist($request);
// Call the product search method with the category and name filters
$productlist = Product::frontendproductsearch($categoryId, $searchName);
$brand = Brand::where('status', 1)->get();
$categories = Category::where('status', 1)->get();
 $productlist->each(function ($product) {
        // Get the average rating for the product from the Review model (1 to 5)
        $product->averageRating = Review::where('product_id', $product->id)->avg('rating');
         $product->reviewCount = Review::where('product_id', $product->id)->count();
        // If there's no rating, set it to a default (for example, 4)
        if (is_null($product->averageRating)) {
            $product->averageRating = 0; // Default rating if no rating exists
        }
    });
// Return the filtered products to the view
return view('website.productsearchlist', compact('productlist','brand','categories','mywishlistproduct','cartdata'));
}


 public function SellerTermandCondition(Request $request)
{
 $cms_data = Cms::where('type', 'seller')->where('slug', 'term-and-condition')->first();
return view('website.sellert&c',compact('cms_data'));
}

 public function userTermandCondition(Request $request)
{
  $cms_data = Cms::where('type', 'user')->where('slug', 'term-and-condition')->first();
return view('website.usert&c',compact('cms_data'));
}

public function showPage($slug)
{
    // Get the current language from the session or fallback to default language
    $currentLanguage = Session::get('website_locale', App::getLocale());

    // Find the CMS page by slug
    $cms_data = Cms::where('slug', $slug)->firstOrFail();

    // Get the translation of the CMS page based on the current language
    $cms_translation = CmsTranslation::where('cms_id', $cms_data->id)
                                      ->where('language_code', $currentLanguage)
                                      ->first();

    // If the translation is not found, fall back to the default language or the original CMS content
    if (!$cms_translation) {
        $cms_translation = CmsTranslation::where('cms_id', $cms_data->id)
                                          ->where('language_code', 'en') // Fallback to default language (e.g., 'en')
                                          ->first();
    }

    // Return the view with the CMS page and translation data
    return view('website.usert&c', [
        'cms_data' => $cms_data,
        'cms_translation' => $cms_translation
    ]);
}


public function storewishlist(Request $request)
{
    $user_id = Auth::guard('customer')->user()?->id ?? null;

    if (!$user_id) {
        return response()->json([
            'msg' => 'Please login',
            'type' => 'error',
            'title' => 'Please login',
        ]);
    }

    // Check if the product already exists in the wishlist for the current user
    $existingWishlist = Wishlist::where('userid', $user_id)
                                ->where('product_id', $request->productid)
                                ->first();

    if ($existingWishlist) {
        // If product exists, remove it from the wishlist
        $existingWishlist->delete();

        return response()->json([
            'type' => 'removed',
            'msg' => 'Product removed from Wishlist.',
            'title' => 'Wishlist removed',
        ]);
    } else {
        // If product does not exist, add it to the wishlist
        Wishlist::create([
            'userid' => $user_id,
            'product_id' => $request->productid,
            'variants_id' => $request->productvariant_id,
        ]);

        return response()->json([
            'type' => 'added',
            'msg' => 'Product Added to Wishlist.',
            'title' => 'Wishlist added',
        ]);
    }
}


public function wishCount(Request $request)
{
    $user_id = Auth::guard('customer')->user()?->id ?? null;

    if ($user_id) {
        // User is logged in, fetch from the database
        $wish_count = Wishlist::where('userid', $user_id)->count();
    } else {
        // User is a guest, get wishlist count from session
        $wishlist = session()->get('wishlist', []);
        $wish_count = count($wishlist);
    }

    return response()->json(['wish_count' => $wish_count]);
}


public function deletewishlist($id)
{
    $Wishlist = Wishlist::find($id);

    if ($Wishlist) {
        $Wishlist->delete();

        return response()->json([
            'type' => 'success',
            'msg' => 'Wishlist removed successfully.'
        ]);
    } else {
        return response()->json([
            'type' => 'error',
            'msg' => 'Wishlist item not found.'
        ]);
    }
}



public function addReview(Request $request)
{
    $user_id = Auth::guard('customer')->user()?->id ?? null;
   
    // Save review directly
    Review::create([
        'rating' => $request->input('rating'),
        'review' => $request->input('review'),
        'product_id' => $request->input('product_id'),
         'user_id' => $user_id,
         'status' => '1',
         'order_id' => $request->input('order_id'),
        
       
    ]);

    return redirect()->back()->with('success', 'Review added successfully!');
}

public function validateQuantity(Request $request)
{
    $qty = $request->input('qty');
    $productId = $request->input('productId');
    $productVariantId = $request->input('productVariantId');

    if (!empty($productVariantId)) {
        $productVariant = Product_variants_values::find($productVariantId);

        if (!$productVariant) {
            return response()->json([
                'msg' => 'Product variant not found.',
                'type' => 'error',
                'title' => 'Error!',
            ]);
        }

        // Check if inventory tracking is disabled
        if ($productVariant->inventoryManagement !== 'Dont-track-inventory') {
            if ($qty > $productVariant->qty) {
                return response()->json([
                    'msg' => 'Your product quantity is greater than stock.',
                    'type' => 'warning',
                    'title' => 'Warning!',
                ]);
            }
        }
    } else {
        // Handle case for products without variants
        $product = Product::find($productId);

        if (!$product) {
            return response()->json([
                'msg' => 'Product not found.',
                'type' => 'error',
                'title' => 'Error!',
            ]);
        }

        if ($qty > $product->qty) {
            return response()->json([
                'msg' => 'Your product quantity is greater than stock.',
                'type' => 'warning',
                'title' => 'Warning!',
            ]);
        }
    }

    return response()->json([
        'msg' => 'Quantity validated successfully.',
        'type' => 'success',
        'title' => 'Success!',
    ]);
}


public function checkcoupnscode(Request $request)
{
    $coupnscode = $request->input('coupnscode');
    $product_ids = $request->input('product_ids');
    $shipping_amount = $request->input('shipping_amount');

    // Get the coupon data
    $coupnscodedata = Coupon::where('name', $coupnscode)->first();

    if (!$coupnscodedata) {
        return response()->json([
            'msg' => 'Coupon code not found',
            'type' => 'error',
            'title' => 'Error',
        ]);
    }

    // Check if the coupon is inactive or expired
    if ($coupnscodedata->status == 0 || strtotime($coupnscodedata->expire_date) < strtotime(date('Y-m-d'))) {
        return response()->json([
            'msg' => 'Coupon code has expired',
            'type' => 'error',
            'title' => 'Error',
        ]);
    }

    $couponOwner = $coupnscodedata->user_id;
    $coupnsprice = $coupnscodedata->discount; // Discount value
    $couponType = $coupnscodedata->type; // 'percent' or 'flat'

    // Get products by IDs
    $products = Product::whereIn('id', $product_ids)->get();

    $eligibleProducts = [];
    $totalOrderValue = 0; // Net order value after deductions

    foreach ($products as $product) {
        if ($product->created_by == $couponOwner) {
            $productPrice = is_null($product->price)
                ? Product_variants_values::where('product_id', $product->id)->where('status', 1)->first()->price ?? 0
                : $product->price;

            $productTaxPrice = $product->producttaxprice ?? 0;
            $otherDiscount = $product->discountamount ?? 0;
            
            // Calculate net product price
            $netProductPrice = max(0, $productPrice + $productTaxPrice - $otherDiscount);
            
            $eligibleProducts[] = [
                'product_id' => $product->id,
                'original_price' => $productPrice,
                'net_price' => $netProductPrice,
            ];

            $totalOrderValue += $netProductPrice;
        }
    }

    // Check if we should include shipping amount in the total order value
    if (setting('shipping_discount') == 1) {
        $totalOrderValue += $shipping_amount;


    }



    if (empty($eligibleProducts) || $totalOrderValue <= 0) {
        return response()->json([
            'msg' => 'No matching products found for the coupon or invalid net order value',
            'type' => 'error',
            'title' => 'Error',
        ]);
    }

    // Calculate total discount amount
    $totalDiscount = ($couponType == 'percent') 
        ? ($totalOrderValue * $coupnsprice) / 100 // Percentage discount
        : $coupnsprice; // Fixed discount

    // Ensure total discount does not exceed total order value
    $totalDiscount = min($totalDiscount, $totalOrderValue);

    // Calculate discount percentage relative to total order value
    $discountPercentage = ($totalDiscount / $totalOrderValue) * 100;

    $updatedProducts = [];

    foreach ($eligibleProducts as $product) {
        $productDiscountAmount = ($product['net_price'] * $discountPercentage) / 100;
        $discountedPrice = max(0, $product['net_price'] - $productDiscountAmount);

        $updatedProducts[] = [
            'product_id' => $product['product_id'],
            'original_price' => $product['original_price'],
            'net_price' => $product['net_price'],
            'discounted_price' => $discountedPrice,
            'discount_applied' => round($productDiscountAmount, 2),
        ];
    }
$discountPercentage = ($totalDiscount / $totalOrderValue) * 100;

    return response()->json([
        'msg' => 'Coupon applied successfully',
        'type' => 'success',
        'title' => 'Good job!',
        'updated_products' => $updatedProducts,
        'total_discount' => round($totalDiscount, 2),
    ]);
}



public function singlecheckcoupnscode(Request $request)
{
    $coupnscode = $request->input('coupnscode');
    $product_ids = $request->input('product_ids');
    $shipping_amount = $request->input('shipping_amount');

    $coupnscodedata = Coupon::where('name', $coupnscode)->first();

    if (!$coupnscodedata) {
        return response()->json([
            'msg' => 'Coupon code not found',
            'type' => 'error'
        ]);
    }

    if ($coupnscodedata->status == 0 || strtotime($coupnscodedata->expire_date) < strtotime(date('Y-m-d'))) {
        return response()->json([
            'msg' => 'Coupon code has expired',
            'type' => 'error'
        ]);
    }

    $couponOwner = $coupnscodedata->user_id;
    $coupnsprice = $coupnscodedata->discount;
    $couponType = $coupnscodedata->type;

    $products = Product::whereIn('id', $product_ids)->get();
    $eligibleProducts = [];
    $totalOrderValue = 0;

    foreach ($products as $product) {
        if ($product->created_by == $couponOwner) {
            $productPrice = $product->price ?? Product_variants_values::where('product_id', $product->id)->where('status', 1)->first()->price ?? 0;
            $productTaxPrice = $product->producttaxprice ?? 0;
            $otherDiscount = $product->discountamount ?? 0;
            $netProductPrice = max(0, $productPrice + $productTaxPrice - $otherDiscount);

            $eligibleProducts[] = [
                'product_id' => $product->id,
                'net_price' => $netProductPrice
            ];

            $totalOrderValue += $netProductPrice;
        }
    }

    if (empty($eligibleProducts) || $totalOrderValue <= 0) {
        return response()->json([
            'msg' => 'No eligible products found or invalid order value',
            'type' => 'error'
        ]);
    }

    $totalDiscount = ($couponType == 'percent') ? ($totalOrderValue * $coupnsprice) / 100 : $coupnsprice;
    $applyShippingDiscount = setting('shipping_discount') == 1;

    if ($totalDiscount >= $totalOrderValue) {
        $totalDiscount = $totalOrderValue;
        $finalAmount = 0;
        $shipping_amount = $applyShippingDiscount ? 0 : $shipping_amount;
    } else {
        $finalAmount = $totalOrderValue - $totalDiscount;
    }

    $finalAmountWithShipping = $finalAmount + ($shipping_amount != 0 ? $shipping_amount : 0);

    return response()->json([
        'msg' => 'Coupon applied successfully',
        'type' => 'success',
        'total_discount' => round($totalDiscount, 2),
        'final_amount' => round($applyShippingDiscount && $finalAmount == 0 ? 0 : $finalAmountWithShipping, 2),
        'shipping_total' => round($shipping_amount, 2)
    ]);
}





// public function checkcoupnscode(Request $request)
// {
//     $coupnscode = $request->input('coupnscode');
//     $product_ids = $request->input('product_ids');
//     $sumofgrandstotal = $request->input('sumofgrandstotal');
    
//     // Get the coupon data
//     $coupnscodedata = Coupon::where('name', $coupnscode)->first();

//     if (!$coupnscodedata) {
//         // Coupon not found, return error response
//         $response['msg'] = 'Coupon code not found';
//         $response['type'] = 'error';
//         $response['title'] = 'Error';
//         return response()->json($response);
//     }

//     // Get the coupon data
//     $coupnsuserid = $coupnscodedata->user_id;
//     $coupnsprice = $coupnscodedata->discount;

//     // Apply the coupon discount to the sum of the grand total
//     $finalAmount = $sumofgrandstotal - $coupnsprice;

//     // Ensure the final amount is not less than zero (optional, but a good practice)
//     if ($finalAmount < 0) {
//         $finalAmount = 0;
//     }

//     // Prepare the response
//     $response['msg'] = 'Coupon applied successfully';
//     $response['type'] = 'success';
//     $response['title'] = 'Good job!';
//     $response['final_amount'] = $finalAmount;  // Final total after discount
//     $response['discount'] = $coupnsprice;  // The discount applied

//     return response()->json($response);
// }


 public function setLanguage(Request $request){
     
        $post = $request->all();
        if (array_key_exists($post['lang'], Config::get('languages'))) {
            if (isset($post['lang'])) {
              
                App::setLocale($post['lang']);
                Session::put('website_locale', $post['lang']);
                setcookie('website_lang_code',$post['lang'],time()+60*60*24*365);
            }
        }
        return redirect()->back();
    }

public function checkout2()
    {
        return view('website.checkout2');
    }



  public function createPaymentIntent(Request $request)
    {
        $stripeSecret = 'sk_test_51OhmuuJYPu5h8N8fTVUkRbdwcS8LMurgLTrNqZfZEv8E6FPJ3C0m7k2KndNESyRXkvOe9eDH0eH8JHE1yp3MIqxb00CzZTLenl';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $stripeSecret,
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])->post('https://api.stripe.com/v1/payment_intents', [
            'amount' => $request->amount * 100, // Convert to cents
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);

        return response()->json($response->json());
    }
}
