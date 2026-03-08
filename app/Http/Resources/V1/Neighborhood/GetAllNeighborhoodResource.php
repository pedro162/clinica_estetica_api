<?php

namespace App\Http\Resources\V1\Neighborhood;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GetAllNeighborhoodResource extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => $this->collection->map(fn ($item) => new NeighborhoodResource($item)),
        ];
    }
}
