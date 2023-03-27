<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderRequest;
use App\Http\Requests\Admin\UpdateSliderRequest;
use App\Models\Product;
use App\Models\Slider;
use App\Models\SliderImage;
use App\Models\SliderProduct;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!in_array(87,permissions())){
            abort(403);
        }
        $sliders = Slider::paginate('10');
        return view('admin.slider.index',compact('sliders'));
    }

    public function getSliders()
    {
        $sliders = Slider::get();
        return datatables($sliders)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!in_array(86,permissions())){
            abort(403);
        }
        $products = Product::where('status', 'تفعيل')->select('id','name')->get();
        $types = Slider::getEnumValues('sliders','type');
        return view('admin.slider.create',compact('types','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderRequest $request)
    {
        $file = $request->file('image')->store('public/files');
        $filepath=explode('/',$file);
        $slider = Slider::create([
            'type' =>$request->type,
            'image' => $filepath[1].'/'.$filepath[2],
        ]);
        foreach($request->products as $product) {
            SliderProduct::create([
                'slider_id' => $slider->id,
                'product_id' => $product,
            ]);
        }
        return redirect()->route('admin.sliders.index')->with('success','تم اضافه اسليدر بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        if(!in_array(88,permissions())){
            abort(403);
        }
        $products = Product::where('status', 'تفعيل')->select('id','name')->get();
        $types = Slider::getEnumValues('sliders','type');
        $slider_products = $slider->products()->select('products.id')->pluck('products.id')->toArray();
        return view('admin.slider.edit',compact('products','slider','types','slider_products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSliderRequest $request, Slider $slider)
    {
        if($request->image){
            $file = $request->file('image')->store('public/files');
            $filepath=explode('/',$file);
        }
        $slider->update([
            'type' => $request->type,
            'image'=> $request->image ? $filepath[1].'/'.$filepath[2] : $slider->image,
        ]);
        SliderProduct::where('slider_id',$slider->id)->delete();
        foreach($request->products as $product) {
            SliderProduct::create([
                'slider_id' => $slider->id,
                'product_id' => $product,
            ]);
        }
        return redirect()->route('admin.sliders.index')->with('success','تم تعديل الاسليدر بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        if(!in_array(89,permissions())){
            abort(403);
        }
        SliderProduct::where('slider_id',$slider->id)->delete();
        $slider->delete();
    }

    public function multiSlidersDelete(Request $request)
    {
        if(!in_array(89,permissions())){
            abort(403);
        }
        $ids = $request->ids;
        SliderProduct::whereIn('slider_id',explode(",",$ids))->delete();
        Slider::whereIn('id',explode(",",$ids))->delete();
        return response()->json(['status' => true, 'message' => "Records deleted successfully."]);
    }
}
