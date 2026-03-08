<?php

namespace App\Application\Handlers\Country;

use App\Domain\Country\Repositories\CountryRepositoryInterface;

;

use Illuminate\Support\Collection;

class GetAllCountryHandler
{
    private CountryRepositoryInterface $repository;

    public function __construct(CountryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
