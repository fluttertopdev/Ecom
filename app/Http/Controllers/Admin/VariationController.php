<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Variation;
use Session;

class VariationController extends Controller
{
    /**
     * Display a listing of the categories.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    **/
    public function index(Request $request)
    {
        
        try{
            $data['result'] = Variation::getLists($request->all());
            $data['statusTypes'] = \Helpers::getStatusType();
            return view('admin.variations.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }


    /**
     * Display a listing of the categories.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    **/
 


    /**
     * Store a newly created resource in category.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
    **/

    public function store(Request $request)
    {

     
          
        try{
            $added = Variation::addUpdate($request->all());
            if($added['status']==true){
                Session::flash('success', $added['message']);
                return redirect('admin/variations')->with('success', $added['message']); 
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
            $data = Brand::where('id',$id)->first();
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
            $updated = Attribute::addUpdate($request->all(),$request->input('id'));
            if($updated['status']==true){
                return redirect('admin/attributes')->with('success', $updated['message']); 
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
            $deleted = Attribute::deleteRecord($id);
            
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

    /**
     * Update the specified category from storage.
     *
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
    public function updateColumn($id)
    {
        try{
            $updated = Brand::updateColumn($id);
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


     /**
     * Update the specified category from storage.
     *
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
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

}
