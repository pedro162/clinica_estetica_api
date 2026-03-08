<?php

namespace App\Http\Resources\V1\Neighborhood;

use Illuminate\Http\Resources\Json\JsonResource;

class NeighborhoodResource extends JsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
