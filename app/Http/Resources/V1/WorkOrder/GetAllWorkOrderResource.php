<?php

namespace App\Http\Resources\V1\WorkOrder;

use Illuminate\Http\Resources\Json\JsonResource;

class GetAllWorkOrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'registro' => WorkOrderResource::collection($this->resource['registro'] ?? []),
        ];
    }
}
