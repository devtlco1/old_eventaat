<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class RestaurentResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
