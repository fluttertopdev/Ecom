<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use Google\Client;
use Google\Service\Drive;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\OrderProduct;

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
    // Today's Orders Quantity (sum of qty for orders placed today)
    $todayOrdersQty = OrderProduct::whereDate('created_at', today())->sum('order_quantity');  // Assuming 'qty' is the field for product quantity

    // Today's Sale Amount (total sale amount for orders placed today)
    $todaySale = OrderProduct::whereDate('created_at', today())->sum('order_total'); // Adjust 'price' to your actual field name for the sale amount

    // Total Orders Quantity (sum of qty for all orders ever placed)
    $totalOrdersQty = OrderProduct::sum('order_quantity');  // Summing 'qty' across all orders

    // Total Sale Amount (total sale amount for all orders ever placed)
    $totalSale = OrderProduct::sum('order_total'); // Adjust 'price' to your actual field name for the sale amount
    $totalProduct = Product::count();
    $totalCategory = Category::count();
    $totalUser = User::where('type', 'customer')->count();
    $totalsellers = User::where('type', 'seller')->count();

    // Pass data to the view
    return view('admin.dashboard.index', [
        'todayOrdersQty' => $todayOrdersQty,
        'todaySale' => $todaySale,
        'totalOrdersQty' => $totalOrdersQty,
        'totalSale' => $totalSale,
         'totalProduct' => $totalProduct,
          'totalCategory' => $totalCategory,
           'totalUser' => $totalUser,
            'totalsellers' => $totalsellers,
    ]);
}
}
