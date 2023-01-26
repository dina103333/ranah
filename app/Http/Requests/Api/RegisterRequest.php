<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
            'name' => 'required|max:255',
            'mobile_number'=>'string|required|digits:11|regex:/^[0-9]+$/|unique:users',
            'password' => 'required|string|min:6',
            'shop_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'longitude' =>'required',
            'latitude' => 'required',
            'area_id' => 'required',
            'shop_types_id' => 'required',
            'image' => 'required',
        ];
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
            'longitude.required' => 'longitude  مطلوب',
            'latitude.required' => ' latitude مطلوب',
            'area_id.required' => 'المنطقه مطلوبه',
            'shop_types_id.required' => 'نوع المحل مطلوب',
            'image.required' => 'صوره المحل مطلوبه',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(['success'=>false,'message'=>$validator->errors(), 'data'=>[]],422));
    }
}
