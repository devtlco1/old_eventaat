<?php

namespace App\Http\Requests;

use App\Models\Restaurant;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRestaurentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('restaurent_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
                'unique:users',
            ],
            'mobile' => [
                'string',
                'required',
            ],
            'address' => [
                'string',
                'nullable',
            ],
            'website_url' => [
                'string',
                'nullable',
            ],
            'menu_url' => [
                'string',
                'nullable',
            ],
            'location_url' => [
                'string',
                'nullable',
            ],
            'images' => [
                'array',
            ],
        ];
    }
}
