<?php

namespace App\Application\Handlers\CreditCardBrand;

use App\Domain\CreditCardBrand\Repositories\CreditCardBrandRepositoryInterface;
use Illuminate\Support\Collection;

class GetAllCreditCardBrandHandler
{
    private CreditCardBrandRepositoryInterface $repository;

    public function __construct(CreditCardBrandRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
