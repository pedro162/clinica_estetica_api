<?php

namespace App\Application\Services\WorkOrder;

use App\Application\Commands\WorkOrder\CreateWorkOrderCommand;
use App\Domain\WorkOrder\Entities\WorkOrder as WorkOrderEntity;
use App\Domain\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use App\Domain\WorkOrder\ValueObjects\WorkOrderId;
use App\Helpers\OrdemServicoHelper;
use App\OrdemServico;

class WorkOrderApplicationService implements WorkOrderApplicationServiceInterface
{
    public function __construct(
        protected WorkOrderRepositoryInterface $repository,
        protected OrdemServicoHelper $helper
    ) {
    }

    public function store(CreateWorkOrderCommand $command): OrdemServico
    {
        $entity = WorkOrderEntity::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }

    public function getAll(array $filters = []): array
    {
        return $this->repository->getAll($filters ?? []);
    }

    public function findById(CreateWorkOrderCommand $command): OrdemServico
    {
        $id = $command->getId();
        $workOrder = $this->repository->findById(new WorkOrderId((string)$id));

        if (!$workOrder) {
            abort(404, 'WorkOrder not found');
        }

        return $workOrder;
    }

    public function update(CreateWorkOrderCommand $command): void
    {
        $entity = WorkOrderEntity::buildEntity($command->getDataProperties());
        $this->repository->update($entity);
    }

    public function destroy(CreateWorkOrderCommand $command): void
    {
        $entity = WorkOrderEntity::buildEntity($command->getDataProperties());
        $this->repository->destroy($entity);
    }

    public function conclude(array $data)
    {
        $id = $data['id'] ?? null;
        return $this->helper->concluir($data, $id);
    }

    public function cancel(array $data)
    {
        $id = $data['id'] ?? null;
        return $this->helper->cancelar($data, $id);
    }

    public function finalize(array $data)
    {
        $id = $data['id'] ?? null;
        return $this->helper->finalizar($data, $id);
    }

    public function addItem(array $data)
    {
        $id = $data['id'] ?? null;
        return $this->helper->adicionarItem($data, $id);
    }

    public function removeItem(int $id)
    {
        return $this->helper->removerItem($id);
    }
}
