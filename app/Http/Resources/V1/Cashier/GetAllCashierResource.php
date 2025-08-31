<?php

namespace App\Http\Resources\V1\Cashier;

use Illuminate\Http\Resources\Json\JsonResource;

class GetAllCashierResource extends JsonResource
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
