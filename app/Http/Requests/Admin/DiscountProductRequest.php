<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DiscountProductRequest extends FormRequest
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
            'store_id' => 'required',
            'status' => 'required',
            'type' => 'required',
            'product_id' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'store_id.required' => 'يجب اختيار مخزن',
            'type.required' => 'يجب اختيار النوع',
            'product_id.required' => 'يجب اختيار منتج',
            'status.required' => 'يجب اختيار الحاله .',
        ];
    }
}
