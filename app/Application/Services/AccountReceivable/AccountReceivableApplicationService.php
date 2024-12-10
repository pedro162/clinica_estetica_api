<?php

namespace App\Application\Services\AccountReceivable;

use App\Application\Commands\AccountReceivable\CreateAccountReceivableCommand;
use App\Application\Handlers\AccountReceivable\CreateAccountReceivableHandler;
use App\Application\Handlers\AccountReceivable\GetAllAccountReceivableHandler;
use App\Application\Handlers\AccountReceivable\GetAccountReceivableByIdHandler;
use App\Application\Handlers\AccountReceivable\UpdateAccountReceivableHandler;
use App\ContaReceber;
use App\Domain\AccountReceivable\Entities\AccountReceivable;
use Illuminate\Support\Collection;

class AccountReceivableApplicationService implements AccountReceivableApplicationServiceInterface
{
    private CreateAccountReceivableHandler $createAccountReceivableHandler;
    protected GetAllAccountReceivableHandler $getAllAccountReceivableHandler;
    protected UpdateAccountReceivableHandler $updateAccountReceivableHandler;
    protected GetAccountReceivableByIdHandler $getAccountReceivableByIdHandler;

    public function __construct(
        CreateAccountReceivableHandler $createAccountReceivableHandler,
        GetAllAccountReceivableHandler $getAllAccountReceivableHandler,
        UpdateAccountReceivableHandler $updateAccountReceivableHandler,
        GetAccountReceivableByIdHandler $getAccountReceivableByIdHandler
    ) {
        $this->createAccountReceivableHandler = $createAccountReceivableHandler;
        $this->getAllAccountReceivableHandler = $getAllAccountReceivableHandler;
        $this->updateAccountReceivableHandler = $updateAccountReceivableHandler;
        $this->getAccountReceivableByIdHandler = $getAccountReceivableByIdHandler;
    }

    public function store(
        CreateAccountReceivableCommand $command
    ): ?ContaReceber {
        return $this->createAccountReceivableHandler->handler($command);
    }

    public function update(
        CreateAccountReceivableCommand $command
    ): void {

        $this->updateAccountReceivableHandler->handler($command);
    }

    public function getAll(array $data = []): ?Collection
    {
        return $this->getAllAccountReceivableHandler->handler($data);
    }

    public function findById(
        CreateAccountReceivableCommand $command
    ): ?ContaReceber {

        return $this->getAccountReceivableByIdHandler->handler($command);
    }
}
