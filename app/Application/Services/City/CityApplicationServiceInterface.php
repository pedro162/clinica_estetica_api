<?php

namespace App\Application\Services\City;

use App\Application\Commands\City\CreateCityCommand;
use App\Cidade;
use App\Domain\City\Entities\City;
use Illuminate\Support\Collection;

interface CityApplicationServiceInterface
{
    public function store(
        CreateCityCommand $command
    ): ?Cidade;

    public function update(
        CreateCityCommand $command
    ): ?City;

    public function getAll(array $data = []): ?Collection;
}
