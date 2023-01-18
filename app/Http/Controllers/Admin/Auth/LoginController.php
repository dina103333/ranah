<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    public function __construct()
    {
       $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function getLoginForm(){
        return view('admin.auth.login');
    }

    public function login(AdminRequest $request){
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended(route('admin.dashboard'));
         }
         return redirect()->back()->with('error','بيانات الاعتماد هذه غير متطابقة مع البيانات المسجلة لدينا.');
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}
