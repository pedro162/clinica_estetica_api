<?php

namespace App\Http\Resources\V1\Category;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GetAllCategoryResource extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => CategoryResource::collection($this->collection),
        ];
    }
}
