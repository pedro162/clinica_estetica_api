<?php

namespace App\Application\Handlers\WorkOrder\CancelingMotive;

use App\Application\Commands\WorkOrder\CancelingMotive\CreateCancelingMotiveCommand;
use App\Domain\WorkOrderCancelingMotive\Entities\WorkOrderCancelingMotive;
use App\Domain\WorkOrderCancelingMotive\Repositories\WorkOrderCancelingMotiveRepositoryInterface;
use App\MotivoCancelamentoOrdemServico as CancelingMotiveModel;

class CreateCancelingMotiveHandler
{
    private WorkOrderCancelingMotiveRepositoryInterface $repository;

    public function __construct(WorkOrderCancelingMotiveRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCancelingMotiveCommand $command): ?CancelingMotiveModel
    {
        $entity = WorkOrderCancelingMotive::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
