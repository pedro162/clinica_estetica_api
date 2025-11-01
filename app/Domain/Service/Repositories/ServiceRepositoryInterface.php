<?php

namespace App\Domain\Service\Repositories;

use App\Servico;
use App\Domain\Service\Entities\Service;
use App\Domain\Service\ValueObjects\ServiceId;

interface ServiceRepositoryInterface
{
    public function save(Service $task): ?Servico;
    public function findById(ServiceId $id): ?Servico;
    public function getAll(array $filter = []): ?array;
    public function update(Service $parameter): void;
    public function destroy(Service $parameter): void;
}
