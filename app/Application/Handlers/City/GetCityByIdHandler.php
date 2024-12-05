<?php

namespace App\Application\Handlers\City;

use App\Application\Commands\City\CreateCityCommand;
use App\Cidade;
use App\Domain\City\Entities\City;
use App\Domain\City\Repositories\CityRepositoryInterface;;

use App\Domain\City\ValueObjects\CityId;
use App\Domain\City\ValueObjects\CityBody;
use App\Domain\City\ValueObjects\CityCode;
use App\Domain\City\ValueObjects\CityIsDefault;
use App\Domain\City\ValueObjects\CityName;
use App\Domain\City\ValueObjects\CityTenantId;
use App\Domain\City\ValueObjects\CityTitle;

class GetCityByIdHandler
{
    private CityRepositoryInterface $repository;

    public function __construct(CityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCityCommand $command): ?Cidade
    {
        return $this->repository->findById(new CityId($command->getId()));
    }
}
