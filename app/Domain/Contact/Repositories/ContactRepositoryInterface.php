<?php

namespace App\Domain\Contact\Repositories;

use App\Domain\Contact\Entities\Contact;
use App\Domain\Contact\ValueObjects\ContactId;
use App\Telefone;

interface ContactRepositoryInterface
{
    public function save(Contact $task): ?Telefone;
    public function crateSimple(array $data): ?Telefone;
    public function findById(ContactId $id): ?Telefone;
    public function getAll(array $filter = []): ?array;
    public function update(Contact $parameter): void;
    public function destroy(Contact $parameter): void;
}
