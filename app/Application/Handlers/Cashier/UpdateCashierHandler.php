<?php

namespace App\Application\Handlers\Cashier;

use App\Application\Commands\Cashier\CreateCashierCommand;
use App\Domain\Cashier\Entities\Cashier;
use App\Domain\Cashier\Repositories\CashierRepositoryInterface;;

class UpdateCashierHandler
{
    private CashierRepositoryInterface $repository;

    public function __construct(CashierRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCashierCommand $command): void
    {
        $entity = Cashier::buildEntity($command->getDataProperties());
        $this->repository->update($entity);
    }
}
