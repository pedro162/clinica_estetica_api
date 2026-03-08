<?php

namespace App\Application\Handlers\FinancialOperator;

use App\Application\Commands\FinancialOperator\CreateFinancialOperatorCommand;
use App\Domain\FinancialOperator\Entities\FinancialOperator;
use App\Domain\FinancialOperator\Repositories\FinancialOperatorRepositoryInterface;
use App\OperadorFinanceiro;

;

class CreateFinancialOperatorHandler
{
    private FinancialOperatorRepositoryInterface $repository;

    public function __construct(FinancialOperatorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateFinancialOperatorCommand $command): ?OperadorFinanceiro
    {
        $entity = FinancialOperator::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
