<?php

namespace App\Http\Resources\V1\WorkOrder\CancelingMotive;

use Illuminate\Http\Resources\Json\JsonResource;

class GetAllCancelingMotiveResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'data' => parent::toArray($request),
        ];
    }
}
