<?php

namespace App\Application\Services\AccountReceivable;

use App\Application\Commands\AccountReceivable\CreateAccountReceivableCommand;
use App\ContaREceber;
use App\Domain\AccountReceivable\Entities\AccountReceivable;
use Illuminate\Support\Collection;

interface AccountReceivableApplicationServiceInterface
{
    public function store(
        CreateAccountReceivableCommand $command
    ): ?ContaREceber;

    public function findById(
        CreateAccountReceivableCommand $command
    ): ?ContaREceber;

    public function update(
        CreateAccountReceivableCommand $command
    ): void;

    public function getAll(array $data = []): ?Collection;
}
