<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NomsRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:199'],
            'balance' => ['required'],
            'currency' => ['required'],
            'phone' => ['regex:/^(009665|9665|\+9665|05)([0-9]{8})$/i', 'required_without:y_phone', 'nullable'],

            'y_phone' => ['regex:/^(009677|9677|\+9677|7)([0-9]{8})$/i', 'required_without:phone', 'nullable'],


        ];
    }

    public function messages()
    {
        return [

            'name_agent.required' => 'يرجى ادخال  اسم  الوكيل',

            'agent_value.required' => 'يرجى ادخال مبلغ صلاحية المالية  للوكيل',
            'agent_currency.required' => 'يرجى اختيار العملة ',
            'name_agent.max' => 'يجب ان لا تتجاوز 190 حرف',

            'phone.regex' => 'رقم الجوال  غير صحيح',
            'phone.required_without' => 'يجب ادخال احد الرقمين',
            'y_phone.regex' => 'الرقم  الجوال غير صحيح',
            'y_phone.required_without' => 'يجب ادخال احد الرقمين',



        ];
    }
}
