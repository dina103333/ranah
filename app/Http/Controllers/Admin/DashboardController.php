<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Order;
use App\Models\ProductComment;
use App\Models\Receipt;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $users =  count(User::where('status','تفعيل')->get());
        $online_orders =  count(Order::where('type','اونلاين')->get());
        $direct_orders =  count(Order::where('type','مباشر')->get());
        $amount_of_orders =  Order::get()->sum('total');
        $receipts =  count(Receipt::get());
        $complaints =  count(Complaint::get());
        $product_complaints =  count(ProductComment::get());


        $completed_orders = \DB::select(\DB::raw("
            SELECT DATE_FORMAT(orders.created_at,'%M') as month ,
            SUM(orders.total) As orders_sum FROM orders
            WHERE YEAR(orders.created_at) = YEAR(CURRENT_DATE())
            GROUP BY DATE_FORMAT(orders.created_at,'%M') ORDER BY DATE_FORMAT(orders.created_at,'%M') asc
        "));
        // return $completed_orders;
        return view('admin.dashboard',compact('users','online_orders','direct_orders','receipts','complaints','product_complaints','completed_orders','amount_of_orders'));
    }
}
