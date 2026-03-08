<?php

namespace App\Application\Services\Neighborhood;

use App\Application\Commands\Neighborhood\CreateNeighborhoodCommand;
use App\Bairro as NeighborhoodModel;

interface NeighborhoodApplicationServiceInterface
{
    public function store(CreateNeighborhoodCommand $command): NeighborhoodModel;

    public function getAll(array $filters = []): array;

    public function findById(CreateNeighborhoodCommand $command): NeighborhoodModel;

    public function update(CreateNeighborhoodCommand $command): void;

    public function destroy(CreateNeighborhoodCommand $command): void;
}
