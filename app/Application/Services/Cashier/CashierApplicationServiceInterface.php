<?php

namespace App\Application\Services\Cashier;

use App\Application\Commands\Cashier\CreateCashierCommand;
use App\Caixa;
use Illuminate\Support\Collection;

interface CashierApplicationServiceInterface
{
    public function store(
        CreateCashierCommand $command
    ): ?Caixa;

    public function findById(
        CreateCashierCommand $command
    ): ?Caixa;

    public function update(
        CreateCashierCommand $command
    ): void;

    public function getAll(array $data = []): ?Collection;
}
