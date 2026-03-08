<?php

namespace App\Application\Services\Cashier;

use App\Application\Commands\Cashier\CreateCashierCommand;
use App\Application\Handlers\Cashier\CreateCashierHandler;
use App\Application\Handlers\Cashier\GetAllCashierHandler;
use App\Application\Handlers\Cashier\GetCashierByIdHandler;
use App\Application\Handlers\Cashier\UpdateCashierHandler;
use App\Caixa;
use Illuminate\Support\Collection;

class CashierApplicationService implements CashierApplicationServiceInterface
{
    private CreateCashierHandler $createCashierHandler;
    protected GetAllCashierHandler $getAllCashierHandler;
    protected UpdateCashierHandler $updateCashierHandler;
    protected GetCashierByIdHandler $getCashierByIdHandler;

    public function __construct(
        CreateCashierHandler $createCashierHandler,
        GetAllCashierHandler $getAllCashierHandler,
        UpdateCashierHandler $updateCashierHandler,
        GetCashierByIdHandler $getCashierByIdHandler
    ) {
        $this->createCashierHandler = $createCashierHandler;
        $this->getAllCashierHandler = $getAllCashierHandler;
        $this->updateCashierHandler = $updateCashierHandler;
        $this->getCashierByIdHandler = $getCashierByIdHandler;
    }

    public function store(
        CreateCashierCommand $command
    ): ?Caixa {
        return $this->createCashierHandler->handler($command);
    }

    public function update(
        CreateCashierCommand $command
    ): void {

        $this->updateCashierHandler->handler($command);
    }

    public function getAll(array $data = []): ?Collection
    {
        return $this->getAllCashierHandler->handler($data);
    }

    public function findById(
        CreateCashierCommand $command
    ): ?Caixa {

        return $this->getCashierByIdHandler->handler($command);
    }
}
