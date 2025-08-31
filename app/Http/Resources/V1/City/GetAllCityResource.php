<?php

namespace App\Http\Resources\V1\City;

use Illuminate\Http\Resources\Json\JsonResource;

class GetAllCityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => parent::toArray($request),
        ];
    }
}
