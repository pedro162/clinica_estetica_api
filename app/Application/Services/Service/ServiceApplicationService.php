<?php

namespace App\Application\Services\Service;

use App\Application\Commands\Service\CreateServiceCommand;
use App\Application\Handlers\Service\CreateServiceHandler;
use App\Application\Handlers\Service\DestroyServiceHandler;
use App\Application\Handlers\Service\GetAllServiceHandler;
use App\Application\Handlers\Service\GetServiceByIdHandler;
use App\Application\Handlers\Service\UpdateServiceHandler;
use App\Servico as ServiceModel;
use Illuminate\Support\Collection;

class ServiceApplicationService implements ServiceApplicationServiceInterface
{
    public function __construct(
        private CreateServiceHandler $createServiceHandler,
        protected GetAllServiceHandler $getAllServiceHandler,
        protected UpdateServiceHandler $updateServiceHandler,
        protected DestroyServiceHandler $destroyServiceHandler,
        protected GetServiceByIdHandler $getServiceByIdHandler
    ) {
    }

    public function store(
        CreateServiceCommand $command
    ): ?ServiceModel {
        return $this->createServiceHandler->handler($command);
    }

    public function update(
        CreateServiceCommand $command
    ): void {

        $this->updateServiceHandler->handler($command);
    }

    public function destroy(
        CreateServiceCommand $command
    ): void {

        $this->destroyServiceHandler->handler($command);
    }

    public function getAll(array $data = []): ?Collection
    {
        return $this->getAllServiceHandler->handler($data);
    }

    public function findById(
        CreateServiceCommand $command
    ): ?ServiceModel {

        return $this->getServiceByIdHandler->handler($command);
    }
}
