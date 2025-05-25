<?php

namespace App\Domain\FinancialOperator\Repositories;

use App\OperadorFinanceiro;
use App\Domain\FinancialOperator\Entities\FinancialOperator;
use App\Domain\FinancialOperator\ValueObjects\FinancialOperatorId;

interface FinancialOperatorRepositoryInterface
{
    public function save(FinancialOperator $task): ?OperadorFinanceiro;
    public function findById(FinancialOperatorId $id): ?OperadorFinanceiro;
    public function getAll(array $filter = []): ?array;
    public function update(FinancialOperator $parameter): void;
    public function destroy(FinancialOperator $parameter): void;
}
