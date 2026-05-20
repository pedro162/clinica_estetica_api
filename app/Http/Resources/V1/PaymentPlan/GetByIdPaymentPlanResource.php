<?php

namespace App\Http\Resources\V1\PaymentPlan;

use Illuminate\Http\Resources\Json\JsonResource;

class GetByIdPaymentPlanResource extends JsonResource
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
