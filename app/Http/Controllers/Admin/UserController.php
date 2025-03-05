<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Order;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Validator;
use DB;

class UserController extends Controller
{
    

    /**
     * Show the form for editing the specified user profile.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
    */
    public function adminProfile()
    {
        try {
            $data['row'] = User::getProfile();
            return view('admin.profile.index',$data);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }
    
    /**
     * Update the specified resource in user.
     *
     * @param  \App\Http\Requests\User\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function updateAdminProfile(Request $request)
    {
        try{
            $profileUpdated = User::updateProfile($request->all(),$request->input('id'));
            if($profileUpdated['status']==true){
                return redirect()->back()->with('success', $profileUpdated['message']); 
            }
            else{
                return redirect()->back()->with('error', $profileUpdated['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

   

    /**
     * Show the list.
     **/
    public function customerList(Request $request)
    {
        try{
            $data['result'] = User::getCustomerLists($request->all());
            $data['statusTypes'] = \Helpers::getStatusType();
            return view('admin.customer.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }


    /**
     * Store a newly created resource.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
    **/
    public function store(Request $request)
    {

        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|max:255|unique:users',
                'phone' => 'required|string|max:10|unique:users',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Error: ' . implode(', ', $validator->errors()->all()));
            }

            $added = User::addUpdateCustomer($request->all());
            if($added['status']==true){
                Session::flash('success', $added['message']);
                return redirect('admin/customer')->with('success', $added['message']); 
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
     * Update the specified the in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
    public function update(Request $request)
    {
        try{
            $updated = User::addUpdateCustomer($request->all(),$request->input('id'));
            if($updated['status']==true){
                return redirect('admin/customer')->with('success', $updated['message']); 
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
     * Remove the specified record.
     *
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
    public function destroy($id)
    {
        try{
            $deleted = User::deleteRecord($id);
            
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
     * Remove the specified category from storage.
     *
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
    public function updateColumn($id)
    {
        try{
            $updated = User::updateColumn($id);
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
     * View the specified record.
     *
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
     public function viewCustomer(Request $request,$id)
    {
        try{
            $data['customerData'] = User::where('id',$id)->first();
            $data['result'] = Order::getUserOrderLists($id);
            $data['walletAmount'] = Wallet::select(
            DB::raw('SUM(CASE WHEN type = "credit" THEN amount ELSE 0 END) AS total_credit'),
            DB::raw('SUM(CASE WHEN type = "debit" THEN amount ELSE 0 END) AS total_debit')
            )
            ->where('customer_id', $id)
            ->groupBy('customer_id')
            ->first();

            // Check if there are any records for the customer
            if ($data['walletAmount']) {
            $data['finalAmount'] = $data['walletAmount']->total_credit - $data['walletAmount']->total_debit;
            } else {
            $data['finalAmount'] = 0;
            }

            return view('admin.customer.view',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }





}
