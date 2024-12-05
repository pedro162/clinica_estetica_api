<?php

namespace App\Domain\City\Repositories;

use App\Cidade;
use App\Domain\City\Entities\City;
use App\Domain\City\ValueObjects\CityId;

interface CityRepositoryInterface
{
    public function save(City $parameter): ?Cidade;
    public function findById(CityId $id): ?Cidade;
    public function getAll(array $filter = []): ?array;
    public function update(City $parameter): void;
}
