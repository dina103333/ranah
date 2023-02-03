<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Area;
use App\Models\Shop;
use App\Models\ShopType;
use App\Models\User;
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
        $user = User::create([
            'name' => $request->name,
            'mobile_number' => $request->mobile_number,
            'password' => bcrypt($request->password),
            'status' => $request->status,
            'type' => 'مباشر',
        ]);

        $shop = Shop::create([
            'name' => $request->shop_name,
            'user_id' => $user->id,
            'address' => $request->address,
            'shop_types_id' => $request->shop_type_id,
            'area_id' => $request->area_id
        ]);
        $user->update(['shop_id'=>$shop->id]);
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
        return view('users.show', compact('user'));
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
        $user->update([
            'name' => $request->name,
            'mobile_number' => $request->mobile_number,
            'password' => $request->password != 'null' ? bcrypt($request->password) : $user->password ,
            'status' => $request->status,
            'type' => 'مباشر',
        ]);
        if($request->status == 'حظر')
            $user->update(['active' => 0]);
        $shop= Shop::find($user->shop_id);
        $shop->update([
            'name' => $request->shop_name,
            'user_id' => $user->id,
            'address' => $request->address,
            'shop_types_id' => $request->shop_type_id,
            'area_id' => $request->area_id
        ]);
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
        User::whereIn('id',explode(",",$ids))->delete();

        return response()->json(['status' => true, 'message' => "Records deleted successfully."]);
    }
}
