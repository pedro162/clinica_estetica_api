<?php

namespace App\Domain\WorkOrder\Repositories;

use App\Domain\WorkOrder\Entities\WorkOrder;
use App\Domain\WorkOrder\ValueObjects\WorkOrderId;
use App\OrdemServico;

interface WorkOrderRepositoryInterface
{
    public function save(WorkOrder $parameter): ?OrdemServico;

    public function findById(WorkOrderId $id): ?OrdemServico;

    public function getAll(array $filter): ?array;

    public function update(WorkOrder $parameter): void;

    public function destroy(WorkOrder $parameter): void;
}
