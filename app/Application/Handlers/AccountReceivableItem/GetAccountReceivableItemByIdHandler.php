<?php

namespace App\Application\Handlers\AccountReceivableItem;

use App\Application\Commands\AccountReceivableItem\CreateAccountReceivableItemCommand;
use App\ContaReceberItem;
use App\Domain\AccountReceivableItem\Repositories\AccountReceivableItemRepositoryInterface;

;

use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemId;

class GetAccountReceivableItemByIdHandler
{
    private AccountReceivableItemRepositoryInterface $repository;

    public function __construct(AccountReceivableItemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateAccountReceivableItemCommand $command): ?ContaReceberItem
    {
        return $this->repository->findById(new AccountReceivableItemId($command->getId()));
    }
}
