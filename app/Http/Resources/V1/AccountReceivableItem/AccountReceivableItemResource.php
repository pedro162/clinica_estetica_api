<?php

namespace App\Http\Resources\V1\AccountReceivableItem;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountReceivableItemResource extends JsonResource
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
