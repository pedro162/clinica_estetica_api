<?php

namespace App\Application\Handlers\Country;

use App\Application\Commands\Country\CreateCountryCommand;
use App\Domain\Country\Entities\Country;
use App\Domain\Country\Repositories\CountryRepositoryInterface;;

class UpdateCountryHandler
{
    private CountryRepositoryInterface $repository;

    public function __construct(CountryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCountryCommand $command): void
    {
        $entity = Country::buildEntity($command->getDataProperties());
        $this->repository->update($entity);
    }
}
