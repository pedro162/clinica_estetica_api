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
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
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
