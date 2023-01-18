<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'name' => 'required',
            'status' => 'required',
            'categories' => 'required',
            'image' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال اسم الشركه  .',
            'status.required' => 'يجب ادخال حاله الشركه .',
            'categories.required' => 'يجب اختيار الفئات الرئيسيه .',
            'image.required' => 'يجب اخيتيار صوره للشركه .',
        ];
    }
}
