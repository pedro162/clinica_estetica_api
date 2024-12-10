<?php

namespace App\Application\Services\AccountReceivableItem;

use App\Application\Commands\AccountReceivableItem\CreateAccountReceivableItemCommand;
use App\Application\Handlers\AccountReceivableItem\CreateAccountReceivableItemHandler;
use App\Application\Handlers\AccountReceivableItem\GetAllAccountReceivableItemHandler;
use App\Application\Handlers\AccountReceivableItem\GetAccountReceivableItemByIdHandler;
use App\Application\Handlers\AccountReceivableItem\UpdateAccountReceivableItemHandler;
use App\ContaREceberItem;
use App\Domain\AccountReceivableItem\Entities\AccountReceivableItem;
use Illuminate\Support\Collection;

class AccountReceivableItemApplicationService implements AccountReceivableItemApplicationServiceInterface
{
    private CreateAccountReceivableItemHandler $createAccountReceivableItemHandler;
    protected GetAllAccountReceivableItemHandler $getAllAccountReceivableItemHandler;
    protected UpdateAccountReceivableItemHandler $updateAccountReceivableItemHandler;
    protected GetAccountReceivableItemByIdHandler $getAccountReceivableItemByIdHandler;

    public function __construct(
        CreateAccountReceivableItemHandler $createAccountReceivableItemHandler,
        GetAllAccountReceivableItemHandler $getAllAccountReceivableItemHandler,
        UpdateAccountReceivableItemHandler $updateAccountReceivableItemHandler,
        GetAccountReceivableItemByIdHandler $getAccountReceivableItemByIdHandler
    ) {
        $this->createAccountReceivableItemHandler = $createAccountReceivableItemHandler;
        $this->getAllAccountReceivableItemHandler = $getAllAccountReceivableItemHandler;
        $this->updateAccountReceivableItemHandler = $updateAccountReceivableItemHandler;
        $this->getAccountReceivableItemByIdHandler = $getAccountReceivableItemByIdHandler;
    }

    public function store(
        CreateAccountReceivableItemCommand $command
    ): ?ContaREceberItem {
        return $this->createAccountReceivableItemHandler->handler($command);
    }

    public function update(
        CreateAccountReceivableItemCommand $command
    ): void {

        $this->updateAccountReceivableItemHandler->handler($command);
    }

    public function getAll(array $data = []): ?Collection
    {
        return $this->getAllAccountReceivableItemHandler->handler($data);
    }

    public function findById(
        CreateAccountReceivableItemCommand $command
    ): ?ContaREceberItem {

        return $this->getAccountReceivableItemByIdHandler->handler($command);
    }
}
