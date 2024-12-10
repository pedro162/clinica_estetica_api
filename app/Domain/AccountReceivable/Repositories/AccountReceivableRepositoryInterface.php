<?php

namespace App\Domain\AccountReceivable\Repositories;

use App\ContaReceber;
use App\Domain\AccountReceivable\Entities\AccountReceivable;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableId;

interface AccountReceivableRepositoryInterface
{
    public function save(AccountReceivable $task): ?ContaReceber;
    public function findById(AccountReceivableId $id): ?ContaReceber;
    public function getAll(array $filter = []): ?array;
    public function update(AccountReceivable $parameter): void;
    public function getLiquidityBillingByMonthYear(array $filter = []): ?array;
    public function getLiquidityBillingByBranch(array $filter = []): ?array;
    public function getLiquidityBillingByProfessional(array $filter = []): ?array;
}
