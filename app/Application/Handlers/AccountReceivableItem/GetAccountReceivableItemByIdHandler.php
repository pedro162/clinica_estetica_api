<?php

namespace App\Application\Handlers\AccountReceivableItem;

use App\Application\Commands\AccountReceivableItem\CreateAccountReceivableItemCommand;
use App\Caixa;
use App\Domain\AccountReceivableItem\Entities\AccountReceivableItem;
use App\Domain\AccountReceivableItem\Repositories\AccountReceivableItemRepositoryInterface;;

use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemId;

class GetAccountReceivableItemByIdHandler
{
    private AccountReceivableItemRepositoryInterface $repository;

    public function __construct(AccountReceivableItemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateAccountReceivableItemCommand $command): ?Caixa
    {
        return $this->repository->findById(new AccountReceivableItemId($command->getId()));
    }
}
