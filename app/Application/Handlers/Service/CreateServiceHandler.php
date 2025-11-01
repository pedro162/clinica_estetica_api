<?php

namespace App\Application\Handlers\Service;

use App\Application\Commands\Service\CreateServiceCommand;
use App\Servico as ServiceModel;
use App\Domain\Service\Entities\Service;
use App\Domain\Service\Repositories\ServiceRepositoryInterface;;

class CreateServiceHandler
{
    private ServiceRepositoryInterface $repository;

    public function __construct(ServiceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateServiceCommand $command): ?ServiceModel
    {
        $entity = Service::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
