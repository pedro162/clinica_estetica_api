<?php

namespace App\Application\Handlers\WorkOrder\CancelingMotive;

use App\Application\Commands\WorkOrder\CancelingMotive\CreateCancelingMotiveCommand;
use App\Domain\WorkOrderCancelingMotive\Repositories\WorkOrderCancelingMotiveRepositoryInterface;
use App\Domain\WorkOrderCancelingMotive\ValueObjects\WorkOrderCancelingMotiveId;
use App\MotivoCancelamentoOrdemServico as CancelingMotiveModel;

class GetByIdCancelingMotiveHandler
{
    private WorkOrderCancelingMotiveRepositoryInterface $repository;

    public function __construct(WorkOrderCancelingMotiveRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCancelingMotiveCommand $command): ?CancelingMotiveModel
    {
        return $this->repository->findById(new WorkOrderCancelingMotiveId((string) $command->getId()));
    }
}
