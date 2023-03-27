<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function bestSellingProducts()
    {
        if(!in_array(171,permissions())){
            abort(403);
        }
        $products = DB::table('orders')
                        ->join('orders_products', 'orders.id', '=', 'orders_products.order_id')
                        ->join('products', 'orders_products.product_id', '=', 'products.id')
                        ->select('products.id', 'products.name',
                         DB::raw('SUM(orders_products.current_unit_quantity +orders_products.current_wholesale_quantity) as total_sold'))
                        ->groupBy('products.id', 'products.name')
                        ->orderBy('total_sold', 'DESC')
                        ->paginate(10);
        return view('admin.report.best-selling-products', compact('products'));
    }
    public function getBestSellingProducts()
    {
        $products = DB::table('orders')
                        ->join('orders_products', 'orders.id', '=', 'orders_products.order_id')
                        ->join('products', 'orders_products.product_id', '=', 'products.id')
                        ->select('products.id', 'products.name',
                        DB::raw('SUM(orders_products.current_unit_quantity + orders_products.current_wholesale_quantity) as total_sold'))
                        ->groupBy('products.id', 'products.name')
                        ->orderBy('total_sold', 'DESC');
        return datatables($products)->make(true);
    }


    public function productsOrderTotal()
    {
        if(!in_array(171,permissions())){
            abort(403);
        }
        $products = DB::table('orders')
                        ->join('orders_products', 'orders.id', '=', 'orders_products.order_id')
                        ->join('products', 'orders_products.product_id', '=', 'products.id')
                        ->select('products.id', 'products.name',
                                DB::raw('SUM(orders_products.current_unit_quantity + orders_products.current_wholesale_quantity) as total_sold'),
                                DB::raw('COUNT(DISTINCT orders.id) as total_orders'))
                        ->groupBy('products.id', 'products.name')
                        ->orderBy('total_sold', 'DESC')
                        ->paginate(10);

        return view('admin.report.product_orders', compact('products'));
    }

    public function getProductsOrderTotal()
    {
        $products = DB::table('orders')
                        ->join('orders_products', 'orders.id', '=', 'orders_products.order_id')
                        ->join('products', 'orders_products.product_id', '=', 'products.id')
                        ->select('products.id', 'products.name',
                                DB::raw('SUM(orders_products.current_unit_quantity + orders_products.current_wholesale_quantity) as total_sold'),
                                DB::raw('COUNT(DISTINCT orders.id) as total_orders'))
                        ->groupBy('products.id', 'products.name')
                        ->orderBy('total_sold', 'DESC');

        return datatables($products)->make(true);
    }

    public function earningOrder()
    {
        if(!in_array(171,permissions())){
            abort(403);
        }
        $earnings = DB::table('orders')
                        ->rightJoin('stores','stores.id' , 'orders.store_id')
                        ->select('stores.id', 'stores.name',
                                DB::raw('SUM(orders.total - orders.total_cost ) as earnings'))
                        ->groupBy('stores.id')
                        ->paginate(10);

        // return $earnings;

        return view('admin.report.earning_stores', compact('earnings'));
    }

    public function getEarningOrder()
    {
        $earnings = DB::table('orders')
                        ->rightJoin('stores','stores.id' , 'orders.store_id')
                        ->select('stores.id', 'stores.name',
                                DB::raw('SUM(orders.total - orders.total_cost ) as earnings'))
                        ->groupBy('stores.id');

        return datatables($earnings)->make(true);
    }
}
