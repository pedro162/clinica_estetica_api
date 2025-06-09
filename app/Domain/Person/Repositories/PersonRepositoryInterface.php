<?php

namespace App\Domain\Person\Repositories;

use App\Domain\Person\Entities\Person;
use App\Domain\Person\ValueObjects\PersonId;
use App\Pessoa;

interface PersonRepositoryInterface
{
    public function save(Person $task): ?Pessoa;
    public function findById(PersonId $id): ?Pessoa;
    public function getAll(array $filter = []): ?array;
    public function update(Person $parameter): void;
    public function destroy(Person $parameter): void;
}
