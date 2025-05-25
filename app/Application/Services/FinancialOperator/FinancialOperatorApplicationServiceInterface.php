<?php

namespace App\Application\Services\FinancialOperator;

use App\Application\Commands\FinancialOperator\CreateFinancialOperatorCommand;
use App\OperadorFinanceiro;
use App\Domain\FinancialOperator\Entities\FinancialOperator;
use Illuminate\Support\Collection;

interface FinancialOperatorApplicationServiceInterface
{
    public function store(
        CreateFinancialOperatorCommand $command
    ): ?OperadorFinanceiro;

    public function findById(
        CreateFinancialOperatorCommand $command
    ): ?OperadorFinanceiro;

    public function update(
        CreateFinancialOperatorCommand $command
    ): void;

    public function destroy(
        CreateFinancialOperatorCommand $command
    ): void;

    public function getAll(array $data = []): ?Collection;
}
