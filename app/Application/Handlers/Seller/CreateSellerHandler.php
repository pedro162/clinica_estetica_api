<?php

namespace App\Application\Handlers\Seller;

use App\Application\Commands\Seller\CreateSellerCommand;
use App\Rca;
use App\Domain\Seller\Entities\Seller;
use App\Domain\Seller\Repositories\SellerRepositoryInterface;;

class CreateSellerHandler
{
    private SellerRepositoryInterface $repository;

    public function __construct(SellerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateSellerCommand $command): ?Rca
    {
        $entity = Seller::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
