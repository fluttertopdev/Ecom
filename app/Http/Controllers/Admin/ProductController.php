<?php

namespace App\Http\Controllers\Admin;


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
use App\Models\Visibilitie;
use App\Models\Language;
use App\Models\ProductTranslation;
use DB;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Str;
use Session;
use Illuminate\Support\Facades\Storage;
use App\Helpers;



class ProductController extends Controller
{
    
    public function index(Request $request)
    {
    
        try{
            $data['result'] = Product::getLists($request->all());


             $data['categories'] = Category::where('status', 1)->get();
              $data['brand'] = Brand::where('status', 1)->get();

         
            $data['statusTypes'] = \Helpers::getStatusType();

            return view('admin.products.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }


 



   
    public function create(Request $request)
    { 

      $product_tag = Visibilitie::where('status', 1)->get();
       $categories = Category::where('status', 1)->get();
      $taxes = Tax::where('status', 1)->get();
       $brand = Brand::where('status', 1)->get();
        $attribute = Attribute::all();

        return view('admin.products.addproduct',compact('categories','brand','attribute','taxes','product_tag'));
    }


   






public function store(Request $request)
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

    // Validation: Ensure discount price is less than the product price after tax
    // if ($discountAmount >= $finalPriceAfterTax) {
        
       

    //      return redirect('admin/product-create')->with('error', 'discount cannot be greater than or equal to the price.');
    // }
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
    if($producttype=='admin'){
 return redirect('admin/products')->with('success', 'Product created successfully.');
    }else{
    return redirect('sellers-products')->with('success', 'Product created successfully.');
    }
  

}



  





     public function editproduct($id)
    { 

     
       $categories = Category::where('status', 1)->get();
      $subcategories = Subcategory::all();
       $products = Product::where('id', $id)->first();
       
      
       $brand = Brand::where('status', 1)->get();
        $product_tag = Visibilitie::where('status', 1)->get();
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

   
    
}




    

      $attributes = ProductAttribute::where('product_id', $id)->get(); 
    $attributeOptions = Attribute::all();
      $productsimages = ProductImages::where('product_id', $id)->get();
     $product_variant = Product_variants::where('product_id', $id)->get();


        return view('admin.products.editproduct',compact('categories','brand','attributes','products','subcategories','productsimages','attributeOptions','product_variant','taxes','taxRates','product_tag'));
    }


public function productupdate(Request $request)
{
      
      
     
    $Productid = $request->product_id;

    $producttype = $request->input('producttype');

        $productPrice = $request->input('price');
     $discount = $request->input('discount');
      $rates = $request->input('rate');
    $ratetypes = $request->input('ratetype');
    $taxIds = $request->input('tax_id');
    
    // Fetch the existing product by ID
    $product = Product::find($Productid);
  // Exclude 'image' from input and prepare other fields for updating
    $input = $request->except('image');
    if (!$product) {
        // If the product doesn't exist, handle the error
        Session::flash('error', 'Product not found!');
        return redirect('admin/products')->with('error', 'Product not found.');
    }
    
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

    // Validation: Ensure discount price is less than the product price after tax
    // if ($discountAmount >= $finalPriceAfterTax) {
        
       

    //      return redirect('admin/products')->with('error', 'discount cannot be greater than or equal to the price.');
    // }
    

 
  $input['producttaxprice'] = $totalTaxAmount; // Save discounted price
    // Update 'created_at' with timezone conversion
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

   if($producttype=='admin'){
 return redirect('admin/products')->with('success', 'Product updated successfully.');
    }else{
    return redirect('admin/sellers-products')->with('success', 'Product updated successfully.');
    }
    
}


public function deleteProductImage(Request $request)
{
    $imageId = $request->input('image_id');
    $imageproductid = $request->input('imageproductid');

    // Find the image in the database
    $productImage = ProductImages::find($imageId);

    if (!$productImage) {
        return response()->json(['success' => false, 'message' => 'Image not found.']);
    }

    // Check if the image is the default one
    $isDefault = $productImage->is_default == 1;

    // Delete the image file from the server
    $imagePath = public_path('uploads/product/' . $productImage->image);
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Delete the record from the database
    $productImage->delete();

    // If the deleted image was default, set another image as default
    if ($isDefault) {
        $newDefaultImage = ProductImages::where('product_id', $imageproductid)->first();
        if ($newDefaultImage) {
            $newDefaultImage->is_default = 1;
            $newDefaultImage->save();
        }
    }

    return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
}


 public function getProductVariants($id)
{
    $variants = Product_variants::where('product_id', $id)->get();

    if ($variants->isEmpty()) {
        return response()->json(['message' => 'No variants found'], 404);
    }

   $formattedVariants = $variants->groupBy('name')->map(function($group) {
    // Assuming 'name' and 'type' are the same for all entries in the group
    $firstVariant = $group->first();
    
    return [
        'name' => $firstVariant->name,
        'type' => $firstVariant->type,
        'textInputs' => $group->filter(function($variant) {
            return !is_null($variant->text_inputs);
        })->pluck('text_inputs')->toArray(), 

          'colorInputs' => $group->filter(function($variant) {
            return !is_null($variant->color_inputs);
        })->pluck('color_inputs')->toArray()

        
    ];
});


    return response()->json(['variants' => $formattedVariants], 200);
}


 public function multiDelete(Request $request)
    {
        
        
       
        Product::whereIn('id', $request->products_ids)->update(['deleted_at' => now()]);

        
         return response()->json(['success' =>true, 'product deleted successfully.']);
    }


   public function destroy($id)
    {
        try{
            $deleted = Product::deleteRecord($id);
            
            if($deleted['status']==true){
                return redirect()->back()->with('success', $deleted['message']); 
            }
            else{
                return redirect()->back()->with('error', $deleted['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }





    public function updateColumn($id)
    {
        try{
            $updated = Product::updateColumn($id);
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


    
    public function updateFeaturedColumn($id)
    {
        try{
            $updated = Product::updateFeaturedColumn($id);
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

      public function updatebest_sellerColumn($id)
    {
        try{
            $updated = Product::updatebestsellerColumn($id);
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

  public function categorychange(Request $request)
{
 
    $categoryId = $request->input('category_id');

     
   
     $subcategorycategory = Subcategory::where('category_id', $categoryId)->get();

   

    // Return a response if needed
    return response()->json([
        'success' => true,
        'category' => $subcategorycategory
    ]);
}














public function genratevriant(Request $request)
    {

         
        // Validate incoming request data
        $request->validate([
            'variants' => 'required|array',
            'variants.*.name' => 'required|string',
            'variants.*.type' => 'required|string|in:Text,Colors',
            'variants.*.textInputs' => 'array|nullable',
            'variants.*.colorInputs' => 'array|nullable',
            'variants.*.colorInputs.*.additionalInput' => 'nullable|string',
            'variants.*.colorInputs.*.colorCode' => 'nullable|string',
        ]);
     
       
        $variants = $request->input('variants', []);

  

    // Get the unique ID from the first variant (assuming all have the same unique_id)
    $uniqueId = $variants[0]['unique_id'] ?? null;
     
    if ($uniqueId) {
        // Delete existing variants with the same unique_id
        Product_variants::where('unique_id', $uniqueId)->delete();
    }
        // Iterate through the variants and insert into the database
        foreach ($request->input('variants') as $variant) {


          $textInputs = $variant['type'] == 'Text' ? (isset($variant['textInputs']) ? $variant['textInputs'] : []) : [];
          $colorInputs = $variant['type'] == 'Colors' ? (isset($variant['colorInputs']) ? $variant['colorInputs'] : []) : [];
            
            // This is for color
            foreach($textInputs as $row){

              Product_variants::create([
                  'name' => $variant['name'],
                  'type' => $variant['type'],
                  'text_inputs' => $row,
                  'unique_id' => $variant['unique_id'],
                  
              ]);

            }


            foreach($colorInputs as $row){

              Product_variants::create([
                  'name' => $variant['name'],
                  'type' => $variant['type'],
                  'text_inputs' => $row['additionalInput'],
                  'color_inputs' => $row['colorCode'],
                  'unique_id' => $variant['unique_id'],
                  
              ]);

            }

              
        }

        // Return a response
        return response()->json(['message' => 'Variants generated successfully!'], 200);
    
}




public function feachvriant(Request $request)
{
    $variants = Product_variants::where('unique_id', $request->input('unique_id'))->get();
    $variantsvalues = Product_variants_values::where('unique_id', $request->input('unique_id'))->get();

    if ($variants->isEmpty()) {
        return response()->json(['message' => 'No variants found'], 404);
    }

    $variantGroups = [];
    $variantCount = 0;
    $totalVariants = $variants->count();
    $variantTypes = 2;
    $variantsPerType = ceil($totalVariants / $variantTypes);

    foreach ($variants as $variant) {
        $textInput = $variant->text_inputs;
        $typeIndex = floor($variantCount / $variantsPerType);

        if (!isset($variantGroups[$typeIndex])) {
            $variantGroups[$typeIndex] = [];
        }
        $variantGroups[$typeIndex][] = $textInput;

        $variantCount++;
    }

    if (empty($variantGroups)) {
        return response()->json(['message' => 'No variant types found'], 400);
    }

    $combinations = $this->generateCombinations($variantGroups);

    $options = [];
    foreach ($combinations as $combination) {
        $options[] = implode(' / ', $combination);
    }

    $variantsValuesArray = $variantsvalues->map(function ($value) {
        // Concatenate the base URL with each image path
        $images = $value->images ? array_map(function($img) {
            return asset('uploads/' . $img);
        }, explode(',', $value->images)) : [];

        return [
            'sku' => $value->sku,
            'price' => $value->price,
            'special_price' => $value->specialprice,
            'stock_availability' => $value->stockavailability,
            'special_price_start' => $value->specialricestart,
            'special_price_end' => $value->specialpriceend,
            'inventory_management' => $value->inventoryManagement,
            'qty' => $value->qty,
            'isdefault' => $value->isdefault,
            'status' => $value->status,
            'images' => implode(',', $images) // Convert array back to a comma-separated string
        ];
    });

    return response()->json([
        'variants' => $options,
        'variantsValues' => $variantsValuesArray
    ]);
}









private function generateCombinations(array $arrays)
{
    $result = [[]];

    foreach ($arrays as $propertyValues) {
        $temp = [];
        foreach ($result as $combination) {
            foreach ($propertyValues as $value) {
                $temp[] = array_merge($combination, [$value]);
            }
        }
        $result = $temp;
    }

    return $result;
}





public function savevriant(Request $request)
{
    $uniqueId = $request->input('unique_id');
    $variants = $request->input('variants');

    foreach ($variants as $index => $variantData) {
        // Remove spaces and slashes from the 'variant' value
        $cleanedVariant = str_replace([' ', '/'], '', $variantData['variant']);

        // Create or update the ProductVariantValue record with cleaned variant data
        $productVariantValue = Product_variants_values::create([
            'unique_id' => $uniqueId,
             'variant' => $variantData['variant'],
            'combinevariant' => $cleanedVariant, // Save cleaned variant to 'combinevariant' column
         
            'price' => $variantData['price'] ?? null,
          
            'stockavailability' => $variantData['stockAvailability'] ?? null,
          
    
            'isdefault' => $variantData['isDefault'] ?? false,
            'status' => $variantData['status'] ?? false,
            'inventoryManagement' => $variantData['inventoryManagement'] ?? null,
            'qty' => $variantData['qty'] ?? null,
        ]);

        // Handle image uploads and store as a comma-separated string
        if ($request->hasFile("variants.$index.images")) {
            $imagePaths = []; // Array to hold image paths
            $destinationPath = public_path('uploads/variant_images'); // Define the public folder path

            foreach ($request->file("variants.$index.images") as $image) {
                // Define a unique filename based on the current timestamp and the original name
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                // Move the uploaded image to the public folder
                $image->move($destinationPath, $imageName);
                $imagePaths[] = 'variant_images/' . $imageName; // Add the relative path to the array
            }

            // Convert the image paths array to a comma-separated string and save it
            $productVariantValue->images = implode(',', $imagePaths);
            $productVariantValue->save(); // Save after updating the image paths
        }
    }

    return response()->json(['success' => true, 'message' => 'Variants saved successfully.']);
}









public function uploadVariantImages(Request $request)
{
    

    // Validate images
    $request->validate([
        'images.*' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $variant = $request->variant; // Variant info
    $unique_id = $request->unique_id;
     $product_unique_id = $request->product_unique_id;



     

    $uploadedImages = [];

    if ($request->hasfile('images')) {
        foreach ($request->file('images') as $image) {
            $name = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('variant_images', $name, 'public');
            // Store image path to the database
            $uploadedImages[] = $path;

            VariantImage::create([
                'unique_id' => $unique_id,
                'product_unique_id' => $product_unique_id,
                'image_path' => $path
            ]);
        }
    }

    return response()->json([
        'message' => 'Images uploaded successfully',
        'images' => $uploadedImages
    ]);
}



public function updategenratevriant(Request $request)
{
    // Retrieve the 'variants' from the request
    $variants = $request->input('variants', []);

    // Check if there are any variants to process
    if (empty($variants)) {
        return response()->json(['message' => 'No variants provided.'], 400);
    }

    // Get the unique ID from the first variant (assuming all have the same unique_id)
    $uniqueId = $variants[0]['unique_id'] ?? null;

    if ($uniqueId) {
        // Delete existing variants with the same unique_id
        Product_variants::where('unique_id', $uniqueId)->delete();
    }

    // Iterate through the variants and insert into the database
    foreach ($variants as $variant) {
        // Check the variant type and extract corresponding inputs
        $textInputs = [];
        $colorInputs = [];

        // Extract inputs based on the type
        if (isset($variant['type'])) {
            if ($variant['type'] === 'Text') {
                $textInputs = $variant['textInputs'];
            } elseif ($variant['type'] === 'Colors') {
                $colorInputs = $variant['colorInputs'];
            }
        }

        // Insert text inputs into the database
        foreach ($textInputs as $textInput) {
            Product_variants::create([
                'name' => $variant['name'],
                'type' => $variant['type'],
                'text_inputs' => $textInput,
                'unique_id' => $variant['unique_id'],
                'product_id' => $variant['productId']

                
            ]);
        }

        // Insert color inputs into the database
        foreach ($colorInputs as $colorInput) {
            Product_variants::create([
                'name' => $variant['name'],
                'type' => $variant['type'],
                'text_inputs' => $colorInput['additionalInput'], // Store additional input as text input
                'color_inputs' => $colorInput['colorCode'], // Store color code
                'unique_id' => $variant['unique_id'],
                'product_id' => $variant['productId']
            ]);
        }
    }

    // Return a response
    return response()->json(['message' => 'Variants generated successfully!'], 200);
}






// public function updatevriant(Request $request)
// {  

     
//     $uniqueId = $request->input('unique_id');

//     $variants = $request->input('variants');
//       $productId = $request->input('productId');
     
     
//     Product_variants_values::where('unique_id', $uniqueId)->delete();
    
//     foreach ($variants as $index => $variantData) {
//          $cleanedVariant = str_replace([' ', '/'], '', $variantData['variant']);

        
//         // Create or update the ProductVariantValue record
//         $productVariantValue = Product_variants_values::create([
//             'unique_id' => $uniqueId,
//             'product_id' => $productId,
//             'variant' => $variantData['variant'],
//              'combinevariant' => $cleanedVariant,
          
//             'price' => $variantData['price'] ?? null,
          
//             'stockavailability' => $variantData['stockAvailability'] ?? null,
           
          
//             'isdefault' => $variantData['isDefault'] ?? false,
//             'status' => $variantData['status'] ?? false,
//             'inventoryManagement' => $variantData['inventoryManagement'] ?? null,
//             'qty' => $variantData['qty'] ?? null,
//         ]);

//         // Handle image uploads and store as a comma-separated string
//         if ($request->hasFile("variants.$index.images")) {
//             $imagePaths = []; // Array to hold image paths
//             $destinationPath = public_path('uploads/variant_images'); // Define the public folder path

//             foreach ($request->file("variants.$index.images") as $image) {
//                 // Define a unique filename based on the current timestamp and the original name
//                 $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
//                 // Move the uploaded image to the public folder
//                 $image->move($destinationPath, $imageName);
//                 $imagePaths[] = 'variant_images/' . $imageName; // Add the relative path to the array
//             }

//             // Convert the image paths array to a comma-separated string and save it
//             $productVariantValue->images = implode(',', $imagePaths);
//             $productVariantValue->save(); // Save after updating the image paths
//         }
//     }

//     return response()->json(['success' => true, 'message' => 'Variants saved successfully.']);
// }

public function updatevriant(Request $request)
{  
    $uniqueId = $request->input('unique_id');
    $productId = $request->input('productId');
    $variants = $request->input('variants');

    // Retrieve existing images before deleting records
    $existingVariants = Product_variants_values::where('unique_id', $uniqueId)->get();
    $existingImages = [];

    foreach ($existingVariants as $variant) {
        if (!empty($variant->images)) {
            $existingImages[$variant->variant] = explode(',', $variant->images);
        }
    }

    // Delete old records
    Product_variants_values::where('unique_id', $uniqueId)->delete();

    foreach ($variants as $index => $variantData) {
        $cleanedVariant = str_replace([' ', '/'], '', $variantData['variant']);

        // Check for existing images of this variant
        $mergedImages = $existingImages[$variantData['variant']] ?? [];

        // Handle new image uploads
        if ($request->hasFile("variants.$index.images")) {
            $destinationPath = public_path('uploads/variant_images');

            foreach ($request->file("variants.$index.images") as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $imageName);
                $mergedImages[] = 'variant_images/' . $imageName;
            }
        }

        // Convert array to a string to store in the database
        $imageString = !empty($mergedImages) ? implode(',', $mergedImages) : null;

        // Create a new product variant value entry
        Product_variants_values::create([
            'unique_id' => $uniqueId,
            'product_id' => $productId,
            'variant' => $variantData['variant'],
            'combinevariant' => $cleanedVariant,
            'price' => $variantData['price'] ?? null,
            'stockavailability' => $variantData['stockAvailability'] ?? null,
            'isdefault' => $variantData['isDefault'] ?? false,
            'status' => $variantData['status'] ?? false,
            'inventoryManagement' => $variantData['inventoryManagement'] ?? null,
            'qty' => $variantData['qty'] ?? null,
            'images' => $imageString, // Store images correctly in the database
        ]);
    }

    return response()->json(['success' => true, 'message' => 'Variants saved successfully.']);
}


public function deleteVariantImage(Request $request)
{
    $variantId = $request->variant_id;
    
    
    $imageName = $request->image_name;
    print_r($variantId);
    die();
    // Find the variant record
    $variant = Variant::find($variantId);

    if (!$variant || !$variant->product_images) {
        return response()->json(['message' => 'Variant or image not found'], 404);
    }

    // Convert comma-separated images into an array
    $images = explode(',', $variant->product_images);

    // Check if the image exists in the array
    if (!in_array($imageName, $images)) {
        return response()->json(['message' => 'Image not found in record'], 404);
    }

    // Remove the image from the array
    $updatedImages = array_filter($images, function ($img) use ($imageName) {
        return $img !== $imageName;
    });

    // Define image storage path
    $imagePath = 'uploads/variants/' . $imageName;

    // Check if file exists and delete
    if (Storage::exists($imagePath)) {
        Storage::delete($imagePath);
    }

    // Update the database with the new comma-separated string
    $variant->product_images = implode(',', $updatedImages);
    $variant->save();

    return response()->json(['message' => 'Image deleted successfully']);
}



public function uploadproductImages(Request $request)
{
    $uniqueId = $request->input('unique_id');

    // Check if any default image already exists for this unique ID
    $hasDefaultImage = ProductImages::where('uniqueId', $uniqueId)->where('is_default', 1)->exists();

    if ($request->hasFile('image')) {
        $firstImage = true; // Flag to track the first image in the batch

        foreach ($request->file('image') as $image) {
            $uploadImage = \Helpers::uploadFiles($image, 'product/');

            if ($uploadImage['status'] == true) {
                // Set the first uploaded image as default if no default image exists
                $isDefault = (!$hasDefaultImage && $firstImage) ? 1 : 0;

                ProductImages::create([
                    'image' => $uploadImage['file_name'],
                    'uniqueId' => $uniqueId,
                    'is_default' => $isDefault
                ]);

                $firstImage = false; // After the first image, all others will have is_default = 0
            }
        }

        return response()->json(['success' => true, 'message' => 'Images uploaded successfully.']);
    }

    return response()->json(['success' => false, 'message' => 'No images uploaded.']);
}







public function exportAllOrders(Request $request)
{
    // Build the query
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
            DB::raw('IF(products.price IS NULL OR products.price = 0, product_variant_values.price, products.price) as price')
        );

    // Fetch the filtered data
    $products = $query->get();
    
   

    // Return the data as JSON
    return response()->json($products);
}




public function sellerexportAllproduct(Request $request) {     
    // Build the query     
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
            DB::raw('IF(products.price IS NULL OR products.price = 0, product_variant_values.price, products.price) as price')         
        )  
        ->where('products.producttype', '=', 'seller'); // Filtering products by producttype = 'seller'

    // Fetch the filtered data     
    $products = $query->get();               

    // Return the data as JSON     
    return response()->json($products); 
}



    public function sellersproduct(Request $request)
    {

        try{
            $data['result'] = Product::sellersgetLists($request->all());


             $data['categories'] = Category::where('status', 1)->get();
            $data['brand'] = Brand::where('status', 1)->get();

         
            $data['statusTypes'] = \Helpers::getStatusType();

            return view('admin.sellersproduct.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }



   public function translation($id)
    {
        $Product = Product::find($id);
        $languages = Language::where('status',1)->get();

        foreach ($languages as $language) {
           // dd($language);
            $language->details = ProductTranslation::where('product_id',$id)->where('language_code',$language->code)->first();

            if (!$language->details) {
                $productData = [
                   'product_id' => $id,
                    'language_code' => $language->code,
                    'name' => $Product->name,
                    'description' => $Product->description,
                    'short_description' => $Product->short_des,
                    'created_at' => date("Y-m-d H:i:s")
                ];
                ProductTranslation::create($productData);
                $language->details = ProductTranslation::where('product_id', $id)
                    ->where('language_code', $language->code)
                    ->first();
            }
        }
        return view('admin.products.translation', compact('Product', 'languages'));
    }





  public function updateTranslation($id, Request $request)
    {
      
        $request->validate([
            'language_code' => 'required|array',
            'language_code.*' => 'required|string',
            'name' => 'required|array',
            'name.*' => 'required|string|max:255',
             'short_description' => 'required|array',
            'short_description.*' => 'required',
             'description' => 'required',
            'description.*' => 'required',
        ]);

        $input = $request->all();

        for ($i = 0; $i < count($input['language_code']); $i++) {
            $translationId = $input['translation_id'][$i] ?? null;

            $productTranslationData = [
                'language_code' => $input['language_code'][$i],
                'name' => $input['name'][$i],
                'short_description' => $input['short_description'][$i],
                'description' => $input['description'][$i],
             
                'updated_at' => now(),
            ];
            if ($translationId) {
                ProductTranslation::where('id', $translationId)->update($productTranslationData);
            } else {
                $productTranslationData['product_id'] = $id;
                ProductTranslation::create($productTranslationData);
            }
        }
        Session::flash('success', 'Translation updated successfully!');
        return redirect(url('admin/products'))->with('success', 'Translation updated successfully.');

    }

  







    





  






 



}

















