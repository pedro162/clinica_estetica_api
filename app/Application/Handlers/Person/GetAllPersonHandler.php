<?php

namespace App\Application\Handlers\Person;

use App\Domain\Person\Repositories\PersonRepositoryInterface;
use Illuminate\Support\Collection;

class GetAllPersonHandler
{
    private PersonRepositoryInterface $repository;

    public function __construct(PersonRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
