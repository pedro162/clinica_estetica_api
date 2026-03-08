<?php

namespace App\Application\Handlers\City;

use App\Application\Commands\City\CreateCityCommand;
use App\Domain\City\Entities\City;
use App\Domain\City\Repositories\CityRepositoryInterface;

;


class UpdateCityHandler
{
    private CityRepositoryInterface $repository;

    public function __construct(CityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCityCommand $command): void
    {
        $entity = City::buildEntity($command->getDataProperties());
        $this->repository->update($entity);
    }
}
