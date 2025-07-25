<?php

namespace App\Application\Handlers\Country;

use App\Application\Commands\Country\CreateCountryCommand;
use App\Pais;
use App\Domain\Country\Entities\Country;
use App\Domain\Country\Repositories\CountryRepositoryInterface;

class CreateCountryHandler
{
    private CountryRepositoryInterface $repository;

    public function __construct(CountryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCountryCommand $command): ?Pais
    {
        $entity = Country::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
