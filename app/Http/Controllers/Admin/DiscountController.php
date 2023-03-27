<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DiscountRequest;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Store;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DiscountController extends Controller
{
    public function index(){
        if(!in_array(119,permissions())){
            abort(403);
        }
       $discounts =Discount::orderBy('id','desc')->paginate(10);
       return view('admin.dicounts.index',compact('discounts'));
    }

    public function getDiscounts(){
        $discounts =Discount::orderBy('id','desc')->get();
        return datatables($discounts)->make(true);
    }

    public function create(){
        if(!in_array(120,permissions())){
            abort(403);
        }
        $status = Discount::getEnumValues('discounts','status');
        $types = Discount::getEnumValues('discounts','type');
        $stores = Store::where('status','تفعيل')->select('id','name')->get();
        return view('admin.dicounts.create',compact('status','types','stores'));
    }

    public function store(DiscountRequest $request){
        Discount::create([
            'store_id'  => $request->store_id,
            'type'      => $request->type,
            'value'     => $request->discount_value,
            'ratio'     => $request->discount_ratio,
            'from'      => $request->start_date,
            'to'        => $request->end_date,
            'status'    => $request->status,
            'active'    => $request->type == 'مؤجل' ? false : true ,
        ]);

        return redirect()->route('admin.discounts.index')->with('success','تم اضافه الخصم بنجاح');
    }

    public function edit(Discount $discount){
        if(!in_array(121,permissions())){
            abort(403);
        }
        $status = Discount::getEnumValues('discounts','status');
        $types = Discount::getEnumValues('discounts','type');
        $stores = Store::where('status','تفعيل')->select('id','name')->get();
        return view('admin.dicounts.edit',compact('discount','status','types','stores'));
    }

    public function update(Request $request,Discount $discount){
        $discount->update([
            'store_id'  => $request->store_id,
            'type'      => $request->type,
            'value'     => $request->discount_value,
            'ratio'     => $request->discount_ratio,
            'from'      => $request->start_date,
            'to'        => $request->end_date,
            'status'    => $request->status,
            'active'    => $request->type == 'مؤجل' ? false : true ,
        ]);
        return redirect()->route('admin.discounts.index')->with('success','تم تعديل الخصم بنجاح');
    }

    public function delete(Discount $discount){
        if(!in_array(122,permissions())){
            abort(403);
        }
        $discount->delete();
    }

    public function convertToDirectOrder(){
        $discounts = Discount::where('type','مؤجل')->where('status','تفعيل')->where('from','<=',Carbon::now())->where('to','>=',Carbon::now());

        $orders = Order::whereIn('discount_id',$discounts->pluck('id')->toArray())->pluck('user_id')->toArray();

        $wallets = Wallet::whereIn('user_id',array_unique($orders))->get();
        foreach($wallets as $wallet){
            $wallet->update([
                'value' => $wallet->value + $wallet->hold_value,
                'hold_value' => 0
            ]);
        }
        $discounts->update(['type'=>'فورى']);
    }
}
