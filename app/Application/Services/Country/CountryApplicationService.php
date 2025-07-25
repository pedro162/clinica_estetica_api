<?php

namespace App\Application\Services\Country;

use App\Application\Commands\Country\CreateCountryCommand;
use App\Application\Handlers\Country\CreateCountryHandler;
use App\Application\Handlers\Country\DestroyCountryHandler;
use App\Application\Handlers\Country\GetAllCountryHandler;
use App\Application\Handlers\Country\GetCountryByIdHandler;
use App\Application\Handlers\Country\UpdateCountryHandler;
use App\Pais;
use Illuminate\Support\Collection;

class CountryApplicationService implements CountryApplicationServiceInterface
{
    private CreateCountryHandler $createCountryHandler;
    protected GetAllCountryHandler $getAllCountryHandler;
    protected UpdateCountryHandler $updateCountryHandler;
    protected GetCountryByIdHandler $getCountryByIdHandler;
    protected DestroyCountryHandler $destroyCountryHandler;

    public function __construct(
        CreateCountryHandler $createCountryHandler,
        GetAllCountryHandler $getAllCountryHandler,
        UpdateCountryHandler $updateCountryHandler,
        GetCountryByIdHandler $getCountryByIdHandler,
        DestroyCountryHandler $destroyCountryHandler
    ) {
        $this->createCountryHandler = $createCountryHandler;
        $this->getAllCountryHandler = $getAllCountryHandler;
        $this->updateCountryHandler = $updateCountryHandler;
        $this->getCountryByIdHandler = $getCountryByIdHandler;
        $this->destroyCountryHandler = $destroyCountryHandler;
    }

    public function store(
        CreateCountryCommand $command
    ): ?Pais {
        return $this->createCountryHandler->handler($command);
    }

    public function update(
        CreateCountryCommand $command
    ): void {

        $this->updateCountryHandler->handler($command);
    }

    public function destroy(
        CreateCountryCommand $command
    ): void {

        $this->destroyCountryHandler->handler($command);
    }

    public function getAll(array $data = []): ?Collection
    {
        return $this->getAllCountryHandler->handler($data);
    }

    public function findById(
        CreateCountryCommand $command
    ): ?Pais {

        return $this->getCountryByIdHandler->handler($command);
    }
}
