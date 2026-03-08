<?php

namespace App\Application\Handlers\FinancialOperator;

use App\Domain\FinancialOperator\Repositories\FinancialOperatorRepositoryInterface;
use Illuminate\Support\Collection;

class GetAllFinancialOperatorHandler
{
    private FinancialOperatorRepositoryInterface $repository;

    public function __construct(FinancialOperatorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
