<?php

namespace App\Application\Services\Neighborhood;

use App\Application\Commands\Neighborhood\CreateNeighborhoodCommand;
use App\Bairro as NeiborhoodModel;
use App\Domain\Neighborhood\Entities\Neighborhood;
use App\Domain\Neighborhood\Repositories\NeighborhoodRepositoryInterface;
use App\Domain\Neighborhood\ValueObjects\NeighborhoodId;

class NeighborhoodApplicationService implements NeighborhoodApplicationServiceInterface
{
    public function __construct(private NeighborhoodRepositoryInterface $repository)
    {
    }

    public function store(CreateNeighborhoodCommand $command): NeiborhoodModel
    {
        $entity = Neighborhood::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }

    public function getAll(array $filters = []): array
    {
        return $this->repository->getAll($filters ?? []);
    }

    public function findById(CreateNeighborhoodCommand $command): NeiborhoodModel
    {
        $id = $command->getId();
        $neighborhood = $this->repository->findById(new NeighborhoodId((string)$id));

        if (!$neighborhood) {
            abort(404, 'Neighborhood not found');
        }

        return $neighborhood;
    }

    public function update(CreateNeighborhoodCommand $command): void
    {
        $entity = Neighborhood::buildEntity($command->getDataProperties());
        $this->repository->update($entity);
    }

    public function destroy(CreateNeighborhoodCommand $command): void
    {
        $entity = Neighborhood::buildEntity($command->getDataProperties());
        $this->repository->destroy($entity);
    }
}
