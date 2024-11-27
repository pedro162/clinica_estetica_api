<?php

namespace App\Application\Services\City;

use App\Application\Commands\City\CreateCityCommand;
use App\Application\Handlers\City\CreateCityHandler;
use App\Application\Handlers\City\GetAllCityHandler;
use App\Cidade;
use App\Domain\City\Entities\City;
use Illuminate\Support\Collection;

class CityApplicationService implements CityApplicationServiceInterface
{
    private CreateCityHandler $createCityHandler;
    protected GetAllCityHandler $getAllCityHandler;

    public function __construct(
        CreateCityHandler $createCityHandler,
        GetAllCityHandler $getAllCityHandler
    ) {
        $this->createCityHandler = $createCityHandler;
        $this->getAllCityHandler = $getAllCityHandler;
    }

    public function store(
        CreateCityCommand $command
    ): ?Cidade {
        return $this->createCityHandler->handler($command);
    }

    public function update(
        CreateCityCommand $command
    ): ?City {

        return $this->createCityHandler->handler($command);
    }

    public function getAll(array $data = []): ?Collection
    {
        return $this->getAllCityHandler->handler($data);
    }
}
