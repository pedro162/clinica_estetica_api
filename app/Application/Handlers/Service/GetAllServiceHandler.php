<?php

namespace App\Application\Handlers\Service;

use App\Domain\Service\Repositories\ServiceRepositoryInterface;
use Illuminate\Support\Collection;

class GetAllServiceHandler
{
    private ServiceRepositoryInterface $repository;

    public function __construct(ServiceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
