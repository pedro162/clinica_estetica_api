<?php

namespace App\Application\Handlers\CreditCardBrand;

use App\Application\Commands\CreditCardBrand\CreateCreditCardBrandCommand;
use App\BandeiraCartao;
use App\Domain\CreditCardBrand\Repositories\CreditCardBrandRepositoryInterface;;

use App\Domain\CreditCardBrand\ValueObjects\CreditCardBrandId;

class GetCreditCardBrandByIdHandler
{
    private CreditCardBrandRepositoryInterface $repository;

    public function __construct(CreditCardBrandRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCreditCardBrandCommand $command): ?BandeiraCartao
    {
        return $this->repository->findById(new CreditCardBrandId($command->getId()));
    }
}
