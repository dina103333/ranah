<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ShopTypeRequest extends FormRequest
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
            'name'      =>   'required',
            'status'    =>  'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال اسم نوع المحل .',
            'status.required' => 'يجب اختيار الحاله .',
        ];
    }
}
