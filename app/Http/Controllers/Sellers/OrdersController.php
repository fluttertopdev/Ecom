<?php

namespace App\Http\Controllers\Sellers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Orders;
use App\Models\OrderProduct;
use Carbon\Carbon;
use App\Models\SellerIncome;

use App\Models\Delivery_address;
use Auth;
use Session;



class OrdersController extends Controller
{



public function index(Request $request)
{
try{


$data['result'] = OrderProduct::sellerordergetLists($request->all());
$data['statusTypes'] = \Helpers::getStatusType();
return view('sellers.orders.list',$data);
}
catch(\Exception $ex){
return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
}
}




public function deliveredorder(Request $request)
{
try{

$data['result'] = OrderProduct::deliveredordergetLists($request->all());
$data['statusTypes'] = \Helpers::getStatusType();
return view('sellers.deliveredorder.list',$data);
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




return view('sellers.orders.orderdetails', compact('orderProduct','deliveryaddress'));
}



public function sellergetOrderData(Request $request)
{
    $id = Auth::check() && Auth::user()->type == 'seller' ? Auth::user()->id : null;

    $timeRange = $request->input('time_range');
    $startDate = null;
    $endDate = Carbon::now();

    if ($timeRange === '7') {
        $startDate = Carbon::now()->subDays(7);
    } elseif ($timeRange === '30') {
        $startDate = Carbon::now()->subDays(30);
    } elseif ($timeRange === '365') {
        $startDate = Carbon::now()->subDays(365); // Corrected range for 12 months
    }

    $orders = OrderProduct::whereBetween('created_at', [$startDate, $endDate])
        ->where('seller_id', $id)
        ->get(['created_at', 'order_quantity', 'order_total']);

    $labels = [];
    $sellerOrders = [];
    $sellerTotal = [];

    if ($timeRange === '7') {
        for ($i = 6; $i >= 0; $i--) {
            $dateLabel = Carbon::now()->subDays($i)->format('l');
            $labels[] = $dateLabel;
            $sellerOrders[$dateLabel] = 0;
            $sellerTotal[$dateLabel] = 0;
        }
    } elseif ($timeRange === '30') {
        for ($i = 29; $i >= 0; $i--) {
            $dateLabel = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = $dateLabel;
            $sellerOrders[$dateLabel] = 0;
            $sellerTotal[$dateLabel] = 0;
        }
    } elseif ($timeRange === '365') {
        for ($i = 11; $i >= 0; $i--) {
            $dateLabel = Carbon::now()->subMonths($i)->format('F');
            $labels[] = $dateLabel;
            $sellerOrders[$dateLabel] = 0;
            $sellerTotal[$dateLabel] = 0;
        }
    }

    foreach ($orders as $order) {
        if ($timeRange === '7') {
            $dateLabel = Carbon::parse($order->created_at)->format('l');
        } elseif ($timeRange === '30') {
            $dateLabel = Carbon::parse($order->created_at)->format('Y-m-d');
        } else {
            $dateLabel = Carbon::parse($order->created_at)->format('F');
        }

        $sellerOrders[$dateLabel] += $order->order_quantity;
        $sellerTotal[$dateLabel] += $order->order_total;
    }

    $data = [
        'labels' => $labels,
        'sellerOrders' => array_values(array_map(function ($label) use ($sellerOrders) {
            return $sellerOrders[$label];
        }, $labels)),
        'sellerTotal' => array_values(array_map(function ($label) use ($sellerTotal) {
            return $sellerTotal[$label];
        }, $labels)),
    ];

    return response()->json($data);
}

public function getRevenueData(Request $request)
    {

    	$id = Auth::check() && Auth::user()->type == 'seller' ? Auth::user()->id : null;
        $period = $request->query('period'); // Get the selected period (7, 30, or 365 days)
        
        $now = Carbon::now();
        $data = [];

        if ($period == 7) {
            $labels = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = $now->copy()->subDays($i);
                $labels[] = $date->format('l'); // Day name
                $data[] = SellerIncome::where('seller_id',$id)->whereDate('created_at', $date->format('Y-m-d'))
                    ->sum('income_amount');
            }
        } elseif ($period == 30) {
            $labels = [];
            for ($i = 29; $i >= 0; $i--) {
                $date = $now->copy()->subDays($i);
                $labels[] = $date->format('Y-m-d'); // ISO date
                $data[] = SellerIncome::where('seller_id',$id)->whereDate('created_at', $date->format('Y-m-d'))
                    ->sum('income_amount');
            }
        } elseif ($period == 365) {
            $labels = [];
            for ($i = 11; $i >= 0; $i--) {
                $date = $now->copy()->subMonthsNoOverflow($i);
                $labels[] = $date->format('M Y'); // Month and Year
                $data[] = SellerIncome::where('seller_id',$id)->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->sum('income_amount');
            }
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }

















}
