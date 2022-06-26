<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailMarketerRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:199','min:3'],
            'city' => ['required', 'string', 'max:199','min:3'],
            'address' => ['required', 'string', 'max:199','min:3'],
            'price' => ['required','gt:50'],



        ];
    }

    public function messages()
    {
        return [
           
            'name.required'=>'يرجى ادخال  اسم  الوكيل',
 'name.min'=>'يجب أن يحتوي الإسم على 3 حروف أو أكثر',
 'city.min'=>'يجب أن يحتوي المدينة على 3 حروف أو أكثر',
 'address.min'=>'يجب أن يحتوي العنوان على 3 حروف أو أكثر',

            'price.gt'=>'تاكد من مبلغ الرصيد المدخل' ,




        ];
}
}
