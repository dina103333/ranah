<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SellerRequest extends FormRequest
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
       if ($this->isMethod('POSt')){
           return [
               'name' => 'required',
               'mobile' => 'required|unique:sellers,mobile_number',
               'password' => 'required',
               'status' => 'required',
               'address' => 'required',
           ];
       }else{
           return [
               'name' => 'required',
               'mobile' => 'required|unique:sellers,mobile_number,'. $this->route()->seller->id,
               'password' => 'nullable',
               'status' => 'required',
               'address' => 'required',
           ];
       }
    }
    public function messages()
    {
        return [
            'mobile.required' => 'يجب ادخال رقم الهاتف .',
            'mobile.unique' => '  رقم الهاتف مأخوذ مسبقا',
            'name.required' => 'يجب ادخال الاسم .',
            'password.required' => 'يجب ادخال كلمه المرور .',
            'status.required' => 'يجب اخيار الحاله .',
            'address.required' => 'يجب ادخال العنوان .',
        ];
    }
}
