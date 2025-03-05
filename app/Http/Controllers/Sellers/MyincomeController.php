<?php

namespace App\Http\Controllers\Sellers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use App\Models\Withdraw;
use App\Models\User;
use App\Models\SellerIncome;
use Auth;
use Session;

class MyincomeController extends Controller
{
    
    


   
    public function index(Request $request)
    {

    $sellersid = Auth::check() && Auth::user()->type == 'seller' ? Auth::user()->id : null;
     $data['statusTypes'] = \Helpers::getStatusType();
     $data['allPendingRequest'] = Withdraw::withdrawpendinggetLists($request->all());
     $data['allRequests'] = Withdraw::allwithdrawgetLists($request->all());
     
    $data['totalearning'] = SellerIncome::where('seller_id', $sellersid)->sum('income_amount');
    $data['pendingwithdraw'] = Withdraw::where('user_id', $sellersid)->where('status', 'pending')->sum('amount');
    $data['confermwithdraw'] = Withdraw::where('user_id', $sellersid)->where('status', 'completed')->sum('amount'); 
     $Withdrawablesubtotal=$data['pendingwithdraw']+ $data['confermwithdraw'];
    $data['totalWithdrawable']= $data['totalearning']-$Withdrawablesubtotal;
    return view('sellers.myincome.index',$data);
    }




 

    public function storerequest(Request $request)
    {
        
         
        try{
            $added = Withdraw::addUpdate($request->all());
            if($added['status']==true){
                Session::flash('success', $added['message']);
                return redirect('my-income')->with('success', $added['message']); 
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
            $updated = Withdraw::sellersaddUpdate($request->all(),$request->input('id'));
            if($updated['status']==true){
                return redirect('sellers-withdraw-requests')->with('success', $updated['message']); 
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
            $deleted = Withdraw::deleteRecord($id);
            
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



  
   


   
 







}
