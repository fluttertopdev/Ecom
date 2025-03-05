<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Tax;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use Session;

class TaxController extends Controller
{
    
  
    public function index(Request $request)
    {
        try{
            
            $data['result'] = Tax::getLists($request->all());
            $data['statusTypes'] = \Helpers::getStatusType();
            return view('admin.taxmanagement.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }





    public function store(Request $request)
    {
         

        try{
            $added = Tax::addUpdate($request->all());
            if($added['status']==true){
                Session::flash('success', $added['message']);
                return redirect('admin/tax-list')->with('success', $added['message']); 
            }
            else{
                return redirect()->back()->with('error', $added['message']);
            }
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }


   
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

  

    public function update(Request $request)
    {
        try{
            $updated = Tax::addUpdate($request->all(),$request->input('id'));
            if($updated['status']==true){
                return redirect('admin/tax-list')->with('success', $updated['message']); 
            }
            else{
                return redirect()->back()->with('error', $updated['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

  
     public function destroy($id)
    {
        try{
            $deleted = Tax::deleteRecord($id);
            
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
            $updated = Tax::updateColumn($id);
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
