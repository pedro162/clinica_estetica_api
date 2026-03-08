<?php

namespace App\Application\Handlers\FinancialOperator;

use App\Application\Commands\FinancialOperator\CreateFinancialOperatorCommand;
use App\Domain\FinancialOperator\Repositories\FinancialOperatorRepositoryInterface;
use App\OperadorFinanceiro;

;

use App\Domain\FinancialOperator\ValueObjects\FinancialOperatorId;

class GetFinancialOperatorByIdHandler
{
    private FinancialOperatorRepositoryInterface $repository;

    public function __construct(FinancialOperatorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateFinancialOperatorCommand $command): ?OperadorFinanceiro
    {
        return $this->repository->findById(new FinancialOperatorId($command->getId()));
    }
}
