<?php

namespace App\Domain\Cashier\Repositories;

use App\Domain\Cashier\Entities\Cashier;
use App\Domain\Cashier\ValueObjects\CashierId;

interface CashierRepositoryInterface
{
    public function save(Cashier $task): ?Cashier;
    public function findById(CashierId $id): ?Cashier;
    public function getAll(array $filter = []): ?array;
    public function update(Cashier $parameter): void;
}
