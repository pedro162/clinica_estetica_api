<?php

namespace App\Http\Resources\V1\WorkOrder;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkOrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'active' => $this->active,
            'tenant_id' => $this->tenant_id,
            'user_id' => $this->user_id,
            'user_update_id' => $this->user_update_id,
        ];
    }
}
