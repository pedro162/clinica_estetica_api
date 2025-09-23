<?php

namespace App\Application\Handlers\CreditCardBrand;

use App\Application\Commands\CreditCardBrand\CreateCreditCardBrandCommand;
use App\Domain\CreditCardBrand\Entities\CreditCardBrand;
use App\Domain\CreditCardBrand\Repositories\CreditCardBrandRepositoryInterface;

class UpdateCreditCardBrandHandler
{
    private CreditCardBrandRepositoryInterface $repository;

    public function __construct(CreditCardBrandRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCreditCardBrandCommand $command): void
    {
        $entity = CreditCardBrand::buildEntity($command->getDataProperties());
        $this->repository->update($entity);
    }
}
