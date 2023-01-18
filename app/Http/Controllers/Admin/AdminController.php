<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddadminRequest;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\PermissionRole;
use App\Models\PermissionUser;
use App\Models\Role;
use Yajra\DataTables\Html\Editor\Fields\Checkbox;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admins = Admin::with('role')->paginate('10');
        return view('admin.admin.index',compact('admins'));
    }

    public function getAdmins()
    {
        $admins = Admin::with('role')->select('admins.id','admins.name', 'mobile_number', 'email','role_id');
        return datatables($admins)->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('status','تفعيل')->select('id','name')->get();
        $status = Admin::getEnumValues('admins','status');
        return view('admin.admin.create',compact('roles','status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddadminRequest $request)
    {
        $admin = Admin::create([
            'name' =>$request->name,
            'email' =>$request->email,
            'mobile_number' =>$request->mobile,
            'password' => bcrypt($request->password),
            'role_id' =>$request->role,
            'status' =>$request->status,
        ]);
        $permissions = PermissionRole::where('role_id',$request->role)->pluck('permission_id');
        foreach($permissions as $permission){
            PermissionUser::create([
                'permission_id' => $permission,
                'admin_id' => $admin->id,
            ]);
        }
        return redirect()->route('admin.officials.index')->with('success','تم اضافه مسؤول بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($admin)
    {
        $roles = Role::where('status','تفعيل')->get();
        $admin = Admin::find($admin);
        $status = Admin::getEnumValues('admins','status');
        return view('admin.admin.edit',compact('roles','admin','status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$admin)
    {
        $admin = Admin::find($admin);
        $admin->update([
            'name' =>$request->name,
            'email' =>$request->email,
            'mobile_number' =>$request->mobile,
            'password' => $request->password ? bcrypt($request->password) : $admin->password,
            'role_id' =>$request->role,
            'status' =>$request->status,
        ]);
        PermissionUser::where('admin_id',$admin->id)->delete();
        $permissions = PermissionRole::where('role_id',$admin->role_id)->pluck('permission_id');
        foreach($permissions as $permission){
            PermissionUser::create([
                'permission_id' => $permission,
                'admin_id' => $admin->id,
            ]);
        }
        return redirect(route('admin.officials.index'))->with('success','تم تعديل مسؤول بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PermissionUser::where('admin_id',$id)->delete();
        Admin::find($id)->delete();
    }

    public function multiAdminDelete(Request $request)
    {
        $ids = $request->ids;
        Admin::whereIn('id',explode(",",$ids))->delete();

        return response()->json(['status' => true, 'message' => "Records deleted successfully."]);
    }

}
