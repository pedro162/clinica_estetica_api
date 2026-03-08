<?php

namespace App\Http\Resources\V1\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
