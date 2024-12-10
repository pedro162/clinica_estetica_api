<?php

namespace App\Application\Handlers\AccountReceivable;

use App\Application\Commands\AccountReceivable\CreateAccountReceivableCommand;
use App\Domain\AccountReceivable\Entities\AccountReceivable;
use App\Domain\AccountReceivable\Repositories\AccountReceivableRepositoryInterface;;

class UpdateAccountReceivableHandler
{
    private AccountReceivableRepositoryInterface $repository;

    public function __construct(AccountReceivableRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateAccountReceivableCommand $command): void
    {
        $entity = AccountReceivable::buildEntity($command->getDataProperties());
        $this->repository->update($entity);
    }
}
