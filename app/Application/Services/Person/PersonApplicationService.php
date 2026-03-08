<?php

namespace App\Application\Services\Person;

use App\Application\Commands\Person\CreatePersonCommand;
use App\Application\Handlers\Person\CreatePersonHandler;
use App\Application\Handlers\Person\DestroyPersonHandler;
use App\Application\Handlers\Person\GetAllPersonHandler;
use App\Application\Handlers\Person\GetPersonByIdHandler;
use App\Application\Handlers\Person\UpdatePersonHandler;
use App\Pessoa;
use Illuminate\Support\Collection;

class PersonApplicationService implements PersonApplicationServiceInterface
{
    private CreatePersonHandler $createPersonHandler;
    protected GetAllPersonHandler $getAllPersonHandler;
    protected UpdatePersonHandler $updatePersonHandler;
    protected DestroyPersonHandler $destroyPersonHandler;
    protected GetPersonByIdHandler $getPersonByIdHandler;

    public function __construct(
        CreatePersonHandler $createPersonHandler,
        GetAllPersonHandler $getAllPersonHandler,
        UpdatePersonHandler $updatePersonHandler,
        GetPersonByIdHandler $getPersonByIdHandler,
        DestroyPersonHandler $destroyPersonHandler
    ) {
        $this->createPersonHandler = $createPersonHandler;
        $this->getAllPersonHandler = $getAllPersonHandler;
        $this->updatePersonHandler = $updatePersonHandler;
        $this->destroyPersonHandler = $destroyPersonHandler;
        $this->getPersonByIdHandler = $getPersonByIdHandler;
    }

    public function store(
        CreatePersonCommand $command
    ): ?Pessoa {
        return $this->createPersonHandler->handler($command);
    }

    public function update(
        CreatePersonCommand $command
    ): void {

        $this->updatePersonHandler->handler($command);
    }

    public function destroy(
        CreatePersonCommand $command
    ): void {

        $this->destroyPersonHandler->handler($command);
    }

    public function getAll(array $data = []): ?Collection
    {
        return $this->getAllPersonHandler->handler($data);
    }

    public function findById(
        CreatePersonCommand $command
    ): ?Pessoa {

        return $this->getPersonByIdHandler->handler($command);
    }
}
