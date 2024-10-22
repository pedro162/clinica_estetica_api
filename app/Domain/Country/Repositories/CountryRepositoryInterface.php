<?php

namespace App\Domain\Country\Repositories;

use App\Domain\Country\Entities\Country;
use App\Domain\Country\ValueObjects\CountryId;

interface CountryRepositoryInterface
{
    public function save(Country $parameter): ?Country;
    public function findById(CountryId $id): ?Country;
    public function getAll(array $filter);
}
