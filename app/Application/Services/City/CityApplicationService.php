<?php

namespace App\Application\Services\City;

use App\Application\Commands\City\CreateCityCommand;
use App\Application\Handlers\City\CreateCityHandler;
use App\Application\Handlers\City\GetAllCityHandler;
use App\Application\Handlers\City\GetCityByIdHandler;
use App\Application\Handlers\City\UpdateCityHandler;
use App\Cidade;
use Illuminate\Support\Collection;

class CityApplicationService implements CityApplicationServiceInterface
{
    private CreateCityHandler $createCityHandler;
    protected GetAllCityHandler $getAllCityHandler;
    protected UpdateCityHandler $updateCityHandler;
    protected GetCityByIdHandler $getCityByIdHandler;

    public function __construct(
        CreateCityHandler $createCityHandler,
        GetAllCityHandler $getAllCityHandler,
        UpdateCityHandler $updateCityHandler,
        GetCityByIdHandler $getCityByIdHandler
    ) {
        $this->createCityHandler = $createCityHandler;
        $this->getAllCityHandler = $getAllCityHandler;
        $this->updateCityHandler = $updateCityHandler;
        $this->getCityByIdHandler = $getCityByIdHandler;
    }

    public function store(
        CreateCityCommand $command
    ): ?Cidade {
        return $this->createCityHandler->handler($command);
    }

    public function update(
        CreateCityCommand $command
    ): void {

        $this->updateCityHandler->handler($command);
    }

    public function getAll(array $data = []): ?Collection
    {
        return $this->getAllCityHandler->handler($data);
    }

    public function findById(
        CreateCityCommand $command
    ): ?Cidade {

        return $this->getCityByIdHandler->handler($command);
    }
}
