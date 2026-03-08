<?php

namespace App\Application\Handlers\City;

use App\Application\Commands\City\CreateCityCommand;
use App\Cidade;
use App\Domain\City\Entities\City;
use App\Domain\City\Repositories\CityRepositoryInterface;

;


class CreateCityHandler
{
    private CityRepositoryInterface $repository;

    public function __construct(CityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCityCommand $command): ?Cidade
    {
        $entity = City::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
