<?php

namespace App\Http\Controllers\Sellers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\ProductImages;
use App\Models\Productattribute;
use App\Models\Product_variants;
use App\Models\Product_variants_values;
use App\Models\VariantImage;
use App\Models\Attribute;
use App\Models\Tax;
use App\Models\Taxrate;
use App\Models\Banner;
use Auth;
use DB;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Str;
use Session;
use Illuminate\Support\Facades\Storage;
use App\Helpers;

class SellerproductController extends Controller
{
    
    
   
     public function index(Request $request)
    {  
           
         
         
        try{
            $data['categories'] = Category::where('status', 1)->get();
             $data['brand'] = Brand::where('status', 1)->get();
            $data['result'] = Product::sellersproductgetLists($request->all());

            $data['statusTypes'] = \Helpers::getStatusType();
          
            return view('sellers.sellersproduct.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

     public function sellerproduct_create(Request $request)
    { 

     
       $categories = Category::where('status', 1)->get();
      $taxes = Tax::where('status', 1)->get();
       $brand = Brand::where('status', 1)->get();
        $attribute = Attribute::all();

        return view('sellers.sellersproduct.addproduct',compact('categories','brand','attribute','taxes'));
    }


public function sellerproductstore(Request $request)
{
   
    



    $input = $request->except('image');
    $rates = $request->input('rate');
    $ratetypes = $request->input('ratetype');
    $taxIds = $request->input('tax_id');
    $producttype = $request->input('producttype');
      $productPrice = $request->input('price');
     $discount = $request->input('discount');
     $unique_id = $request->input('unique_id');
    $originalTime = $request->created_at;
    $date = new DateTime($originalTime, new DateTimeZone('UTC'));
    $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
    $input['created_at'] = $date->format('d-m-Y H:i:s');
    $input['slug'] = Str::slug($request->name);

      // Ensure discount is always calculated properly
    if ($discount == 0 || $discount === null) {
        $discountAmount = 0;
        $discountedPrice = $productPrice;
    } else {
        $discountAmount = ($productPrice * $discount) / 100;
        
    }
    
    $input['discount'] = $discount; // Save discounted price
      $input['discountamount'] = $discountAmount; // Save discounted price
     $priceafterdiscount=$productPrice-$discountAmount;
        // Calculate total tax amount
    $totalTaxAmount = 0;
    foreach ($taxIds as $index => $taxId) {
        $rate = $rates[$index];
        $rateType = $ratetypes[$index];
        
        if ($rateType == 'percentage') {
            $totalTaxAmount += ($priceafterdiscount * $rate) / 100;
        } else {
            $totalTaxAmount += $rate;
        }
    }
    
     // Final price after adding tax
    $finalPriceAfterTax = $priceafterdiscount + $totalTaxAmount;
    $input['producttaxprice'] = $totalTaxAmount;
    $product = Product::create($input);
     $lastinsertId = $product->id;

    $activevarients = Product_variants_values::where('unique_id', $unique_id)
    ->where('status', 1)
    ->first();
     
     if ($activevarients) {
    $price = $activevarients->price; 
    $variant_id = $activevarients->id;
    // Update the Product with the price
    $product->update([
        'price' => $price,
        'variant_id' => $variant_id
    ]);
}
     
    foreach ($taxIds as $index => $taxId) {
        // Assuming you have a model called TaxRate
        TaxRate::create([
            'tax_id' => $taxId,
             'product_id' => $product->id,
            'rate' => $rates[$index],
            'ratetype' => $ratetypes[$index],
        ]);
    }
   
 
 
  
  // Insert multiple attribute values
    foreach ($request->attributes_id as $key => $attributeId) {
        if (!empty($attributeId) && !empty($request->attributes_value[$key])) {
            ProductAttribute::create([
                'product_id' => $product->id,
                'attributes_id' => $attributeId,
                'attributes_value' => $request->attributes_value[$key]
            ]);
        }
    }


  


$variants = Product_variants::where('unique_id', $request->input('unique_id'))->get();
$ProductImages = ProductImages::where('uniqueId', $request->input('unique_id'))->get();

$variantsvalues = Product_variants_values::where('unique_id', $request->input('unique_id'))->get();

foreach ($variants as $variantData) {
    // Only update existing ProductVariantValue records based on product_id
    Product_variants::where('unique_id', $request->unique_id)
        ->update([
            
            'product_id' => $lastinsertId, 
        ]);
}

foreach ($ProductImages as $ProductImagesData) {
    
    ProductImages::where('uniqueId', $request->unique_id)
        ->update([
            
            'product_id' => $lastinsertId, 
        ]);
}

foreach ($variantsvalues as $variantDatavales) {
    // Only update existing ProductVariantValue records based on product_id
    Product_variants_values::where('unique_id', $request->unique_id)
        ->update([
            
            'product_id' => $lastinsertId, 
        ]);
}

    // Flash success message and redirect
    Session::flash('success', 'Product created successfully!');
 
    return redirect('sellersproducts')->with('success', 'Product created successfully.');
    
  

}


 
   public function sellereditproduct($id)
    { 

     
       $categories = Category::where('status', 1)->get();
      $subcategories = Subcategory::all();
       $products = Product::where('id', $id)->first();
       $brand = Brand::where('status', 1)->get();
       $taxes = Taxrate::join('taxes', 'taxrates.tax_id', '=', 'taxes.id')
    ->where('taxrates.product_id', $id)
    ->select('taxrates.*', 'taxes.name as tax_name') 
    ->get();

     $taxRates = Taxrate::where('product_id', $id)->get()->keyBy('tax_id');
   $finalProductPrice = Taxrate::join('products', 'taxrates.product_id', '=', 'products.id')
    ->where('taxrates.product_id', $id)
    ->select('taxrates.*', 'products.price as base_price') 
    ->get();

$totalTax = 0;
$basePrice = 0;

// Calculate total tax based on rate type
foreach ($finalProductPrice as $tax) {
    if ($tax->ratetype === 'flat') {
        // Add flat tax value directly
        $totalTax += $tax->rate;
    } elseif ($tax->ratetype === 'percentage') {
        // Calculate percentage of the base price
        $percentageValue = ($tax->rate / 100) * $tax->base_price;
        $totalTax += $percentageValue;
    }

   
    if ($basePrice === 0) {
        $basePrice = $tax->base_price;
    }
}


$finalPrice = $basePrice + $totalTax;


    

      $attributes = ProductAttribute::where('product_id', $id)->get(); 
    $attributeOptions = Attribute::all();
      $productsimages = ProductImages::where('product_id', $id)->get();
     $product_variant = Product_variants::where('product_id', $id)->get();


        return view('sellers.sellersproduct.editproduct',compact('categories','brand','attributes','products','subcategories','productsimages','attributeOptions','product_variant','taxes','taxRates','finalPrice'));
    }


      
public function sellerproductupdate(Request $request)
{
      
     
    $Productid = $request->product_id;

    $producttype = $request->input('producttype');
      $rates = $request->input('rate');
    $ratetypes = $request->input('ratetype');
    $taxIds = $request->input('tax_id');
    $productPrice = $request->input('price');
     $discount = $request->input('discount');

    // Fetch the existing product by ID
    $product = Product::find($Productid);

      // Ensure discount is always calculated properly
    if ($discount == 0 || $discount === null) {
        $discountAmount = 0;
        $discountedPrice = $productPrice;
    } else {
        $discountAmount = ($productPrice * $discount) / 100;
        
    }
    
     $input['discount'] = $discount; // Save discounted price
      $input['discountamount'] = $discountAmount;
    $priceafterdiscount=$productPrice-$discountAmount;
   $totalTaxAmount = 0;
    foreach ($taxIds as $index => $taxId) {
        $rate = $rates[$index];
        $rateType = $ratetypes[$index];
        
        if ($rateType == 'percentage') {
            $totalTaxAmount += ($priceafterdiscount * $rate) / 100;
        } else {
            $totalTaxAmount += $rate;
        }
    }
    // Exclude 'image' from input and prepare other fields for updating
    $input = $request->except('image');

    // Update 'created_at' with timezone conversion
    $input['producttaxprice'] = $totalTaxAmount;
    $originalTime = $request->created_at;
    $date = new DateTime($originalTime, new DateTimeZone('UTC'));
    $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
    $input['created_at'] = $date->format('d-m-Y H:i:s');

    // Update the slug based on the product name
    $input['slug'] = Str::slug($request->name);

    // Update the product details in the database
    
    
    $product->update($input);
    
    $activevarients = Product_variants_values::where('unique_id', $request->unique_id)
    ->where('status', 1)
    ->first();
     
     if ($activevarients) {
    $price = $activevarients->price; 
    $variant_id = $activevarients->id;
    // Update the Product with the price
    $product->update([
        'price' => $price,
        'variant_id' => $variant_id
    ]);
}

    // Handle image uploads and update images
    if ($request->hasFile('image')) {
        // First, delete old images associated with the product
        $imagename=ProductImages::where('product_id', $Productid)->pluck('image')->toArray();
        $isdefultimage=1;
        ProductImages::where('product_id', $Productid)->delete();
  
        // Insert the new uploaded images
        foreach ($request->file('image') as $image) {
            $uploadImage = \Helpers::uploadFiles($image, 'product/');
            if ($uploadImage['status'] == true) {
                $isdefult=$isdefultimage==1? 1:0;
                ProductImages::create([
                    'product_id' => $Productid,
                    'image' => $uploadImage['file_name'],
                    'is_default'=>$isdefult,
                ]);

                $isdefultimage++;
            }
        }

          foreach ($imagename as $image) {
         
          
                ProductImages::create([
                    'product_id' => $Productid,
                    'image' => $image,
                ]);
            
        }
    }
    
    
    
    

    // Update attributes
    ProductAttribute::where('product_id', $Productid)->delete(); // Remove old attributes

    // Insert new attribute values
    foreach ($request->attributes_id as $key => $attributeId) {
        if (!empty($attributeId) && !empty($request->attributes_value[$key])) {
            ProductAttribute::create([
                'product_id' => $Productid,
                'attributes_id' => $attributeId,
                'attributes_value' => $request->attributes_value[$key]
            ]);
        }
    }


  $taxrate=TaxRate::where('product_id', $Productid)->delete();


      foreach ($taxIds as $index => $taxId) {
        // Assuming you have a model called TaxRate
        TaxRate::create([
            'tax_id' => $taxId,
             'product_id' => $Productid,
            'rate' => $rates[$index],
            'ratetype' => $ratetypes[$index],
        ]);
    }

    // Flash success message and redirect
    Session::flash('success', 'Product updated successfully!');

  
    return redirect('sellersproducts')->with('success', 'Product updated successfully.');
    
    
}
   
     public function sellerupdateIsFeaturedColumn($id)
    {
        try{
            $updated = Product::sellerupdateFeaturedColumn($id);
            if($updated['status']==true){
                return redirect()->back()->with('success', $updated['message']); 
            }
            else{
                return redirect()->back()->with('error', $updated['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }
 

   public function sellersupdateColumn($id)
    {
        try{
            $updated = Product::sellersupdateColumn($id);
            if($updated['status']==true){
                return redirect()->back()->with('success', $updated['message']); 
            }
            else{
                return redirect()->back()->with('error', $updated['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }


public function sellerexportAllOrders(Request $request)
{
    // Build the query
      $userid = Auth::guard('seller')->user()?->id ?? null;
      
    $query = Product::query()
        ->leftJoin('product_variant_values', function ($join) {
            $join->on('products.id', '=', 'product_variant_values.product_id')
                 ->where('product_variant_values.status', '=', 1);
                 
        })
        
         ->leftJoin('categories', 'products.categories_id', '=', 'categories.id')
        ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
        ->select(
            'products.id',
            'products.name',
            'products.status',
            'products.is_featured',
             'products.created_at',
            'categories.name as category_name',
            'brands.name as brand_name',
            DB::raw('IF(products.price IS NULL OR products.price = 0, product_variant_values.specialprice, products.price) as price')
        )
        ->where('products.created_by', $userid);
      
    // Fetch the filtered data
    $products = $query->get();
    
   

    // Return the data as JSON
    return response()->json($products);
}





}
