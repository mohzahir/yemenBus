<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HajCheckoutRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:50',
            'phone' => 'required|numeric|digits:9',
            'email' => 'nullable|email',
            'nid' => 'nullable',
            'dateofbirth' => 'required',
            'dateofbirth.*.0' => 'numeric|max:31',
            'dateofbirth.*.1' => 'numeric|max:12',
            'dateofbirth.*.2' => 'numeric|max:2022',
        ];
    }
}
