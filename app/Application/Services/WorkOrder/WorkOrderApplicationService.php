<?php

namespace App\Application\Services\WorkOrder;

use App\Application\Commands\WorkOrder\CreateWorkOrderCommand;
use App\Application\Handlers\WorkOrder\CreateWorkOrderHandler;
use App\Application\Handlers\WorkOrder\DestroyWorkOrderHandler;
use App\Application\Handlers\WorkOrder\GetAllWorkOrderHandler;
use App\Application\Handlers\WorkOrder\GetWorkOrderByIdHandler;
use App\Application\Handlers\WorkOrder\UpdateWorkOrderHandler;
use App\Domain\WorkOrder\Entities\WorkOrder as WorkOrderEntity;
use App\Domain\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use App\Domain\WorkOrder\ValueObjects\WorkOrderId;
use App\Helpers\OrdemServicoHelper;
use App\OrdemServico;
use Illuminate\Support\Collection;

class WorkOrderApplicationService implements WorkOrderApplicationServiceInterface
{
    public function __construct(
        protected WorkOrderRepositoryInterface $repository,
        protected OrdemServicoHelper $helper,
        private CreateWorkOrderHandler $createWorkOrderHandler,
        protected GetAllWorkOrderHandler $getAllWorkOrderHandler,
        protected UpdateWorkOrderHandler $updateWorkOrderHandler,
        protected DestroyWorkOrderHandler $destroyWorkOrderHandler,
        protected GetWorkOrderByIdHandler $getWorkOrderByIdHandler
    ) {
    }

    public function store(CreateWorkOrderCommand $command): OrdemServico
    {
        $entity = WorkOrderEntity::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }

    public function getAll(array $filters = []): ?Collection
    {
        return $this->getAllWorkOrderHandler->handler($filters);
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
