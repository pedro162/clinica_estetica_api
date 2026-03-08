<?php

namespace App\Application\Handlers\Seller;

use App\Application\Commands\Seller\CreateSellerCommand;
use App\Domain\Seller\Entities\Seller;
use App\Domain\Seller\Repositories\SellerRepositoryInterface;

;

class DestroySellerHandler
{
    private SellerRepositoryInterface $repository;

    public function __construct(SellerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateSellerCommand $command): void
    {
        $entity = Seller::buildEntity($command->getDataProperties());
        $this->repository->destroy($entity);
    }
}
