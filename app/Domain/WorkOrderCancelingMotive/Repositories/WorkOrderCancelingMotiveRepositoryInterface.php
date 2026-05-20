<?php

declare(strict_types=1);

namespace App\Domain\WorkOrderCancelingMotive\Repositories;

use App\Domain\WorkOrderCancelingMotive\Entities\WorkOrderCancelingMotive;
use App\Domain\WorkOrderCancelingMotive\ValueObjects\WorkOrderCancelingMotiveId;
use App\MotivoCancelamentoOrdemServico as CancelingMotiveModel;

interface WorkOrderCancelingMotiveRepositoryInterface
{
    public function save(WorkOrderCancelingMotive $parameter): ?CancelingMotiveModel;

    public function findById(WorkOrderCancelingMotiveId $id): ?CancelingMotiveModel;

    public function getAll(array $filter = []): ?array;

    public function update(WorkOrderCancelingMotive $parameter): void;

    public function destroy(WorkOrderCancelingMotive $parameter): void;
}
