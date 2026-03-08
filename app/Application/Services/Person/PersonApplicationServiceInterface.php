<?php

namespace App\Application\Services\Person;

use App\Application\Commands\Person\CreatePersonCommand;
use App\Pessoa;
use Illuminate\Support\Collection;

interface PersonApplicationServiceInterface
{
    public function store(
        CreatePersonCommand $command
    ): ?Pessoa;

    public function findById(
        CreatePersonCommand $command
    ): ?Pessoa;

    public function update(
        CreatePersonCommand $command
    ): void;

    public function destroy(
        CreatePersonCommand $command
    ): void;

    public function getAll(array $data = []): ?Collection;
}
