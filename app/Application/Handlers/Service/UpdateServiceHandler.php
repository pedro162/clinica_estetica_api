<?php

namespace App\Application\Handlers\Service;

use App\Application\Commands\Service\CreateServiceCommand;
use App\Domain\Service\Entities\Service;
use App\Domain\Service\Repositories\ServiceRepositoryInterface;

;

class UpdateServiceHandler
{
    private ServiceRepositoryInterface $repository;

    public function __construct(ServiceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateServiceCommand $command): void
    {
        $entity = Service::buildEntity($command->getDataProperties());
        $this->repository->update($entity);
    }
}
