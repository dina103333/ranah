<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Driver\DriverResource;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class DriverController extends Controller
{
    use ApiResponse;

    public function driverInfo(Request $request){
        return $this->successSingle('تم بنجاح',DriverResource::make($request->user()),200);
    }

    public function UpdateDriver(Request $request)
    {
        $request->user()->update([
            'name' => $request->name ? $request->name : $request->user()->name,
            'password' => $request->password ? bcrypt($request->password) : $request->user()->password,
        ]);
        return $this->successSingle('تم تعديل البيانات بنجاح',[],200);
    }

    public function deactivateDriver(Request $request){
        $request->user()->update(['status' => 'حظر']);
        return $this->successSingle('تم بنجاح',[],200);
    }
}
