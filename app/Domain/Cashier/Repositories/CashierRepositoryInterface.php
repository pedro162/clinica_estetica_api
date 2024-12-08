<?php

namespace App\Domain\Cashier\Repositories;

use App\Caixa;
use App\Domain\Cashier\Entities\Cashier;
use App\Domain\Cashier\ValueObjects\CashierId;

interface CashierRepositoryInterface
{
    public function save(Cashier $task): ?Caixa;
    public function findById(CashierId $id): ?Caixa;
    public function getAll(array $filter = []): ?array;
    public function update(Cashier $parameter): void;
}
