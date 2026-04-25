<?php

namespace App\Http\Requests;

use App\Models\City;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCityRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('city_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'required',  // Make this field mandatory
                'string',
                'max:255',  // Limit the length
            ],
            'name_ar' => [
                'required',  // Make this field mandatory
                'string',
                'max:255',  // Limit the length
            ],
        ];
        return [
            'name.required' => 'The Title field is required.',
            'name.string' => 'The Title must be a string.',
            'name.max' => 'The Title may not be greater than 255 characters.',
            'name_ar.required' => 'The Arabic Title field is required.',
            'name_ar.string' => 'The Arabic Title must be a string.',
            'name_ar.max' => 'The Arabic Title may not be greater than 255 characters.',
        ];
    }
}
