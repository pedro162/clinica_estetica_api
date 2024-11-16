<?php

namespace App\Application\Handlers\City;

use App\Application\Commands\City\CreateCityCommand;
use App\Domain\City\Entities\City;
use App\Domain\City\Repositories\CityRepositoryInterface;;

use App\Domain\City\ValueObjects\CityId;
use App\Domain\City\ValueObjects\CityBody;
use App\Domain\City\ValueObjects\CityCode;
use App\Domain\City\ValueObjects\CityIsDefault;
use App\Domain\City\ValueObjects\CityName;
use App\Domain\City\ValueObjects\CityTenantId;
use App\Domain\City\ValueObjects\CityTitle;

class CreateCityHandler
{
    private CityRepositoryInterface $repository;

    public function __construct(CityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCityCommand $command): ?City
    {
        $template = (new City())
            ->id(new CityId($command->getId()))
            ->name(new CityName($command->getName()))
            ->code(new CityCode($command->getCode()))
            ->tenantId(new CityTenantId($command->getTenantId()));
        return $this->repository->save($template);
    }
}
