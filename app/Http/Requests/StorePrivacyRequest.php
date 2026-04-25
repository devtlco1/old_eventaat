<?php

namespace App\Http\Requests;

use App\Models\Privacy;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePrivacyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('privacy_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'required',  // Make this field mandatory
                'string',
                'max:255',  // Limit the length
            ],
            'title_ar' => [
                'required',  // Make this field mandatory
                'string',
                'max:255',  // Limit the length
            ],
        ];
        return [
            'title.required' => 'The Title field is required.',
            'title.string' => 'The Title must be a string.',
            'title.max' => 'The Title may not be greater than 255 characters.',
            'title_ar.required' => 'The Arabic Title field is required.',
            'title_ar.string' => 'The Arabic Title must be a string.',
            'title_ar.max' => 'The Arabic Title may not be greater than 255 characters.',
        ];
    }
    
}
