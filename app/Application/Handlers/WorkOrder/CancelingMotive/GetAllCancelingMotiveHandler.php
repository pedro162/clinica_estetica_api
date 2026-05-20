<?php

namespace App\Application\Handlers\WorkOrder\CancelingMotive;

use App\Domain\WorkOrderCancelingMotive\Repositories\WorkOrderCancelingMotiveRepositoryInterface;
use Illuminate\Support\Collection;

class GetAllCancelingMotiveHandler
{
    private WorkOrderCancelingMotiveRepositoryInterface $repository;

    public function __construct(WorkOrderCancelingMotiveRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
