<?php

namespace App\Domain\Category\Repositories;

use App\Categoria;
use App\Domain\Category\Entities\Category;
use App\Domain\Category\ValueObjects\CategoryId;

interface CategoryRepositoryInterface
{
    public function save(Category $parameter): ?Categoria;

    public function findById(CategoryId $id): ?Categoria;

    public function getAll(array $filter): ?array;

    public function update(Category $parameter): void;

    public function destroy(Category $parameter): void;
}
