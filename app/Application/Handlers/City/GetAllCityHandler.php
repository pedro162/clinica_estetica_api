<?php

namespace App\Application\Handlers\City;

use App\Domain\City\Repositories\CityRepositoryInterface;

;

use Illuminate\Support\Collection;

class GetAllCityHandler
{
    private CityRepositoryInterface $repository;

    public function __construct(CityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
