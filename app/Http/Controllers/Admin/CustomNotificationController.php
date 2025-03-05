<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\CoustomNotification;

use Session;


class CustomNotificationController extends Controller
{
    
    
   
    public function index(Request $request)
    {

        
        try{
            
            $data['result'] = CoustomNotification::getLists($request->all());
            $data['statusTypes'] = \Helpers::getStatusType();
            return view('admin.customnotifications.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }


   
public function store(Request $request)
{
  
    if (isset($request['user_ids']) && is_array($request['user_ids'])) {
        $userIds = implode(',', $request['user_ids']); 
        $request['user_ids'] = $userIds; 
    }


   
    $imagePath = null;
    if ($request->hasFile('image')) {
        // Get the uploaded file
        $image = $request->file('image');

        // Create a unique filename
        $filename = time() . '_' . $image->getClientOriginalName();

        // Define the path where the image will be stored
        $destinationPath = public_path('uploads/notiimage');

        // Ensure the directory exists
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true); // Create directory if it doesn't exist
        }

        // Move the file to the specified directory
        $imagePath = $destinationPath . '/' . $filename;
        $image->move($destinationPath, $filename); // Move the file to the destination
    }


    // Create a new notification instance
    $notification = new CoustomNotification(); 

    $notification->user_ids = $request['user_ids']; 
    $notification->image = 'uploads/notiimage/' . $filename; // 
    $notification->title = $request->title; 
    $notification->content = $request->content;
    $notification->link = $request->link;
    $notification->sendto = $request->sendto;
    $notification->save(); // Save the data to the database

    return redirect('admin/custom-notification')->with('success', 'Notification added successfully!');
}



   






    /**
     * Display a edit listing of the categories.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    **/
    public function edit(Request $request,$id)
    {
        try{
            $data = Category::where('id',$id)->first();
            return view('admin.category.edit',compact('data'));
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
    public function update(Request $request)
    {
        try{
            $updated = Category::addUpdate($request->all(),$request->input('id'));
            if($updated['status']==true){
                return redirect('admin/category')->with('success', $updated['message']); 
            }
            else{
                return redirect()->back()->with('error', $updated['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
     public function destroy($id)
    {
        try{
            $deleted = CoustomNotification::deleteRecord($id);
            
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


    public function categoryDelete(Request $request)
{
    
    Product::where('categories_id', $request->categoryIdToDelete)
        ->update(['categories_id' => $request->categoryid]);

    Subcategory::where('category_id', $request->categoryIdToDelete)
        ->update(['category_id' => $request->categoryid]);

    
    Category::where('id', $request->categoryIdToDelete)->update(['deleted_at' => now()]);


    return response()->json([
        'success' => true,
        'message' => 'Category deleted successfully.'
    ]);
}

  
    public function updateColumn($id)
    {
        try{
            $updated = Category::updateColumn($id);
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



   
    public function updateIsFeaturedColumn($id)
    {
        try{
            $updated = Category::updateFeaturedColumn($id);
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






    public function fatchcategorydata(Request $request)
{
  $categoryName = Category::where('id', $request->categoryid)->pluck('name')->first();
    $productCount = Product::where('categories_id', $request->categoryid)->count();
    $subcategoryCount = Subcategory::where('category_id', $request->categoryid)->count();

    return response()->json([
        'product_count' => $productCount,
        'subcategory_count' => $subcategoryCount,
        'categoryName'=>$categoryName
    ]);
}

}
