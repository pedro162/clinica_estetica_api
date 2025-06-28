<?php

namespace App\Application\Services\PersonAddress;

use App\Application\Commands\PersonAddress\CreatePersonAddressCommand;
use App\Application\Handlers\PersonAddress\CreatePersonAddressHandler;
use App\Application\Handlers\PersonAddress\DestroyPersonAddressHandler;
use App\Application\Handlers\PersonAddress\GetAllPersonAddressHandler;
use App\Application\Handlers\PersonAddress\GetPersonAddressByIdHandler;
use App\Application\Handlers\PersonAddress\UpdatePersonAddressHandler;
use App\Logradouro;
use Illuminate\Support\Collection;

class PersonAddressApplicationService implements PersonAddressApplicationServiceInterface
{
    private CreatePersonAddressHandler $createPersonAddressHandler;
    protected GetAllPersonAddressHandler $getAllPersonAddressHandler;
    protected UpdatePersonAddressHandler $updatePersonAddressHandler;
    protected DestroyPersonAddressHandler $destroyPersonAddressHandler;
    protected GetPersonAddressByIdHandler $getPersonAddressByIdHandler;

    public function __construct(
        CreatePersonAddressHandler $createPersonAddressHandler,
        GetAllPersonAddressHandler $getAllPersonAddressHandler,
        UpdatePersonAddressHandler $updatePersonAddressHandler,
        GetPersonAddressByIdHandler $getPersonAddressByIdHandler,
        DestroyPersonAddressHandler $destroyPersonAddressHandler
    ) {
        $this->createPersonAddressHandler = $createPersonAddressHandler;
        $this->getAllPersonAddressHandler = $getAllPersonAddressHandler;
        $this->updatePersonAddressHandler = $updatePersonAddressHandler;
        $this->destroyPersonAddressHandler = $destroyPersonAddressHandler;
        $this->getPersonAddressByIdHandler = $getPersonAddressByIdHandler;
    }

    public function store(
        CreatePersonAddressCommand $command
    ): ?Logradouro {
        return $this->createPersonAddressHandler->handler($command);
    }

    public function update(
        CreatePersonAddressCommand $command
    ): void {

        $this->updatePersonAddressHandler->handler($command);
    }

    public function destroy(
        CreatePersonAddressCommand $command
    ): void {

        $this->destroyPersonAddressHandler->handler($command);
    }

    public function getAll(array $data = []): ?Collection
    {
        return $this->getAllPersonAddressHandler->handler($data);
    }

    public function findById(
        CreatePersonAddressCommand $command
    ): ?Logradouro {

        return $this->getPersonAddressByIdHandler->handler($command);
    }
}
