<?php

namespace App\Application\Handlers\WorkOrder;

use App\Application\Commands\WorkOrder\CreateWorkOrderCommand;
use App\Domain\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use App\Domain\WorkOrder\ValueObjects\WorkOrderId;
use App\OrdemServico as WorkOrderModel;

class GetWorkOrderByIdHandler
{
    public function __construct(private WorkOrderRepositoryInterface $repository)
    {
    }

    public function handler(CreateWorkOrderCommand $command): ?WorkOrderModel
    {
        return $this->repository->findById(new WorkOrderId($command->getId()));
    }
}
