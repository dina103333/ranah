<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PointRequest extends FormRequest
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
            'point' =>'required',
            'from' =>'required',
            'to' =>'required',
            'status' =>'required',
        ];
    }

    public function messages()
    {
        return [
            'point.required' => 'يجب ادخال عدد النقاط.',
            'from.required' => 'يجب ادخال من قيمه طلب .',
            'to.required' => 'يجب ادخال الى قيمه الطلب .',
            'status.required' => 'يجب اختيار الحاله .',
        ];
    }
}
