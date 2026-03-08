<?php

namespace App\Application\Handlers\PersonAddress;

use App\Application\Commands\PersonAddress\CreatePersonAddressCommand;
use App\Domain\PersonAddress\Repositories\PersonAddressRepositoryInterface;
use App\Logradouro;

;

use App\Domain\PersonAddress\ValueObjects\PersonAddressId;

class GetPersonAddressByIdHandler
{
    private PersonAddressRepositoryInterface $repository;

    public function __construct(PersonAddressRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePersonAddressCommand $command): ?Logradouro
    {
        return $this->repository->findById(new PersonAddressId($command->getId()));
    }
}
