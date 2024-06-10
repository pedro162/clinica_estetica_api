<?php

namespace App\Domain\Person\Repositories;

use App\Domain\Person\Entities\Person;
use App\Domain\Person\ValueObjects\PersonId;

interface PersonRepositoryInterface
{
    public function save(Person $task): ?Person;
    public function findById(PersonId $id): ?Person;
}
