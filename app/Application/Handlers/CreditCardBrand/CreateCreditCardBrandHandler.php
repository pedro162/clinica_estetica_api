<?php

namespace App\Application\Handlers\CreditCardBrand;

use App\Application\Commands\CreditCardBrand\CreateCreditCardBrandCommand;
use App\BandeiraCartao;
use App\Domain\CreditCardBrand\Entities\CreditCardBrand;
use App\Domain\CreditCardBrand\Repositories\CreditCardBrandRepositoryInterface;;

class CreateCreditCardBrandHandler
{
    private CreditCardBrandRepositoryInterface $repository;

    public function __construct(CreditCardBrandRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCreditCardBrandCommand $command): ?BandeiraCartao
    {
        $entity = CreditCardBrand::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
