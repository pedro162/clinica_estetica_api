<?php

namespace App\Domain\Country\Repositories;

use App\Domain\Country\Entities\Country;
use App\Domain\Country\ValueObjects\CountryId;
use App\Pais;

interface CountryRepositoryInterface
{
    public function save(Country $parameter): ?Pais;
    public function findById(CountryId $id): ?Pais;
    public function getAll(array $filter): ?array;
    public function update(Country $parameter): void;
    public function destroy(Country $parameter): void;
}
