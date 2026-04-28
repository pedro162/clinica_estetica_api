<?php

namespace App\Application\Handlers\WorkOrder;

use App\Application\Commands\WorkOrder\CreateWorkOrderCommand;
use App\Domain\WorkOrder\Entities\WorkOrder;
use App\Domain\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use App\OrdemServico as WorkOrderModel;

class CreateWorkOrderHandler
{
    public function __construct(private WorkOrderRepositoryInterface $repository)
    {
    }

    public function handler(CreateWorkOrderCommand $command): ?WorkOrderModel
    {
        $entity = WorkOrder::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
