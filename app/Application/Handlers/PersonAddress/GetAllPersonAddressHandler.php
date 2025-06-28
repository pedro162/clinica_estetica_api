<?php

namespace App\Application\Handlers\PersonAddress;

use App\Domain\PersonAddress\Repositories\PersonAddressRepositoryInterface;
use Illuminate\Support\Collection;

class GetAllPersonAddressHandler
{
    private PersonAddressRepositoryInterface $repository;

    public function __construct(PersonAddressRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
