<?php

namespace App\Application\Services\AccountReceivable;

use App\Application\Commands\AccountReceivable\CreateAccountReceivableCommand;
use App\ContaReceber;
use App\Domain\AccountReceivable\Entities\AccountReceivable;
use Illuminate\Support\Collection;

interface AccountReceivableApplicationServiceInterface
{
    public function store(
        CreateAccountReceivableCommand $command
    ): ?Collection;

    public function findById(
        CreateAccountReceivableCommand $command
    ): ?ContaReceber;

    public function update(
        CreateAccountReceivableCommand $command
    ): void;

    public function payOff(
        CreateAccountReceivableCommand $command,
        array $data = []
    ): ?ContaReceber;

    public function getAll(array $data = []): ?Collection;
}
