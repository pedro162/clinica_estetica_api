<?php

namespace App\Application\Handlers\Category;

use App\Domain\Category\Repositories\CategoryRepositoryInterface;
use Illuminate\Support\Collection;

class GetAllCategoryHandler
{
    private CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
