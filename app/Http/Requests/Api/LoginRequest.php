<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
           'mobile_number' => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'mobile_number.required' => 'رقم الهاتف مطلوب',
            'password.required' => 'كلمه المرور مطلوبه',

        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(['success'=>false,'message'=>$validator->errors(), 'data'=>[]],422));
    }
}
