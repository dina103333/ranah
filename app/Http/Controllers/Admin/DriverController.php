<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DriversExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DriverRequest;
use App\Models\Driver;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = Driver::latest()->paginate('10');
        return view('admin.drivers.index',compact('drivers'));
    }

    public function getDrivers()
    {
        $drivers = Driver::latest()->select('id','name', 'mobile_number', 'address');
        return datatables($drivers)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = Driver::getEnumValues('drivers','status');
        return view('admin.drivers.create',compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DriverRequest $request)
    {
        $driver = Driver::create([
            'name' =>$request->name,
            'mobile_number' =>$request->mobile,
            'password' => bcrypt($request->password),
            'status' =>$request->status,
            'address' =>$request->address,
        ]);

        return redirect()->route('admin.drivers.index')->with('success','تم اضافه سائق بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show(Driver $driver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function edit(Driver $driver)
    {
        $status = Driver::getEnumValues('drivers','status');
        return view('admin.drivers.edit',compact('driver','status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Driver $driver)
    {
        $driver->update([
            'name' =>$request->name,
            'mobile_number' =>$request->mobile,
            'password' => $request->password ? bcrypt($request->password) : $driver->password,
            'status' =>$request->status,
            'address' =>$request->address,
        ]);

        return redirect(route('admin.drivers.index'))->with('success','تم تعديل سائق بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Driver $driver)
    {
        $driver->delete();
    }

    public function multiDriversDelete(Request $request)
    {
        $ids = $request->ids;
        Driver::whereIn('id',explode(",",$ids))->delete();

        return response()->json(['status' => true, 'message' => "Records deleted successfully."]);
    }

    public function export()
    {
        return Excel::download(new DriversExport, 'drivers.xlsx');
    }
}
