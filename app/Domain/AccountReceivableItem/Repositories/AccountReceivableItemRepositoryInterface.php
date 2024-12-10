<?php

namespace App\Domain\AccountReceivableItem\Repositories;

use App\ContaReceberItem;
use App\Domain\AccountReceivableItem\Entities\AccountReceivableItem;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemId;

interface AccountReceivableItemRepositoryInterface
{
    public function save(AccountReceivableItem $task): ?ContaReceberItem;
    public function findById(AccountReceivableItemId $id): ?ContaReceberItem;
    public function getAll(array $filter = []): ?array;
    public function update(AccountReceivableItem $parameter): void;
}
