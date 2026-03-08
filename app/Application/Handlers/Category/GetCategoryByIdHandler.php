<?php

namespace App\Application\Handlers\Category;

use App\Application\Commands\Category\CreateCategoryCommand;
use App\Categoria as CategoryModel;
use App\Domain\Category\Repositories\CategoryRepositoryInterface;
use App\Domain\Category\ValueObjects\CategoryId;

class GetCategoryByIdHandler
{
    private CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCategoryCommand $command): ?CategoryModel
    {
        return $this->repository->findById(new CategoryId($command->getId()));
    }
}
