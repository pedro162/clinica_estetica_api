<?php

namespace App\Application\Handlers\Person;

use App\Application\Commands\Person\CreatePersonCommand;
use App\Domain\Person\Repositories\PersonRepositoryInterface;
use App\Pessoa;

;

use App\Domain\Person\ValueObjects\PersonId;

class GetPersonByIdHandler
{
    private PersonRepositoryInterface $repository;

    public function __construct(PersonRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePersonCommand $command): ?Pessoa
    {
        return $this->repository->findById(new PersonId($command->getId()));
    }
}
