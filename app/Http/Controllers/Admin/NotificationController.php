<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendFCMNotificationJob;
use App\Models\Area;
use App\Models\Company;
use App\Models\NotifyUser;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = NotifyUser::join('users','users.id','notify_users.user_id')
        ->join('admins','admins.id','notify_users.admin_id')
        ->leftJoin('products','products.id','notify_users.product_id')
        ->leftJoin('companies','companies.id','notify_users.company_id')
        ->select('admins.name as admin_name','companies.name as company_name','users.name as user_name','notify_users.id','products.name as product_name','notify_users.message'
        ,'notify_users.title',\DB::raw('DATE_FORMAT(notify_users.created_at, "%Y-%m-%d %H:%i:%s") AS created_at_formatted'))
        ->orderBy('notify_users.created_at','desc')
        ->paginate(10);
        return view('admin.notification.index',compact('notifications'));
    }

    public function getNotifications(){
        $notifications = NotifyUser::join('users','users.id','notify_users.user_id')
        ->join('admins','admins.id','notify_users.admin_id')
        ->leftJoin('products','products.id','notify_users.product_id')
        ->leftJoin('companies','companies.id','notify_users.company_id')
        ->select('admins.name as admin_name','companies.name as company_name','users.name as user_name','notify_users.id','products.name as product_name','notify_users.message'
        ,'notify_users.title',\DB::raw('DATE_FORMAT(notify_users.created_at, "%Y-%m-%d %H:%i:%s") AS created_at_formatted'))
        ->orderBy('notify_users.created_at','desc')
        ->get();
        return datatables($notifications)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('active',true)->where('type','اونلاين')->where('status','تفعيل')->get();
        $products = Product::where('status','تفعيل')->get();
        $areas = Area::where('status','تفعيل')->get();
        $companies = Company::where('status','تفعيل')->get();
        return view('admin.notification.create',compact('users','products','areas','companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = $request->product_id != null ? Product::where('id',$request->product_id)->select('image','name')->first() : '';
        $company = $request->company_id != null ? Company::where('id',$request->company_id)->select('image','name')->first() : '';
        $title = $request->title;
        $body = $request->message;
        $type =$request->product_id != null ? 'product' : ($request->company_id != null ? 'company' :'notification');
        $id = $request->product_id != null ? $request->product_id : ($request->company_id != null ? $request->company_id : 0);
        $name = $request->product_id != null ? $product->name : ($request->company_id != null ? $company->name : ' ');
        $image = $request->product_id != null ? url('/storage/'.$product->image) : ($request->company_id != null ? url('/storage/'.$company->image) : url('/storage/files/logo.png'));

        $users = User::where('active',true)->where('status','تفعيل')->get();

        if($request->option == 'users'){
            $users = User::whereIn('id',$request->user_id)->get();
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
            NotifyUser::create([
                'admin_id' => auth()->user()->id,
                'user_id' => $user->id,
                'message' =>$request->message,
                'title' =>$request->title,
                'product_id' => $request->product_id != null ? $request->product_id : null,
                'company_id' => $request->company_id != null ? $request->company_id : null,
            ]);
        }
        $devices = $users->pluck('device_token')->toArray();
        dispatch(new SendFCMNotificationJob($devices, $title, $body,$type,$id,$name,$image));
        return redirect()->route('admin.notifications.index')->with('success','تم ارسال الاشعارات بنجاح');
    }

    public function resendNotification(Request $request){
        $notification = NotifyUser::where('id',$request->id)->first();
        $product_image = $notification->product_id != null ?? Product::where('id',$notification->product_id)->select('image')->first() ;
        $users = User::where('id',$notification->user_id)->get();
        $title = $notification->title;
        $body = $notification->message;
        $type =$request->notification != null ? 'product' : ($notification->company_id != null ? 'company' :'notification');
        $id = $notification->product_id != null ? $notification->product_id : ($notification->company_id != null ? $notification->company_id : 0);
        $image = $notification->product_id != null ? url('/storage/'.$product_image) : url('/storage/files/logo.png') ;
        NotifyUser::create([
            'admin_id' => auth()->user()->id,
            'user_id' => $notification->user_id,
            'message' =>$notification->message,
            'title' =>$notification->title,
            'product_id' => $notification->product_id,
            'company_id' => $notification->company_id,
        ]);
        $devices = $users->pluck('device_token')->toArray();
        dispatch(new SendFCMNotificationJob($devices, $title, $body,$type,$id,$image));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
