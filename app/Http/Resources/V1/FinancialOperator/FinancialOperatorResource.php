<?php

namespace App\Http\Resources\V1\FinancialOperator;

use Illuminate\Http\Resources\Json\JsonResource;

class FinancialOperatorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
