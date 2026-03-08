<?php

namespace App\Application\Services\Category;

use App\Application\Commands\Category\CreateCategoryCommand;
use App\Categoria;
use App\Domain\Category\Entities\Category as CategoryEntity;
use App\Domain\Category\Repositories\CategoryRepositoryInterface;
use App\Domain\Category\ValueObjects\CategoryId;

class CategoryApplicationService implements CategoryApplicationServiceInterface
{
    public function __construct(
        protected CategoryRepositoryInterface $repository
    ) {
    }

    public function store(CreateCategoryCommand $command): Categoria
    {
        $entity = CategoryEntity::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }

    public function getAll(array $filters = []): array
    {
        return $this->repository->getAll($filters ?? []);
    }

    public function findById(CreateCategoryCommand $command): Categoria
    {
        $id = $command->getId();
        $category = $this->repository->findById(new CategoryId((string)$id));

        if (!$category) {
            abort(404, 'Category not found');
        }

        return $category;
    }

    public function update(CreateCategoryCommand $command): void
    {
        $entity = CategoryEntity::buildEntity($command->getDataProperties());
        $this->repository->update($entity);
    }

    public function destroy(CreateCategoryCommand $command): void
    {
        $entity = CategoryEntity::buildEntity($command->getDataProperties());
        $this->repository->destroy($entity);
    }
}
