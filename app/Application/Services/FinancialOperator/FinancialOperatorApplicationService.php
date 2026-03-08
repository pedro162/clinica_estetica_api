<?php

namespace App\Application\Services\FinancialOperator;

use App\Application\Commands\FinancialOperator\CreateFinancialOperatorCommand;
use App\Application\Handlers\FinancialOperator\CreateFinancialOperatorHandler;
use App\Application\Handlers\FinancialOperator\DestroyFinancialOperatorHandler;
use App\Application\Handlers\FinancialOperator\GetAllFinancialOperatorHandler;
use App\Application\Handlers\FinancialOperator\GetFinancialOperatorByIdHandler;
use App\Application\Handlers\FinancialOperator\UpdateFinancialOperatorHandler;
use App\OperadorFinanceiro;
use Illuminate\Support\Collection;

class FinancialOperatorApplicationService implements FinancialOperatorApplicationServiceInterface
{
    private CreateFinancialOperatorHandler $createFinancialOperatorHandler;
    protected GetAllFinancialOperatorHandler $getAllFinancialOperatorHandler;
    protected UpdateFinancialOperatorHandler $updateFinancialOperatorHandler;
    protected DestroyFinancialOperatorHandler $destroyFinancialOperatorHandler;
    protected GetFinancialOperatorByIdHandler $getFinancialOperatorByIdHandler;

    public function __construct(
        CreateFinancialOperatorHandler $createFinancialOperatorHandler,
        GetAllFinancialOperatorHandler $getAllFinancialOperatorHandler,
        UpdateFinancialOperatorHandler $updateFinancialOperatorHandler,
        GetFinancialOperatorByIdHandler $getFinancialOperatorByIdHandler,
        DestroyFinancialOperatorHandler $destroyFinancialOperatorHandler
    ) {
        $this->createFinancialOperatorHandler = $createFinancialOperatorHandler;
        $this->getAllFinancialOperatorHandler = $getAllFinancialOperatorHandler;
        $this->updateFinancialOperatorHandler = $updateFinancialOperatorHandler;
        $this->destroyFinancialOperatorHandler = $destroyFinancialOperatorHandler;
        $this->getFinancialOperatorByIdHandler = $getFinancialOperatorByIdHandler;
    }

    public function store(
        CreateFinancialOperatorCommand $command
    ): ?OperadorFinanceiro {
        return $this->createFinancialOperatorHandler->handler($command);
    }

    public function update(
        CreateFinancialOperatorCommand $command
    ): void {

        $this->updateFinancialOperatorHandler->handler($command);
    }

    public function destroy(
        CreateFinancialOperatorCommand $command
    ): void {

        $this->destroyFinancialOperatorHandler->handler($command);
    }

    public function getAll(array $data = []): ?Collection
    {
        return $this->getAllFinancialOperatorHandler->handler($data);
    }

    public function findById(
        CreateFinancialOperatorCommand $command
    ): ?OperadorFinanceiro {

        return $this->getFinancialOperatorByIdHandler->handler($command);
    }
}
