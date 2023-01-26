<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            "reorder_limit"             => 'required',
            "lower_limit"               => 'required',
            "max_limit"                 => 'required',
            "sell_wholesale_price"      => 'required',
            "sell_item_price"           => 'required',
        ];
    }

    public function messages()
    {
        return [
            'reorder_limit.required' => 'يجب ادخال حد اعاده الطلب .',
            'lower_limit.unique' => 'يجب ادخال الحد الادنى .',
            'max_limit.required' => 'يجب ادخال الحد الاقصى .',
            'sell_wholesale_price.required' =>'يجب ادخال سعر البيع جمله .',
            'sell_item_price.required' => 'يجب ادخال سعر البيع قطاعى .',
        ];
    }
}
