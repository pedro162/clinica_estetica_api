<?php

namespace App\Application\Services\Category;

use App\Application\Commands\Category\CreateCategoryCommand;
use App\Categoria;

interface CategoryApplicationServiceInterface
{
    public function store(CreateCategoryCommand $command): Categoria;

    public function getAll(array $filters = []): array;

    public function findById(CreateCategoryCommand $command): Categoria;

    public function update(CreateCategoryCommand $command): void;

    public function destroy(CreateCategoryCommand $command): void;
}
