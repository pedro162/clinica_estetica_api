<?php

namespace App\Application\Handlers\AccountReceivableItem;

use App\Application\Commands\AccountReceivableItem\CreateAccountReceivableItemCommand;
use App\Domain\AccountReceivableItem\Entities\AccountReceivableItem;
use App\Domain\AccountReceivableItem\Repositories\AccountReceivableItemRepositoryInterface;
use Illuminate\Support\Collection;

class GetAllAccountReceivableItemHandler
{
    private AccountReceivableItemRepositoryInterface $repository;

    public function __construct(AccountReceivableItemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
