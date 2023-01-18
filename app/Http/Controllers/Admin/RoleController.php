<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Admin;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::get();
        return view('admin.role.index',compact('roles'));
    }

    public function getRoles()
    {
        $roles = Role::get();
        return datatables($roles)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::get();
        $permissions = Permission::select('id','group_id','display_name','dispaly_name_ar')->get();
        $status = Role::getEnumValues('roles','status');
        return view('admin.role.create',compact('permissions','groups','status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $role =  Role::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);
        if($request->permissions){
            foreach($request->permissions as $permission){
                PermissionRole::create([
                    'permission_id' => $permission,
                    'role_id'=> $role->id
                ]);
            }
        }

        return redirect()->route('admin.roles.index')->with('success','تم اضافه الدور بنجاح');
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
        $groups = Group::get();
        $permissions = Permission::select('id','group_id','display_name','dispaly_name_ar')->get();
        $role = Role::with('permissions')->where('id',$id)->first();
        $role_permissions = PermissionRole::where('role_id',$id)->pluck('permission_id')->toArray();
        $status = Role::getEnumValues('roles','status');
        return view('admin.role.edit',compact('permissions','groups','role','role_permissions','status'));
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
        $role =  Role::find($id);
        $role->update([
            'name' =>$request->name,
            'status' =>$request->status,
        ]);
        PermissionRole::where('role_id',$id)->delete();
        if($request->permissions){
            foreach($request->permissions as $permission){
                PermissionRole::create([
                    'permission_id' => $permission,
                    'role_id'=> $id
                ]);
            }
        }
        return redirect()->route('admin.roles.index')->with('success','تم تعديل الدور بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PermissionRole::where('role_id',$id)->delete();
        Admin::where('role_id',$id)->update(['role_id'=>null]);
        Role::find($id)->delete();
    }
}
