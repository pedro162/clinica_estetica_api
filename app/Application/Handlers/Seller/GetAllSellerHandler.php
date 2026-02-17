<?php

namespace App\Application\Handlers\Seller;

use App\Domain\Seller\Repositories\SellerRepositoryInterface;
use Illuminate\Support\Collection;

class GetAllSellerHandler
{
    private SellerRepositoryInterface $repository;

    public function __construct(SellerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
