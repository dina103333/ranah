<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $image = request()->isMethod('put') ? 'nullable|mimes:jpeg,jpg,png,gif,svg|max:8000' : 'required|mimes:jpeg,jpg,png,gif,svg|max:8000';
        return [
            'company_id'                => 'required',
            'category_id'               => 'required',
            'name'                      => 'required',
            'wholesale_type'            => 'required',
            'item_type'                 => 'required',
            'wholesale_quantity_units'  => 'required',
            'description'               => 'required',
            'image'                     => $image,
            'selling_type'              => 'required',
            'wating'                    => 'required',
            'status'                    => 'required',
        ];
    }

    public function messages()
    {
        return [
            'company_id.required' => 'يجب اختيار الشركه  .',
            'category_id.required' => 'يجب اختيار الفئه .',
            'name.required' => 'يجب ادخال اسم المنتج .',
            'wholesale_type.required' => 'يجب ادخال نوع الوحدة .',
            'item_type.required' => 'يجب ادخال نوع القطعه الواحده .',
            'wholesale_quantity_units.required' => 'يجب ادخال كمية الوحده .',
            'description.required' => 'يجب ادخال التفاصيل .',
            'wholesale_max_quantity.required' => 'يجب ادخال اقصي كميه متاحه .',
            'image.required' => 'يجب ادخال صوره للمنتج .',
            'selling_type.required' => 'يجب اختيار طريقة البيع .',
            'wating.required' => 'يجب اختيار وضع المنتج في قائمه الانتظار .',
            'status.required' => 'يجب اختيار تفعيل المنتج  .',
            'product_quantity.required' => 'يجب اختيار تحديد كميه للمنتج .',
        ];
    }
}
