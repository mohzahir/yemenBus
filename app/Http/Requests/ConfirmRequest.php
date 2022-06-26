<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmRequest extends FormRequest
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
             'order_url' => ['required','string'],
           
                'passenger_phone'=>['regex:/^(009665|9665|\+9665|05)([0-9]{8})$/i','required_without:passenger_phone_yem','nullable'],

'passenger_phone_yem'=>['regex:/^(009677|9677|\+9677|7)([0-9]{8})$/i','required_without:passenger_phone','nullable'],

];
    }

     public function messages()
    {
        return [
             'order_url.required' => 'رقم الطلب مطلوب',
           
'passenger_phone.regex'=>'الرقم غير صحيح',
'passenger_phone.required_without'=>'يجب ادخال احد الرقمين',
'passenger_phone_yem.regex'=>'الرقم غير صحيح',
'passenger_phone_yem.required_without'=>'يجب ادخال احد الرقمين',


        ];
    }
}