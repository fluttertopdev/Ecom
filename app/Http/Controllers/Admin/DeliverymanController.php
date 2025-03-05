<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Deliveryman;
use App\Models\Review;  
use Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class DeliverymanController extends Controller
{
    /**
     * Display a listing.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    **/
    public function index(Request $request)
    {

        try{
           
            $data['statusTypes'] = \Helpers::getStatusType();
            $data['result'] = Deliveryman::getLists($request->all());
            return view('admin.deliveryman.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }


    /**
     * Display a page.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    **/
    public function create(Request $request)
    { 
      
        $data['identityType'] = \Helpers::getIdentityType();
        $data['vehicleType'] = \Helpers::getVehicleType();
        return view('admin.deliveryman.create',$data);
    }


    /**
     * Store a newly created resource.
     *
     * @param  \App\Http\Requests\Store  $request
     * @return \Illuminate\Http\Response
    **/

    public function store(Request $request)
    {

        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:deliverymans,email',
                'phone' => 'required|unique:deliverymans,phone|numeric|digits:10',
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password',
               
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Error: ' . implode(', ', $validator->errors()->all()));
            }

            $added = Deliveryman::addUpdate($request->all());
            if($added['status']==true){
                Session::flash('success', $added['message']);
                return redirect('admin/deliveryman')->with('success', $added['message']); 
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
     * Display a edit listing.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    **/
    public function edit(Request $request,$id)
    {
        try{
            $data['result'] = deliveryman::where('id',$id)->first();
      
            $data['identityType'] = \Helpers::getIdentityType();
            $data['vehicleType'] = \Helpers::getVehicleType();
            return view('admin.deliveryman.edit',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    /**
     * Update the specified in storage.
     *
     * @param  \App\Http\Requests\UpdateRequest  $request
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
    public function update(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:deliverymans,email,'.$request->id,
                'phone' => 'required|unique:deliverymans,phone,'.$request->id.'|numeric|digits:10',
                'password' => 'nullable|min:6',
                'confirm_password' => 'nullable|same:password',
              
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Error: ' . implode(', ', $validator->errors()->all()));
            }

            $updated = Deliveryman::addUpdate($request->all(),$request->input('id'));
            if($updated['status']==true){
                return redirect('admin/deliveryman')->with('success', $updated['message']); 
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
     * Remove the specified from storage.
     *
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
    public function destroy($id)
    {
        try{
            $deleted = Deliveryman::deleteRecord($id);
            
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
     * Remove the specified Subcategory from storage.
     *
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
    public function updateColumn($id)
    {
        try{
            $updated = Deliveryman::updateColumn($id);
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
     * view the specified from storage.
     *
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/

        public function viewDeliveryman(Request $request,$id)
    {
        try{
            $data['result'] = Deliveryman::with('area')->where('id',$id)->first();
            $data['deliverymanReviews'] = Review::getSignleDeliveryman($id);
            return view('admin.deliveryman.view',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }


    /**
     * View the specified .
     *
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
    public function deliverymanReviews(Request $request)
    {
        try {
            $data['result'] = Review::getDeliverymanLists($request->all());

            return view('admin.deliveryman.review-list', $data);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage() . ' ' . $ex->getLine() . ' ' . $ex->getFile());
        }
    }


}
