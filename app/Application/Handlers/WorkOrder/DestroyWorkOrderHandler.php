<?php

namespace App\Application\Handlers\WorkOrder;

use App\Application\Commands\WorkOrder\CreateWorkOrderCommand;
use App\Domain\WorkOrder\Entities\WorkOrder;
use App\Domain\WorkOrder\Repositories\WorkOrderRepositoryInterface;

class DestroyWorkOrderHandler
{
    public function __construct(private WorkOrderRepositoryInterface $repository)
    {
    }

    public function handler(CreateWorkOrderCommand $command): void
    {
        $entity = WorkOrder::buildEntity($command->getDataProperties());
        $this->repository->destroy($entity);
    }
}
