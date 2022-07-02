<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddTripRequest extends FormRequest
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
            'provider_id' => 'required|exists:providers,id',
            'sub_service_id' => 'required|exists:sub_services,id',
            'air_river' => 'nullable|in:air,river',
            'direcation' => 'required|in:sty,yts,loc',
            'takeoff_city_id' => 'required|exists:city,id',
            'arrival_city_id' => 'required|exists:city,id',
            'coming_time' => 'nullable',
            'leaving_time' => 'nullable',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            'day' => 'nullable',
            'no_ticket' => 'required|numeric',
            'line_trip' => 'nullable',
            'note' => 'nullable',
            'price' => 'required|numeric',
            'deposit_price' => 'nullable|numeric',
            'currency' => 'nullable|string',
            'weight' => 'nullable|numeric',
            'days_count' => 'nullable|numeric',
            'program_details_page_content' => 'nullable',
            'program_details_file' => 'nullable',
        ];
    }
}
