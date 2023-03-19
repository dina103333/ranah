<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use App\Http\Resources\Api\WalletResource;
use App\Models\Shop;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletValue;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use ApiResponse;
    public function getUserInfo(Request $request)
    {
        $user = User::where('id',$request->user()->id)->with('shop.area','shop.type','shop.car')->first();
        return $this->successSingle('تم بنجاح',UserResource::make($user),200);
    }

    public function UpdateUser(Request $request)
    {
        $shop = Shop::where('id',$request->user()->shop_id)->first();
        $request->user()->update([
            'name' => $request->name ? $request->name : $request->user()->name,
            'mobile_number' => $request->user()->mobile_number,
            'password' => $request->password ? bcrypt($request->password) : $request->user()->password,
            'seconde_mobile_number' => $request->seconde_mobile_number ? $request->seconde_mobile_number : $request->user()->seconde_mobile_number,
        ]);
        $request->file('shop_image') ? $file= Storage::disk('public')->put('shop'.$request->user()->id , $request->file('shop_image')) : $file='';
        $shop->update([
            "name" => $request->shop_name ? $request->shop_name : $shop->name,
            "address"=> $request->shop_address ? $request->shop_address : $shop->address,
            "longitude"=> $request->user()->change_location == true ?($request->shop_longitude ? $request->shop_longitude : $shop->longitude):$shop->longitude,
            "latitude"=> $request->user()->change_location == true ?($request->shop_latitude ? $request->shop_latitude : $shop->latitude):$shop->latitude,
            "from"=> $request->shop_from ? $request->shop_from : $shop->from,
            "to"=> $request->shop_to? $request->shop_to : $shop->to,
            "image"=> $request->file('shop_image') ? $file : $shop->image,
            'shop_types_id' => $request->shop_types_id ? $request->shop_types_id : $shop->shop_types_id,
            "car_id"=>$request->shop_car_id ? $request->shop_car_id : $shop->car_id,
            "area_id"=>$request->shop_area_id ? $request->shop_area_id : $shop->area_id,
        ]);
        return $this->successSingle('تم تعديل البيانات بنجاح',[],200);
    }

    public function deactiveUser(Request $request){
        $request->user()->update(['status' => 'حظر','active' =>false]);
        return $this->successSingle('تم بنجاح',[],200);
    }

    public function getWalletValue(Request $request){
        $wallet = Wallet::where('user_id',$request->user()->id)->with('values')->first();
        return $this->successSingle('تم بنجاح',WalletResource::make($wallet),200);
    }

}
