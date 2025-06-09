<?php

namespace App\Application\Services\Person;

use App\Application\Commands\Person\CreatePersonCommand;
use App\PlanoPagamento;
use App\Domain\Person\Entities\Person;
use Illuminate\Support\Collection;

interface PersonApplicationServiceInterface
{
    public function store(
        CreatePersonCommand $command
    ): ?PlanoPagamento;

    public function findById(
        CreatePersonCommand $command
    ): ?PlanoPagamento;

    public function update(
        CreatePersonCommand $command
    ): void;

    public function destroy(
        CreatePersonCommand $command
    ): void;

    public function getAll(array $data = []): ?Collection;
}
