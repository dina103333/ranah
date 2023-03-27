<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $rules = [
            'name' => 'required|max:255',
            'mobile_number' => ['required','string','digits:11','regex:/^[0-9]+$/',
                                Rule::unique('users')->ignore($this->user)],
            'shop_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'area_id' => 'required',
            'shop_type_id' => 'required',
            "longitude"             => 'required',
            "latitude"              => 'required',
        ];
        if($this->method()=="POST"){
            $rules['password']='required|min:6';
           }
          return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال الاسم',
            'mobile_number.required' => 'رقم الهاتف مطلوب',
            'mobile_number.digits' => '  رقم الهاتف يجب ان لا يقل عن 11 رقم',
            'mobile_number.regex' => '  رقم الهاتف يجب ان يكون ارقام فقط',
            'mobile_number.unique' => '  رقم الهاتف مأخوذ مسبقا',
            'password.required' => 'كلمه المرور مطلوبه',
            'password.min' => 'كلمه المرور يجب ان لا تقل عن 6 احرف',
            'shop_name.required' => 'اسم المحل مطلوب',
            'address.required' => 'عنوان المحل مطلوب',
            'area_id.required' => 'المنطقه مطلوبه',
            'shop_type_id.required' => 'نوع المحل مطلوب',
            "longitude.required"             => 'يجب ادخال خطوط الطول',
            "latitude.required"              => 'يجب ادخال دوائر العرض',
        ];
    }
}
