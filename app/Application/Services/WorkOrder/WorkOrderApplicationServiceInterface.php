<?php

namespace App\Application\Services\WorkOrder;

use App\Application\Commands\WorkOrder\CreateWorkOrderCommand;
use App\OrdemServico;
use Illuminate\Support\Collection;

interface WorkOrderApplicationServiceInterface
{
    public function store(CreateWorkOrderCommand $command): OrdemServico;

    public function getAll(array $filters = []): ?Collection;

    public function findById(CreateWorkOrderCommand $command): OrdemServico;

    public function update(CreateWorkOrderCommand $command): void;

    public function destroy(CreateWorkOrderCommand $command): void;

    public function conclude(array $data);

    public function cancel(array $data);

    public function finalize(array $data);

    public function addItem(array $data);

    public function removeItem(int $id);
}
