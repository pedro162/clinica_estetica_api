<?php

namespace App\Application\Handlers;

use App\Application\Commands\CreateCountryCommand;
use App\Domain\Country\Entities\Country;
use App\Domain\Country\Repositories\CountryRepositoryInterface;;

use App\Domain\Country\ValueObjects\CountryId;
use App\Domain\Country\ValueObjects\CountryBody;
use App\Domain\Country\ValueObjects\CountryCode;
use App\Domain\Country\ValueObjects\CountryIsDefault;
use App\Domain\Country\ValueObjects\CountryName;
use App\Domain\Country\ValueObjects\CountryTenantId;
use App\Domain\Country\ValueObjects\CountryTitle;

class CreateCountryHandler
{
    private CountryRepositoryInterface $repository;

    public function __construct(CountryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCountryCommand $command): ?Country
    {
        $template = (new Country())
            ->id(new CountryId($command->getId()))
            ->name(new CountryName($command->getName()))
            ->code(new CountryCode($command->getCode()))
            ->isDefault(new CountryIsDefault($command->getIsDefault()))
            ->tenantId(new CountryTenantId($command->getTenantId()));
        return $this->repository->save($template);
    }
}
