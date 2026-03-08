<?php

namespace App\Application\Handlers\FinancialOperator;

use App\Application\Commands\FinancialOperator\CreateFinancialOperatorCommand;
use App\Domain\FinancialOperator\Entities\FinancialOperator;
use App\Domain\FinancialOperator\Repositories\FinancialOperatorRepositoryInterface;

;

class UpdateFinancialOperatorHandler
{
    private FinancialOperatorRepositoryInterface $repository;

    public function __construct(FinancialOperatorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateFinancialOperatorCommand $command): void
    {
        $entity = FinancialOperator::buildEntity($command->getDataProperties());
        $this->repository->update($entity);
    }
}
