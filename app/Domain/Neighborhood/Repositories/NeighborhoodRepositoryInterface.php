<?php

namespace App\Domain\Neighborhood\Repositories;

use App\Bairro as NeiborhoodModel;
use App\Domain\Neighborhood\Entities\Neighborhood;
use App\Domain\Neighborhood\ValueObjects\NeighborhoodId;

interface NeighborhoodRepositoryInterface
{
    public function save(Neighborhood $parameter): ?NeiborhoodModel;

    public function findById(NeighborhoodId $id): ?NeiborhoodModel;

    public function getAll(array $filter): ?array;

    public function update(Neighborhood $parameter): void;

    public function destroy(Neighborhood $parameter): void;
}
