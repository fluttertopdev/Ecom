<?php

namespace App\Http\Controllers\Sellers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Orders;
use Session;


class RefundrequestController extends Controller
{
    
    
   
    public function index(Request $request)
    {
        try{
            
            $data['result'] = Orders::getLists($request->all());
            $data['statusTypes'] = \Helpers::getStatusType();
            return view('sellers.refundrequest.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }


   public function pendingorder(Request $request)
    {
        try{
            
            $data['result'] = Orders::getLists($request->all());
            $data['statusTypes'] = \Helpers::getStatusType();
            return view('sellers.pendingorder.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

      public function deliveredorder(Request $request)
    {
        try{
            
            $data['result'] = Orders::getLists($request->all());
            $data['statusTypes'] = \Helpers::getStatusType();
            return view('sellers.deliveredorder.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }



      public function cancelledorder(Request $request)
    {
        try{
            
            $data['result'] = Orders::getLists($request->all());
            $data['statusTypes'] = \Helpers::getStatusType();
            return view('sellers.cancelledorder.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

         public function refundorder(Request $request)
    {
        try{
            
            $data['result'] = Orders::getLists($request->all());
            $data['statusTypes'] = \Helpers::getStatusType();
            return view('sellers.refundorder.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }
    
    public function orderDetails(Request $request)
    { 
        return view('sellers.orders.orderdetails');
    }


    /**
     * Store a newly created resource in category.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
    **/

    public function store(Request $request)
    {

        try{
            $added = Category::addUpdate($request->all());
            if($added['status']==true){
                Session::flash('success', $added['message']);
                return redirect('admin/category')->with('success', $added['message']); 
            }
            else{
                return redirect()->back()->with('error', $added['message']);
            }
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
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
            $deleted = Category::deleteRecord($id);
            
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
