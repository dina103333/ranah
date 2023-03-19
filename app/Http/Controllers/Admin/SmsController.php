<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendSmsJob;
use App\Models\Area;
use App\Models\Shop;
use App\Models\Sms;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sms = Sms::join('users','users.id','sms_messages.to_user_id')
        ->join('admins','admins.id','sms_messages.from_admin_id')
        ->select('admins.name as admin_name','users.name as user_name','sms_messages.id','sms_messages.message'
        ,\DB::raw('DATE_FORMAT(sms_messages.created_at, "%Y-%m-%d %H:%i:%s") AS created_at_formatted'))
        ->orderBy('sms_messages.created_at','desc')
        ->paginate(10);
        return view('admin.sms.index',compact('sms'));
    }

    public function getSms()
    {
        $sms = Sms::join('users','users.id','sms_messages.to_user_id')
        ->join('admins','admins.id','sms_messages.from_admin_id')
        ->select('admins.name as admin_name','users.name as user_name','sms_messages.id','sms_messages.message'
        ,\DB::raw('DATE_FORMAT(sms_messages.created_at, "%Y-%m-%d %H:%i:%s") AS created_at_formatted'))
        ->orderBy('sms_messages.created_at','desc')
        ->get();
        return datatables($sms)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('active',true)->where('status','تفعيل')->get();
        $areas = Area::where('status','تفعيل')->get();
        return view('admin.sms.create',compact('users','areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $users = User::where('active',true)->where('status','تفعيل')->get();

        if($request->option == 'users'){
            $users = User::whereIn('id',$request->user_id)->get();
        }
        if($request->option == 'online'){
            $users = User::where('type','اونلاين')->get();
        }
        if($request->option == 'direct'){
            $users = User::where('type','مباشر')->get();
        }
        if($request->option == 'area'){
            $shops = Shop::whereIn('area_id',$request->area_id)->pluck('id');
            $users = User::whereIn('shop_id',$shops)->get();
        }
        if($request->option == 'active_users'){
            $startDate = Carbon::parse('2023-03-01');
            $endDate =Carbon::now();
            $orderCountThreshold = 5;

            $users = User::has('orders', '>=', $orderCountThreshold)
                ->whereHas('orders', function ($query) use ($startDate, $endDate)  {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                })
            ->get();
        }
        if($request->option == 'unactive_users'){
            $startDate = Carbon::parse('2023-03-01');
            $endDate =Carbon::now();
            $orderCountThreshold = 5;

            $users = User::has('orders', '<=', $orderCountThreshold)
                ->whereHas('orders', function ($query) use ($startDate, $endDate)  {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                })
            ->get();
        }
        foreach($users as $user){
            Sms::create([
                'from_admin_id' => auth()->user()->id,
                'to_user_id' => $user->id,
                'message' =>$request->message,
            ]);
            dispatch(new SendSmsJob($user->mobile_number,$request->message));
        }
        return redirect()->route('admin.sms.index')->with('success','تم ارسال الرسائل النصيه بنجاح');
    }

    public function resendSms(Request $request)
    {
        $sms = Sms::where('id',$request->id)->first();
        Sms::create([
            'from_admin_id' => auth()->user()->id,
            'to_user_id' => $sms->to_user_id,
            'message' =>$sms->message,
        ]);
        $user = User::where('id',$sms->to_user_id)->first();
        dispatch(new SendSmsJob($user->mobile_number));
    }
}
