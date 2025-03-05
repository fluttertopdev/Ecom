<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Orders;
use Carbon\Carbon;
use App\Models\Delivery_address;
use App\Models\OrderProduct;
use App\Models\SellerIncome;

use Illuminate\Database\Eloquent\SoftDeletes;
use Session;






class OrdersController extends Controller
{
    
    
    
    public function index(Request $request)
    {
        try{
            
          
            $data['result'] = OrderProduct::getLists($request->all());


            $data['statusTypes'] = \Helpers::getStatusType();
            $data['paymentstatus'] = \Helpers::getpaymentstatusType();
            
            return view('admin.orders.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }


   
    public function orderDetails($id)
    { 

        
        $orderProduct = OrderProduct::orderDetailsGetList($id);
        $shippingid=$orderProduct->deliveryaddress_id;
     
     $deliveryaddress = Delivery_address::where('id', $shippingid)->first();




        return view('admin.orders.orderdetails', compact('orderProduct','deliveryaddress'));
    }



public function updateorderproductStatus(Request $request)
{
     
     
     
    
    // Validate the request data
    $validated = $request->validate([
        'orderProductId' => 'required|integer',
        'status' => 'required|string|in:pending,confirmed,Picked-up,On-the-way,delivered',
    ]);



    try {
        // Find the order product and update the status
        $orderProduct = OrderProduct::find($validated['orderProductId']);


     
        if ($orderProduct) {
            $orderProduct->status = $validated['status'];
            $orderProduct->save();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Order product not found.']);
        }
    } catch (\Exception $e) {
        // Handle any exceptions
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}


      public function inhouseorders(Request $request)
    {

        try{
            
             $data['paymentstatus'] = \Helpers::getpaymentstatusType();
            $data['result'] = OrderProduct::inhouseordergetLists($request->all());
            $data['statusTypes'] = \Helpers::getStatusType();
            return view('admin.inhouseorders.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    public function deliveredorders(Request $request)
    {

        try{
            

            $data['result'] = OrderProduct::admindeliveredordergetLists($request->all());
            $data['statusTypes'] = \Helpers::getStatusType();
            return view('admin.deliveredorders.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }
 

      public function sellersorders(Request $request)
    {

        try{
            
              $data['paymentstatus'] = \Helpers::getpaymentstatusType();
            $data['result'] = OrderProduct::sellersordergetLists($request->all());
            $data['statusTypes'] = \Helpers::getStatusType();
            return view('admin.sellersorders.list',$data);
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







public function getOrderData(Request $request)
{
    $timeRange = $request->input('time_range');
    $startDate = null;
    $endDate = Carbon::now(); // default to current date

    // Determine the start date based on the selected time range
    if ($timeRange === '7') {
        $startDate = Carbon::now()->subDays(7); // Last 7 days
    } elseif ($timeRange === '30') {
        $startDate = Carbon::now()->subDays(30); // Last 30 days
    } elseif ($timeRange === '12') {
        $startDate = Carbon::now()->subMonths(12); // Last 12 months
    }

    // Fetch the data based on the time range
    $orders = OrderProduct::whereBetween('created_at', [$startDate, $endDate])
        ->get(['created_at', 'order_type', 'order_quantity', 'order_total']); // Make sure to include 'order_total'

    // Initialize arrays to store data
    $labels = [];
    $inHouseOrders = [];
    $sellerOrders = [];
    $inHouseTotal = [];
    $sellerTotal = [];

    // Generate the labels and initialize arrays with zeroes for missing dates
    if ($timeRange === '7') {
        for ($i = 6; $i >= 0; $i--) {
            $dateLabel = Carbon::now()->subDays($i)->format('l'); // 'l' is the full day name
            $labels[] = $dateLabel;
            $inHouseOrders[$dateLabel] = 0;
            $sellerOrders[$dateLabel] = 0;
            $inHouseTotal[$dateLabel] = 0;
            $sellerTotal[$dateLabel] = 0;
        }
    } elseif ($timeRange === '30') {
        for ($i = 29; $i >= 0; $i--) {
            $dateLabel = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = $dateLabel;
            $inHouseOrders[$dateLabel] = 0;
            $sellerOrders[$dateLabel] = 0;
            $inHouseTotal[$dateLabel] = 0;
            $sellerTotal[$dateLabel] = 0;
        }
    } elseif ($timeRange === '12') {
        for ($i = 11; $i >= 0; $i--) {
            $dateLabel = Carbon::now()->subMonths($i)->format('F'); // 'F' is the full month name
            $labels[] = $dateLabel;
            $inHouseOrders[$dateLabel] = 0;
            $sellerOrders[$dateLabel] = 0;
            $inHouseTotal[$dateLabel] = 0;
            $sellerTotal[$dateLabel] = 0;
        }
    }

    // Group orders by date label and accumulate the data
    foreach ($orders as $order) {
        // Format the date according to the time range
        if ($timeRange === '7') {
            $dateLabel = Carbon::parse($order->created_at)->format('l');
        } elseif ($timeRange === '30') {
            $dateLabel = Carbon::parse($order->created_at)->format('Y-m-d');
        } else {
            $dateLabel = Carbon::parse($order->created_at)->format('F');
        }

        // Update the data arrays for each order
        if ($order->order_type === 'in_house') {
            $inHouseOrders[$dateLabel] += $order->order_quantity;
            $inHouseTotal[$dateLabel] += $order->order_total;
        } else {
            $sellerOrders[$dateLabel] += $order->order_quantity;
            $sellerTotal[$dateLabel] += $order->order_total;
        }
    }

    // Map the data to the labels (fill missing data with zeroes)
    $data = [
        'labels' => $labels,
        'inHouseOrders' => array_values(array_map(function ($label) use ($inHouseOrders) {
            return $inHouseOrders[$label];
        }, $labels)),
        'sellerOrders' => array_values(array_map(function ($label) use ($sellerOrders) {
            return $sellerOrders[$label];
        }, $labels)),
        'inHouseTotal' => array_values(array_map(function ($label) use ($inHouseTotal) {
            return $inHouseTotal[$label];
        }, $labels)),
        'sellerTotal' => array_values(array_map(function ($label) use ($sellerTotal) {
            return $sellerTotal[$label];
        }, $labels)),
    ];

    return response()->json($data);
}












   public function destroy($id)
    {
        try{
            $deleted = OrderProduct::deleteRecord($id);
            
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


public function admingetRevenueData(Request $request)
{
    $period = $request->query('period'); // Get the selected period (7, 30, or 365 days)
    $now = Carbon::now();
    $data = [];
    $labels = [];

    if ($period == 7) {
        for ($i = 6; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $labels[] = $date->format('l'); // Day name
            
            // Sum commission_amount from SellerIncome
            $commissionSum = SellerIncome::where('seller_id', '!=', 1)
                ->whereDate('created_at', $date->format('Y-m-d'))
                ->sum('commission_amount');

            // Sum order_total from OrderProduct
            $orderTotalSum = OrderProduct::where('seller_id', 1)
                ->whereDate('created_at', $date->format('Y-m-d'))
                ->sum('order_total');

            $data[] = $commissionSum + $orderTotalSum;
        }
    } elseif ($period == 30) {
        for ($i = 29; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $labels[] = $date->format('Y-m-d'); // ISO date
            
            // Sum commission_amount from SellerIncome
            $commissionSum = SellerIncome::where('seller_id', '!=', 1)
                ->whereDate('created_at', $date->format('Y-m-d'))
                ->sum('commission_amount');

            // Sum order_total from OrderProduct
            $orderTotalSum = OrderProduct::where('seller_id', 1)
                ->whereDate('created_at', $date->format('Y-m-d'))
                ->sum('order_total');

            $data[] = $commissionSum + $orderTotalSum;
        }
    } elseif ($period == 365) {
        for ($i = 11; $i >= 0; $i--) {
            $date = $now->copy()->subMonthsNoOverflow($i);
            $labels[] = $date->format('M Y'); // Month and Year
            
            // Sum commission_amount from SellerIncome
            $commissionSum = SellerIncome::where('seller_id', '!=', 1)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('commission_amount');

            // Sum order_total from OrderProduct
            $orderTotalSum = OrderProduct::where('seller_id', 1)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('order_total');

            $data[] = $commissionSum + $orderTotalSum;
        }
    }

    return response()->json(['labels' => $labels, 'data' => $data]);
}



}
