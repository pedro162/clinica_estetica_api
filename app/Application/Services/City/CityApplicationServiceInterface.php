<?php

namespace App\Application\Services\City;

use App\Application\Commands\City\CreateCityCommand;
use App\Cidade;
use Illuminate\Support\Collection;

interface CityApplicationServiceInterface
{
    public function store(
        CreateCityCommand $command
    ): ?Cidade;

    public function findById(
        CreateCityCommand $command
    ): ?Cidade;

    public function update(
        CreateCityCommand $command
    ): void;

    public function getAll(array $data = []): ?Collection;
}
