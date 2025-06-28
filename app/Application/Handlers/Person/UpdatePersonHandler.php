<?php

namespace App\Application\Handlers\Person;

use App\Application\Commands\Person\CreatePersonCommand;
use App\Domain\Person\Entities\Person;
use App\Domain\Person\Repositories\PersonRepositoryInterface;;

class UpdatePersonHandler
{
    private PersonRepositoryInterface $repository;

    public function __construct(PersonRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePersonCommand $command): void
    {
        $entity = Person::buildEntity($command->getDataProperties());
        $this->repository->update($entity);
    }
}
