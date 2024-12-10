<?php

namespace App\Application\Handlers\AccountReceivable;

use App\Application\Commands\AccountReceivable\CreateAccountReceivableCommand;
use App\Caixa;
use App\Domain\AccountReceivable\Entities\AccountReceivable;
use App\Domain\AccountReceivable\Repositories\AccountReceivableRepositoryInterface;;

class CreateAccountReceivableHandler
{
    private AccountReceivableRepositoryInterface $repository;

    public function __construct(AccountReceivableRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateAccountReceivableCommand $command): ?Caixa
    {
        $entity = AccountReceivable::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
