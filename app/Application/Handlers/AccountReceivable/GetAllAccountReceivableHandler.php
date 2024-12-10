<?php

namespace App\Application\Handlers\AccountReceivable;

use App\Application\Commands\AccountReceivable\CreateAccountReceivableCommand;
use App\Domain\AccountReceivable\Entities\AccountReceivable;
use App\Domain\AccountReceivable\Repositories\AccountReceivableRepositoryInterface;
use Illuminate\Support\Collection;

class GetAllAccountReceivableHandler
{
    private AccountReceivableRepositoryInterface $repository;

    public function __construct(AccountReceivableRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
