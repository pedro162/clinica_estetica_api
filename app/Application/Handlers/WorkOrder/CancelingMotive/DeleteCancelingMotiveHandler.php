<?php

namespace App\Application\Handlers\WorkOrder\CancelingMotive;

use App\Application\Commands\WorkOrder\CancelingMotive\CreateCancelingMotiveCommand;
use App\Domain\WorkOrderCancelingMotive\Entities\WorkOrderCancelingMotive;
use App\Domain\WorkOrderCancelingMotive\Repositories\WorkOrderCancelingMotiveRepositoryInterface;

class DeleteCancelingMotiveHandler
{
    private WorkOrderCancelingMotiveRepositoryInterface $repository;

    public function __construct(WorkOrderCancelingMotiveRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCancelingMotiveCommand $command): void
    {
        $entity = WorkOrderCancelingMotive::buildEntity($command->getDataProperties());
        $this->repository->destroy($entity);
    }
}
