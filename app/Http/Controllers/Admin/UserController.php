<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Jobs\SendFCMNotificationJob;
use App\Models\Area;
use App\Models\Complaint;
use App\Models\NotifyUser;
use App\Models\Shop;
use App\Models\ShopType;
use App\Models\Store;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('add','shop.area','shop.type')->where('status','!=','جديد')->paginate('10');
        return view('admin.users.index', compact('users'));
    }

    public function getUsers()
    {
        $users = User::with('add','shop.area','shop.type')->where('status','!=','جديد');
        return datatables($users)->make(true);
    }

    public function changeStatus(Request $request){
        $user = User::where('id',$request->id)->first();
        if($user->status == 'تفعيل'){
            $user->update(['status' => 'حظر']);
        }else{
            $user->update(['status' => 'تفعيل']);
        }
        $type = 'client_status';
        $title = 'اشعار بحاله العميل';
        $body = 'تم تغيير حاله الحساب';
        $id = $request->id;
        $image = url('/storage/files/logo.png') ;
        $devices = User::where('id',$request->id)->where('type','اونلاين')->pluck('device_token')->toArray();
        if(count($devices) > 0)
            dispatch(new SendFCMNotificationJob($devices, $title, $body,$type,$id,null,$image));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shop_types = ShopType::where('status','تفعيل')->select('id','name')->get();
        $areas = Area::where('status','تفعيل')->select('id','name')->get();
        $status = User::getEnumValues('users','status');
        return view('admin.users.create',compact('shop_types','areas','status'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $store = Store::where('area_id',$request->area_id)->first();
        if(!$store)
            return redirect()->back()->with('error','لا يمكن انشاء عميل على هذه المنطقه لعدم توافر مخزن فيها');
        $user = User::create([
            'name' => $request->name,
            'mobile_number' => $request->mobile_number,
            'password' => bcrypt($request->password),
            'status' => $request->status,
            'type' => 'مباشر',
            'store_id' => $store->id,
            'change_location' => $request->change_location == "0" ? false : true,
        ]);

        $shop = Shop::create([
            'name' => $request->shop_name,
            'user_id' => $user->id,
            'address' => $request->address,
            'shop_types_id' => $request->shop_type_id,
            'area_id' => $request->area_id,
            'store_id' => $store->id,
        ]);
        $user->update(['shop_id'=>$shop->id]);

        if(empty($user->wallet)){
            Wallet::create([
                'user_id' => $user->id,
                'value' => 0,
                'hold_value' => 0,
                'hold_product_value' => 0
            ]);
        }
        return redirect()->route('admin.users.index')->with('success', 'تم اضافه مستخدم بنجاح');
    }

    /**
     * Display the specified user.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user = User::where('id',$user->id)->with(['shop'=>function($q)use($user){
            $q->where('id',$user->shop_id);
        }])->first();
        $shop_types = ShopType::where('status','تفعيل')->select('id','name')->get();
        $areas = Area::where('status','تفعيل')->select('id','name')->get();
        $status = User::getEnumValues('users','status');
        return view('admin.users.edit', compact('user','shop_types','areas','status'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $store = Store::where('area_id',$request->area_id)->first();
        if(!$store)
            return redirect()->back()->with('error','لا يمكن انشاء عميل على هذه المنطقه لعدم توافر مخزن فيها');
        $user->update([
            'name' => $request->name,
            'mobile_number' => $request->mobile_number,
            'password' => $request->password != null ? bcrypt($request->password) : $user->password ,
            'status' => $request->status,
            'type' => $user->type,
            'store_id' => $store->id,
            'change_location' => $request->change_location == "0" ? false : true,
        ]);
        if($request->status == 'حظر')
            $user->update(['active' => 0]);
        $shop= Shop::find($user->shop_id);
        $shop->update([
            'name' => $request->shop_name,
            'user_id' => $user->id,
            'address' => $request->address,
            'shop_types_id' => $request->shop_type_id,
            'area_id' => $request->area_id,
            'store_id' => $store->id,

        ]);
        if($request->area_id != $shop->area_id)
        {
            $type = 'update-user-store';
            $title = 'تغيير المنطقه';
            $body = 'تم تغيير منطقه العميل';
            $id = $user->id;
            $image = url('/storage/files/logo.png') ;
            $devices = User::where('id',$user->id)->where('type','اونلاين')->pluck('device_token')->toArray();
            if(count($devices) > 0)
                dispatch(new SendFCMNotificationJob($devices, $title, $body,$type,$id,null,$image));
        }
        return redirect()->route('admin.users.index')->with('success', 'تم تعديل مستخدم بنجاح');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }

    public function multiUsersDelete(Request $request)
    {
        $ids = $request->ids;
        Complaint::whereIn('user_id',explode(",",$ids))->delete();
        NotifyUser::whereIn('user_id',explode(",",$ids))->delete();
        User::whereIn('id',explode(",",$ids))->delete();

        return response()->json(['status' => true, 'message' => "Records deleted successfully."]);
    }

    public function deletePoints(Request $request){
        User::where('id',$request->user_id)->update(['points' => 0]);
    }
}
