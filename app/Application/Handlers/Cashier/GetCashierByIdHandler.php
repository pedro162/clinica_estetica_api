<?php

namespace App\Application\Handlers\Cashier;

use App\Application\Commands\Cashier\CreateCashierCommand;
use App\Caixa;
use App\Domain\Cashier\Repositories\CashierRepositoryInterface;

;

use App\Domain\Cashier\ValueObjects\CashierId;

class GetCashierByIdHandler
{
    private CashierRepositoryInterface $repository;

    public function __construct(CashierRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCashierCommand $command): ?Caixa
    {
        return $this->repository->findById(new CashierId($command->getId()));
    }
}
