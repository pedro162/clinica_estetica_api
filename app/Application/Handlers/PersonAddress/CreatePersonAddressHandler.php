<?php

namespace App\Application\Handlers\PersonAddress;

use App\Application\Commands\PersonAddress\CreatePersonAddressCommand;
use App\Logradouro;
use App\Domain\PersonAddress\Entities\PersonAddress;
use App\Domain\PersonAddress\Repositories\PersonAddressRepositoryInterface;;

class CreatePersonAddressHandler
{
    private PersonAddressRepositoryInterface $repository;

    public function __construct(PersonAddressRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePersonAddressCommand $command): ?Logradouro
    {
        $entity = PersonAddress::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
