<?php

namespace App\Application\Handlers\PersonAddress;

use App\Application\Commands\PersonAddress\CreatePersonAddressCommand;
use App\Domain\PersonAddress\Entities\PersonAddress;
use App\Domain\PersonAddress\Repositories\PersonAddressRepositoryInterface;;

class UpdatePersonAddressHandler
{
    private PersonAddressRepositoryInterface $repository;

    public function __construct(PersonAddressRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePersonAddressCommand $command): void
    {
        $entity = PersonAddress::buildEntity($command->getDataProperties());
        $this->repository->update($entity);
    }
}
