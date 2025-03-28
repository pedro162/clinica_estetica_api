<?php

namespace App\Domain\FinancialMovements\Repositories;

use App\FinanceiroMovimentacoe;
use App\Domain\FinancialMovements\Entities\FinancialMovements;
use App\Domain\FinancialMovements\ValueObjects\FinancialMovementsId;

interface FinancialMovementsRepositoryInterface
{
    public function save(FinancialMovements $task): ?FinanceiroMovimentacoe;
    public function findById(FinancialMovementsId $id): ?FinanceiroMovimentacoe;
    public function getAll(array $filter = []): ?array;
    public function update(FinancialMovements $parameter): void;
}
