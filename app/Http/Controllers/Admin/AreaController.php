<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AreaRequest;
use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = Area::latest()->paginate('10');
        return view('admin.area.index',compact('areas'));
    }

    public function getAreas()
    {
        $areas = Area::latest()->select('id','name', 'status');
        return datatables($areas)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = Area::getEnumValues('areas','status');
        return view('admin.area.create',compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AreaRequest $request)
    {
        Area::create([
            'name' =>$request->name,
            'status' =>$request->status,
        ]);

        return redirect()->route('admin.areas.index')->with('success','تم اضافه منطقه بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        $status = Area::getEnumValues('areas','status');
        return view('admin.area.edit',compact('status','area'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(AreaRequest $request, Area $area)
    {
        $area->update([
            'name' =>$request->name,
            'status' =>$request->status,
        ]);

        return redirect()->route('admin.areas.index')->with('success','تم تعديل المنطقه بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        $area->delete();
    }

    public function multiAreasDelete(Request $request)
    {
        $ids = $request->ids;
        Area::whereIn('id',explode(",",$ids))->delete();

        return response()->json(['status' => true, 'message' => "Records deleted successfully."]);
    }
}
