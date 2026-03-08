<?php

namespace App\Application\Handlers\Cashier;

use App\Domain\Cashier\Repositories\CashierRepositoryInterface;
use Illuminate\Support\Collection;

class GetAllCashierHandler
{
    private CashierRepositoryInterface $repository;

    public function __construct(CashierRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
