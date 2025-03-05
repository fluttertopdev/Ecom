<?php

namespace App\Http\Controllers\Sellers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

use Session;

class CouponController extends Controller
{
    
    
   
    public function index(Request $request)
    {
        try{
            
            $data['result'] = Coupon::sellersgetLists($request->all());

            $data['statusTypes'] = \Helpers::getStatusType();
            return view('sellers.coupon.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }


 

    public function store(Request $request)
    {
         
        try{
            $added = Coupon::sellersaddUpdate($request->all());
            if($added['status']==true){
                Session::flash('success', $added['message']);
                return redirect('sellers-coupon')->with('success', $added['message']); 
            }
            else{
                return redirect()->back()->with('error', $added['message']);
            }
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }


  
 

   
    public function update(Request $request)
    {
        try{
            $updated = Coupon::sellersaddUpdate($request->all(),$request->input('id'));
            if($updated['status']==true){
                return redirect('sellers-coupon')->with('success', $updated['message']); 
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
            $deleted = Coupon::deleteRecord($id);
            
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
            $updated = Coupon::updateColumn($id);
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
