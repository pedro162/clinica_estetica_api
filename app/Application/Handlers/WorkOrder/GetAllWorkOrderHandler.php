<?php

namespace App\Application\Handlers\WorkOrder;

use App\Domain\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use Illuminate\Support\Collection;

class GetAllWorkOrderHandler
{
    public function __construct(private WorkOrderRepositoryInterface $repository)
    {
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
