<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PointRequest;
use App\Models\Point;
use Illuminate\Http\Request;

class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $points =Point::paginate(10);
        return view('admin.point.index',compact('points'));
    }

    public function getPoints(){
        $points =Point::get();
        return datatables($points)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = Point::getEnumValues('points','status');
        return view('admin.point.create',compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PointRequest $request)
    {
        Point::create([
            'point' => $request->point,
            'from' => $request->from,
            'to' => $request->to,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.points.index')->with('success','تم اضافه الخصم بنجاح');
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
    public function edit(Point $point)
    {
        $status = Point::getEnumValues('points','status');
        return view('admin.point.edit',compact('point','status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Point $point)
    {
        $point->update([
            'point' => $request->point,
            'from' => $request->from,
            'to' => $request->to,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.points.index')->with('success','تم تعديل الخصم بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Point $point)
    {
        $point->delete();
    }
}
