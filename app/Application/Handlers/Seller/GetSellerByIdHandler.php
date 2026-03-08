<?php

namespace App\Application\Handlers\Seller;

use App\Application\Commands\Seller\CreateSellerCommand;
use App\Domain\Seller\Repositories\SellerRepositoryInterface;
use App\Rca;

;

use App\Domain\Seller\ValueObjects\SellerId;

class GetSellerByIdHandler
{
    private SellerRepositoryInterface $repository;

    public function __construct(SellerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateSellerCommand $command): ?Rca
    {
        return $this->repository->findById(new SellerId($command->getId()));
    }
}
