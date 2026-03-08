<?php

namespace App\Application\Handlers\Country;

use App\Application\Commands\Country\CreateCountryCommand;
use App\Domain\Country\Repositories\CountryRepositoryInterface;
use App\Pais;

;

use App\Domain\Country\ValueObjects\CountryId;

class GetCountryByIdHandler
{
    private CountryRepositoryInterface $repository;

    public function __construct(CountryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCountryCommand $command): ?Pais
    {
        return $this->repository->findById(new CountryId($command->getId()));
    }
}
