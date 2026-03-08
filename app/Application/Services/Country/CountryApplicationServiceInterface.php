<?php

namespace App\Application\Services\Country;

use App\Application\Commands\Country\CreateCountryCommand;
use App\Pais;
use Illuminate\Support\Collection;

interface CountryApplicationServiceInterface
{
    public function store(
        CreateCountryCommand $command
    ): ?Pais;

    public function findById(
        CreateCountryCommand $command
    ): ?Pais;

    public function update(
        CreateCountryCommand $command
    ): void;


    public function destroy(
        CreateCountryCommand $command
    ): void;

    public function getAll(array $data = []): ?Collection;
}
