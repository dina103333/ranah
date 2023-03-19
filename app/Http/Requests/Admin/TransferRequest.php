<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
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
            'to_store_id' => 'required',
            'driver_id' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'to_store_id.required' => 'يجب اختيار المخزن المنقول اليه.',
            'driver_id.unique' => 'يجب اختيار المندوب .',
        ];
    }
}
