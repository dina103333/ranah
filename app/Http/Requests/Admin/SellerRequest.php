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
           ];
       }else{
           return [
               'name' => 'required',
               'mobile' => 'required|unique:sellers,mobile_number,'. $this->route()->seller->id,
           ];
       }
    }
    public function messages()
    {
        return [
            'mobile.required' => 'يجب ادخال رقم الهاتف .',
            'mobile.unique' => '  رقم الهاتف مأخوذ مسبقا',
            'name.required' => 'يجب ادخال الاسم .',
        ];
    }
}
