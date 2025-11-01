<?php

namespace App\Application\Services\Service;

use App\Application\Commands\Service\CreateServiceCommand;
use App\Servico as ServiceModel;
use App\Domain\Service\Entities\Service;
use Illuminate\Support\Collection;

interface ServiceApplicationServiceInterface
{
    public function store(
        CreateServiceCommand $command
    ): ?ServiceModel;

    public function findById(
        CreateServiceCommand $command
    ): ?ServiceModel;

    public function update(
        CreateServiceCommand $command
    ): void;

    public function destroy(
        CreateServiceCommand $command
    ): void;

    public function getAll(array $data = []): ?Collection;
}
