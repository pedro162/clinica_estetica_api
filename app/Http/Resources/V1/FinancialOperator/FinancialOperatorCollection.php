<?php

namespace App\Http\Resources\V1\FinancialOperator;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FinancialOperatorCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response = [
            'data' => $this->collection,
        ];

        if ($this->resource instanceof \Illuminate\Pagination\LengthAwarePaginator || $this->resource instanceof \Illuminate\Pagination\Paginator) {
            $response['links'] = [
                'first' => $this->url(1),
                'last' => $this->url($this->lastPage()),
                'prev' => $this->previousPageUrl(),
                'next' => $this->nextPageUrl()
            ];

            $response['meta'] = [
                'current_page' => $this->currentPage(),
                'from' => $this->firstItem(),
                'last_page' => $this->lastPage(),
                'path' => $this->path(),
                'per_page' => $this->perPage(),
                'to' => $this->lastItem(),
                'total' => $this->total()
            ];
        }

        return $response;
    }
}
