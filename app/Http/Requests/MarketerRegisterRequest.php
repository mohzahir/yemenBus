<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarketerRegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'marketer_type' => ['required', 'in:global_marketer,provider_marketer,service_marketer'],
            'provider_id' => ["required_if:marketer_type,'provider_marketer'"],
            'service_id' => ["required_if:marketer_type,'service_marketer'"],
            'password' => ['required'],
            'phone' => ['regex:/^(009665|9665|\+9665|05)([0-9]{8})$/i', 'required_without:y_phone', 'nullable'],

            'y_phone' => ['regex:/^(009677|9677|\+9677|7)([0-9]{8})$/i', 'required_without:phone', 'nullable'],


        ];
    }

    public function messages()
    {
        return [

            'phone.regex' => 'الرقم غير صحيح',
            'phone.required_without' => 'يجب ادخال احد الرقمين',
            'y_phone.regex' => 'الرقم غير صحيح',
            'y_phone.required_without' => 'يجب ادخال احد الرقمين',



        ];
    }
}
