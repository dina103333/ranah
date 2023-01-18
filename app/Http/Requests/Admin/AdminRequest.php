<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'يجب ادخال البريد الالكترونى .',
            'password.required' => 'يجب ادخال كلمه المرور .',
            'email.email' => 'يجب ادخال البريد الاكترونى بشكل صحيح .',
        ];
    }
}
