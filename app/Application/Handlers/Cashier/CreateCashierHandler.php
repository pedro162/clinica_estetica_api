<?php

namespace App\Application\Handlers\Cashier;

use App\Application\Commands\Cashier\CreateCashierCommand;
use App\Caixa;
use App\Domain\Cashier\Entities\Cashier;
use App\Domain\Cashier\Repositories\CashierRepositoryInterface;

;

class CreateCashierHandler
{
    private CashierRepositoryInterface $repository;

    public function __construct(CashierRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCashierCommand $command): ?Caixa
    {
        $entity = Cashier::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
