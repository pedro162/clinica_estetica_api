<?php

namespace App\Http\Resources\V1\WorkOrder;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkOrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
