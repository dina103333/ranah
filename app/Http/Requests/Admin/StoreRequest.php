<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        return [
            "name"                  => 'required',
            "area_id"               => 'required',
            "address"               => 'required',
            "longitude"             => 'required',
            "latitude"              => 'required',
            "storekeepers"          => 'required',
            "storekeeper_id"        => 'required',
            "finance_officers"      => 'required',
            "finance_officer_id"    => 'required',
            "sales"                 => 'required',
            "status"                => 'required',
        ];
    }

    public function messages()
    {
        return [
            "name.required"                  =>  'يجب ادخال اسم المخزن .',
            "area_id.required"               =>  'يجب تحديد المنطقه .',
            "address.required"               =>  'يجب ادخال عنوان المخزن .',
            "longitude.required"             =>  'يجب ادخال خطوط الطول .',
            "latitude.required"              =>  'يجب ادخال دوائر العرض .',
            "storekeepers.required"          =>  'يجب تحديد امناء العهد .',
            "storekeeper_id.required"        =>  'يجب تحديد امين العهدة الحالي .',
            "finance_officers.required"      =>  'يجب تحديد مسؤولين الماليه .',
            "finance_officer_id.required"    =>  'يجب تحديد مسؤول الماليه الحالى .',
            "sales.required"                 =>  'يجب تحديد  البائعين .',
            "status.required"                =>  'يجب تحديد الحاله .',

        ];
    }
}
