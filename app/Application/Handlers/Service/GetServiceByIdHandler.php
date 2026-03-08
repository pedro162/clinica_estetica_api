<?php

namespace App\Application\Handlers\Service;

use App\Application\Commands\Service\CreateServiceCommand;
use App\Domain\Service\Repositories\ServiceRepositoryInterface;
use App\Servico as ServiceModel;

;

use App\Domain\Service\ValueObjects\ServiceId;

class GetServiceByIdHandler
{
    private ServiceRepositoryInterface $repository;

    public function __construct(ServiceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateServiceCommand $command): ?ServiceModel
    {
        return $this->repository->findById(new ServiceId($command->getId()));
    }
}
