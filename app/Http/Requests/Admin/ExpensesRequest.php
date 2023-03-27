<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ExpensesRequest extends FormRequest
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
            'price' => 'numeric|required',
            'propose' => 'string|required',
        ];
    }

    public function messages()
    {
        return [
            'price.required' => 'يجب ادخال المبلغ المصروف.',
            'price.numeric' => 'يجب ان يكون المبلغ فى صيغه ارقام.',
            'propose.required' => 'يجب ادخال سبب الصرف.',
            'propose.string' => 'يجب ان تكون صيغه السبب حروف .',
        ];
    }
}
