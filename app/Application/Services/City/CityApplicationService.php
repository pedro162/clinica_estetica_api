<?php

namespace App\Application\Services\City;

use App\Application\Commands\City\CreateCityCommand;
use App\Application\Handlers\City\CreateCityHandler;
use App\Application\Handlers\City\GetAllCityHandler;
use App\Domain\City\Entities\City;

class CityApplicationService implements CityApplicationServiceInterface
{
    public function __construct(
        private CreateCityHandler $createCityHandler,
        protected GetAllCityHandler $getAllCityHandler
    ) {}

    public function store(
        CreateCityCommand $command
    ): ?City {

        return $this->createCityHandler->handler($command);
    }

    public function update(
        CreateCityCommand $command
    ): ?City {

        return $this->createCityHandler->handler($command);
    }

    public function getAll(array $data = []): ?array
    {
        return $this->getAllCityHandler->handler();
    }
}
