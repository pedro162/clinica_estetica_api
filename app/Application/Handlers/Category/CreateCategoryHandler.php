<?php

namespace App\Application\Handlers\Category;

use App\Application\Commands\Category\CreateCategoryCommand;
use App\Categoria as CategoryModel;
use App\Domain\Category\Entities\Category;
use App\Domain\Category\Repositories\CategoryRepositoryInterface;

class CreateCategoryHandler
{
    private CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCategoryCommand $command): ?CategoryModel
    {
        $entity = Category::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
