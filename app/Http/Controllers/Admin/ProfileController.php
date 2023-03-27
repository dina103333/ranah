<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(){
        return view('admin.profile.edit');
    }
    public function Update(Request $request){
        $admin = Admin::find(auth()->user()->id)->first();
        $admin->update([
            'name'=>$request->name ? $request->name : auth()->user()->name,
            'email'=>$request->email ? $request->email : auth()->user()->email,
            'password'=>$request->password ?bcrypt($request->password) : auth()->user()->password,
        ]);
        return redirect()->back()->with('success','تم تعديل البيانات بنجاح');
    }

}
