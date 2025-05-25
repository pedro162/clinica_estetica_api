<?php

namespace App\Application\Handlers\FinancialOperator;

use App\Application\Commands\FinancialOperator\CreateFinancialOperatorCommand;
use App\FormaPagamento;
use App\Domain\FinancialOperator\Entities\FinancialOperator;
use App\Domain\FinancialOperator\Repositories\FinancialOperatorRepositoryInterface;;

class CreateFinancialOperatorHandler
{
    private FinancialOperatorRepositoryInterface $repository;

    public function __construct(FinancialOperatorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateFinancialOperatorCommand $command): ?FormaPagamento
    {
        $entity = FinancialOperator::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
