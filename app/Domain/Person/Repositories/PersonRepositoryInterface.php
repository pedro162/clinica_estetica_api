<?php

namespace App\Domain\Person\Repositories;

use App\Domain\Person\Entities\Person;
use App\Domain\Person\ValueObjects\PersonDocument;
use App\Domain\Person\ValueObjects\PersonId;
use App\Pessoa;

interface PersonRepositoryInterface
{
    public function save(Person $task): ?Pessoa;
    public function findById(PersonId $id): ?Pessoa;
    public function findByDocument(PersonDocument $document): ?Pessoa;
    public function getAll(array $filter = []): ?array;
    public function update(Person $parameter): void;
    public function destroy(Person $parameter): void;
    public function syncGroupe(int $personId, int $groupId, array $data = []): void;
    public function syncAddress(int $personId, int $addressId, array $data = []): void;
    public function deletePhones(int $personId, array $data = []): void;
}
