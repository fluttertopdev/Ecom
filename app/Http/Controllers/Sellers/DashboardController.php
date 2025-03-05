<?php

namespace App\Http\Controllers\Sellers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Sellers;
use App\Models\OrderProduct;
use App\Models\Product;
use Firebase\JWT\JWT;
use Google\Client;
use App\Models\Withdraw;
use App\Models\SellerIncome;

use Google\Service\Drive;
use DB;
use Session;


class DashboardController extends Controller
{
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index()
{
    $id = Auth::check() && Auth::user()->type == 'seller' ? Auth::user()->id : null;

   
 // Today's Orders Quantity (sum of qty for orders placed today)
    $todayOrdersQty = OrderProduct::where('seller_id',$id )->whereDate('created_at', today())->sum('order_quantity');  // Assuming 'qty' is the field for product quantity

    // Today's Sale Amount (total sale amount for orders placed today)
    $todaySale = OrderProduct::where('seller_id',$id )->whereDate('created_at', today())->sum('order_total'); // Adjust 'price' to your actual field name for the sale amount

    // Total Orders Quantity (sum of qty for all orders ever placed)
    $totalOrdersQty = OrderProduct::where('seller_id',$id )->sum('order_quantity');  // Summing 'qty' across all orders

    // Total Sale Amount (total sale amount for all orders ever placed)
    $totalSale = OrderProduct::where('seller_id',$id )->sum('order_total'); // Adjust 'price' to your actual field name for the sale amount
    $totalProduct = Product::where('created_by',$id )->count();
     $totalWithdraw = Withdraw::where('user_id',$id )->where('status','completed' )->sum('amount');
     $totalearning = SellerIncome::where('seller_id',$id )->sum('income_amount');

     return view('sellers.dashboard.index', [
        'todayOrdersQty' => $todayOrdersQty,
        'todaySale' => $todaySale,
        'totalOrdersQty' => $totalOrdersQty,
        'totalSale' => $totalSale,
         'totalProduct' => $totalProduct,
          'totalWithdraw' => $totalWithdraw,
         'totalearning'=>$totalearning,
    ]);
  

}




public function sellersProfile()
{
try {
$data['row'] = User::getProfile();
return view('sellers.profile.index',$data);
} catch (\Exception $ex) {
return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
}
}


public function updateSellersProfile(Request $request)
{
  
try{
$profileUpdated = User::sellerupdateProfile($request->all(),$request->input('id'));
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




 public function logoutSellers(Request $request)
{
    Auth::guard('seller')->logout();
    $request->session()->forget('seller'); // Forget only the seller session data
    return redirect(url('seller-login'));
}
}
