<?php

namespace App\Application\Services\City;

use App\Application\Commands\City\CreateCityCommand;
use App\Domain\City\Entities\City;

interface CityApplicationServiceInterface
{
    public function store(
        CreateCityCommand $command
    ): ?City;

    public function update(
        CreateCityCommand $command
    ): ?City;

    public function getAll(array $data = []): ?array;
}
