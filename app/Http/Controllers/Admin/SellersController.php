<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\Sellers;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\OrderProduct;
use App\Models\SellerIncome;
use App\Models\Withdraw;
use DB;
use Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class SellersController extends Controller
{


public function index(Request $request)
{

try{

$data['statusTypes'] = \Helpers::getStatusType();
$data['result'] = User::sellersgetLists($request->all());
return view('admin.sellers.list',$data);
}
catch(\Exception $ex){
return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
}
}




public function create(Request $request)
{ 
$country_data = Country::get(); 

return view('admin.sellers.create',compact('country_data'));
}





public function store(Request $request)
{

try{
$added = User::addUpdatesellers($request->all());
if($added['status']==true){
Session::flash('success', $added['message']);
return redirect('admin/all-sellers')->with('success', $added['message']); 
}
else{
return redirect()->back()->with('error', $added['message']);
}
}
catch(\Exception $ex){
return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
}
}

public function edit($id)
{
// Fetch the seller data by ID
$result = User::where('id', $id)->first();

// Fetch all countries for the select dropdown
$country_data = Country::get();
$states = State::get(); 
$cities = City::get(); 

// Fetch the selected state and city based on the user's data
$selectedState = $result->stateid; // Assuming the state ID is stored in the 'stateid' column
$selectedCity = $result->cityid; // Assuming the city ID is stored in the 'cityid' column

return view('admin.sellers.edit', compact('result', 'country_data', 'selectedState', 'selectedCity','states','cities'));
}






public function update(Request $request)
{


try {
// Validation
$validator = Validator::make($request->all(), [
'name' => 'required',
'email' => 'required|unique:users,email,' . $request->id,
'phone' => 'required|unique:users,phone,' . $request->id . '|numeric|digits:10',

'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image validation
]);

if ($validator->fails()) {
return redirect()->back()->with('error', 'Error: ' . implode(', ', $validator->errors()->all()));
}

// Find the seller by ID
$seller = User::findOrFail($request->id);

// Update fields
$seller->name = $request->input('name');
$seller->email = $request->input('email');
$seller->phone = $request->input('phone');
$seller->shopname = $request->input('shopname');
$seller->password = Hash::make($request->input('password'));
$seller->address = $request->input('address');
$seller->countryid = $request->input('countryid');
$seller->stateid = $request->input('stateid');
$seller->cityid = $request->input('cityid');

// Handle image upload if provided
if ($request->hasFile('image')) {
// Delete old image if exists
if ($seller->image && \File::exists(public_path('sellers/' . $seller->image))) {
\File::delete(public_path('sellers/' . $seller->image));
}

// Upload new image
$uploadImage = \Helpers::uploadFiles($request->file('image'), 'sellers/');
if ($uploadImage['status'] === true) {
$seller->image = $uploadImage['file_name'];
}
}

// Save the updated seller
if ($seller->save()) {
return redirect('admin/all-sellers')->with('success', 'Seller updated successfully');
} else {
return redirect()->back()->with('error', 'Failed to update the seller');
}
} catch (\Exception $ex) {
return redirect()->back()->with('error', $ex->getMessage() . ' ' . $ex->getLine() . ' ' . $ex->getFile());
}
}


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

public function updatecommison(Request $request)
{


$seller = User::find($request->sellerid);

if (!$seller) {
return redirect()->back()->with('error', 'Seller not found.');
}


$seller->commison_status = $request->commison_status; // 1 for active, 0 for inactive
$seller->commison = $request->commison; // Update commission rate, it can be null if not set

// Save the changes
$seller->save();


return redirect()->back()->with('success', 'Seller commission  updated successfully.');
}







            
            

         
           
public function sellersview(Request $request)
{
    $seller_id = $request->query('seller_id'); 

    $data['sellerdata'] = User::where('id', $seller_id)->first();
    $data['result'] = Product::sellersmyproduct($seller_id,$request->all());


    $data['categories'] = Category::where('status', 1)->get();
    $data['brand'] = Brand::where('status', 1)->get();
    $data['statusTypes'] = \Helpers::getStatusType();
    $data['paymentstatus'] = \Helpers::getpaymentstatusType();
   $data['seller_order'] = OrderProduct::sellersordergetLists($request->all());
   $data['activeproduct'] = Product::where('created_by', $seller_id)->where('status', '1')->count();
   $data['deactiveproduct'] = Product::where('created_by', $seller_id)->where('status', '0')->count();
    $data['allproduct'] = Product::where('created_by', $seller_id)->count();
    $data['total_order_count'] =  OrderProduct::where('status','!=','delivered')->where('seller_id',$seller_id)->count();
    $data['pending_order_count'] =  OrderProduct::where('status','pending')->where('seller_id',$seller_id)->count();
    $data['delivered_order_count'] =  OrderProduct::where('status','delivered')->where('seller_id',$seller_id)->count();
    $data['cancelled_order_count'] =  OrderProduct::where('status','cancelled')->where('seller_id',$seller_id)->count();

     $data['totalearning'] = SellerIncome::where('seller_id', $seller_id)->sum('income_amount');
    $data['pendingwithdraw'] = Withdraw::where('user_id', $seller_id)->where('status', 'pending')->sum('amount');
    $data['confermwithdraw'] = Withdraw::where('user_id', $seller_id)->where('status', 'completed')->sum('amount'); 
     $Withdrawablesubtotal=$data['pendingwithdraw']+ $data['confermwithdraw'];
    $data['totalWithdrawable']= $data['totalearning']-$Withdrawablesubtotal;
     $data['withdraw_request'] = Withdraw::where('user_id', $seller_id)->get();
    return view('admin.sellers.view', $data);
}

 public function sellerDisbursement(Request $request)
    {
    $data['result'] = Withdraw::sellerdisbursementLists($request->all());
        

        return view('admin.disbursement_management.list',$data);
    }


public function sellerwithrawrequest($id)
{
// Fetch the seller data by ID
$withdrawid = Withdraw::where('id', $id)->first();



$result = DB::table('users')
    ->join('bankinfos', 'users.id', '=', 'bankinfos.userid')
    ->where('users.id', $withdrawid->user_id) 
    ->first(['users.*', 'bankinfos.*']);

    
return view('admin.disbursement_management.seller_withdraw_request_detail', compact('result','withdrawid'));
}


public function requestupdate(Request $request)
{
    // Get the inputs from the request
    $status = $request->input('status');
    $msg = $request->input('message');

    $id = $request->input('id');

  

    // Find the Withdraw record by ID
    $withdraw = Withdraw::find($id);

  

    // Update the msg and status fields
    $withdraw->message = $msg;
    $withdraw->status = $status;

    // Save the updated record
    $withdraw->save();

    // Redirect back with success message
     return redirect()->to('admin/seller-disbursement')->with('Withdraw status  updated successfully');
}




}
