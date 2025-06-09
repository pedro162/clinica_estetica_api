<?php

namespace App\Application\Handlers\Person;

use App\Application\Commands\Person\CreatePersonCommand;
use App\PlanoPagamento;
use App\Domain\Person\Entities\Person;
use App\Domain\Person\Repositories\PersonRepositoryInterface;;

class CreatePersonHandler
{
    private PersonRepositoryInterface $repository;

    public function __construct(PersonRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePersonCommand $command): ?PlanoPagamento
    {
        $entity = Person::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
