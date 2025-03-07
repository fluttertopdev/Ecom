<?php

namespace App\Models; 


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use Auth;
class Cart extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "carts";


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    
      public function productVariants()
    {
        return $this->hasMany(Product_variants_values::class, 'product_id', 'product_id');
    }
    
     public function taxrate()
    {
        return $this->hasOne(Taxrate::class, 'product_id', 'product_id');
    }

// public static function cartgetlist()
// {
//     try {
//          $user_id = Auth::guard('customer')->user()?->id ?? null;
//         // Fetch cart items with related models
//         $data = Cart::with(['productVariants', 'product', 'taxrate'])
//                     ->where('user_id', $user_id) // Replace with dynamic user_id if needed
//                     ->paginate(config('constant.paginate.num_per_page'));

//         // Add product image and price to each cart row
//         if ($data->count()) {
//             foreach ($data as $row) {
//                 if ($row->variants_id) {
//                     // Fetch details from ProductVariant if variant_id exists
//                     $variant = Product_variants_values::where('id', $row->variants_id)->first();
                    
//                     $row->product_price = $variant ? $variant->price : 0;
                    
    

//                     // Extract first image from comma-separated variant images
//                     if ($variant && $variant->images) {
//                         $variantImages = explode(',', $variant->images);
//                         $row->product_image = !empty($variantImages[0]) ? 'uploads/' . trim($variantImages[0]) : "";
//                     } else {
//                         $row->product_image = "";
//                     }
//                 } else {
//                     // Fetch details from Product if no variant_id
//                     $product_image = ProductImages::where('product_id', $row->product_id)
//                                                   ->where('is_default', '1')
//                                                   ->first();
//                     $row->product_price = $row->product ? $row->product->price : 0;
//                     $row->product_image = $product_image ? 'uploads/product/' . $product_image->image : "";
//                 }
//             }
//         }

//         return $data;
//     } catch (\Exception $e) {
//         return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
//     }
// }



public static function cartgetlist(Request $request)
{
    try {
        $user_id = Auth::guard('customer')->user()?->id ?? null;
        $ipaddressid = session()->getId();
  
        // Fetch cart items based on user_id if logged in, otherwise based on ipaddressid
        $query = Cart::with(['productVariants', 'product.taxrates']);

        if ($user_id) {
            $query->where('user_id', $user_id);
        } else {
            $query->where('user_id', null)->where('session_id', $ipaddressid);
        }

        $data = $query->get();  // Fetch collection of data

        foreach ($data as $row) {
            if ($row->variants_id) {
                $variant = Product_variants_values::where('id', $row->variants_id)->first();
                if ($variant) {
                    $row->product_price = $variant->price ?? 0;
                    $row->sku = $variant->sku ?? null;
                    $variantImages = explode(',', $variant->images);
                    $row->product_image = !empty($variantImages[0]) ? 'uploads/' . trim($variantImages[0]) : "";
                }
            } else {
                $product_image = ProductImages::where('product_id', $row->product_id)
                                              ->where('is_default', '1')
                                              ->first();
                $row->product_price = $row->product ? $row->product->price : 0;
                $row->producttaxprice = $row->product ? $row->product->producttaxprice : 0;
                
                 $row->discountamount = $row->product ? $row->product->discountamount : 0;
                $row->product_image = $product_image ? 'uploads/product/' . $product_image->image : "";
            }

            // Calculate Discount
            $productdiscountamount = $row->product_price * ($row->product->discount / 100);
            $row->price_after_discount = $row->product_price - $productdiscountamount;

            // Calculate Tax
            $totalTax = 0;
            if ($row->product && $row->product->taxrates) {
                foreach ($row->product->taxrates as $taxRate) {
                    if ($taxRate->ratetype === 'percentage') {
                        $totalTax += ($row->price_after_discount * $taxRate->rate) / 100;
                    } elseif ($taxRate->ratetype === 'flat') {
                        $totalTax += $taxRate->rate;
                    }
                }
            }

            $row->total_tax = $totalTax;
        }

        return $data; // Returning collection
    } catch (\Exception $e) {
        return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
    }
}





   
  



  


}
