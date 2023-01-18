<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddadminRequest extends FormRequest
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
            'email' => 'required|email|unique:admins,email',
            'name' => 'required',
            'mobile' => 'required|unique:admins,mobile_number',
            'password' => 'required',
            'role' => 'required',
            'status' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'يجب ادخال البريد الالكترونى .',
            'email.unique' => ' البريد الالكترونى مأخوذ مسبقا',
            'email.email' => 'يجب ادخال البريد الاكترونى بشكل صحيح .',
            'mobile.required' => 'يجب ادخال رقم الهاتف .',
            'mobile.unique' => '  رقم الهاتف مأخوذ مسبقا',
            'mobile.email' => 'يجب ادخال رقم الهاتف بشكل صحيح .',
            'name.required' => 'يجب ادخال الاسم .',
            'password.required' => 'يجب ادخال كلمه المرور .',
            'role.required' => 'يجب اخيار الدور .',
            'status.required' => 'يجب اخيار الحاله .',
        ];
    }
}
