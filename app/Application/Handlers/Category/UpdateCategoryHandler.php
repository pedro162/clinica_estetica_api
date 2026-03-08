<?php

namespace App\Application\Handlers\Category;

use App\Application\Commands\Category\CreateCategoryCommand;
use App\Domain\Category\Entities\Category;
use App\Domain\Category\Repositories\CategoryRepositoryInterface;

class UpdateCategoryHandler
{
    private CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCategoryCommand $command): void
    {
        $entity = Category::buildEntity($command->getDataProperties());
        $this->repository->update($entity);
    }
}
