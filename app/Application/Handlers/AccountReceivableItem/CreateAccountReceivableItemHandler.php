<?php

namespace App\Application\Handlers\AccountReceivableItem;

use App\Application\Commands\AccountReceivableItem\CreateAccountReceivableItemCommand;
use App\Caixa;
use App\Domain\AccountReceivableItem\Entities\AccountReceivableItem;
use App\Domain\AccountReceivableItem\Repositories\AccountReceivableItemRepositoryInterface;;

class CreateAccountReceivableItemHandler
{
    private AccountReceivableItemRepositoryInterface $repository;

    public function __construct(AccountReceivableItemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateAccountReceivableItemCommand $command): ?Caixa
    {
        $entity = AccountReceivableItem::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
