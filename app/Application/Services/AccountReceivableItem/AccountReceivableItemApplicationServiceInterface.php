<?php

namespace App\Application\Services\AccountReceivableItem;

use App\Application\Commands\AccountReceivableItem\CreateAccountReceivableItemCommand;
use App\ContaReceberItem;
use App\Domain\AccountReceivableItem\Entities\AccountReceivableItem;
use Illuminate\Support\Collection;

interface AccountReceivableItemApplicationServiceInterface
{
    public function store(
        CreateAccountReceivableItemCommand $command
    ): ?Collection;

    public function findById(
        CreateAccountReceivableItemCommand $command
    ): ?ContaReceberItem;

    public function update(
        CreateAccountReceivableItemCommand $command
    ): void;

    public function getAll(array $data = []): ?Collection;
}
