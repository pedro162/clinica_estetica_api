<?php

namespace App\Domain\City\Repositories;

use App\Domain\City\Entities\City;
use App\Domain\City\ValueObjects\CityId;

interface CityRepositoryInterface
{
    public function save(City $parameter): ?City;
    public function findById(CityId $id): ?City;
    public function getAll(array $filter = []): ?array;
    public function update(City $parameter): void;
}
