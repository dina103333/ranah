<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'parent_id' => 'required',
            'image' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال اسم الفئه  .',
            'status.required' => 'يجب ادخال حاله الفئه .',
            'parent_id.required' => 'يجب اختيار الفئه الرئيسيه .',
            'image.required' => 'يجب اخيتيار صوره للفئه .',
        ];
    }
}
