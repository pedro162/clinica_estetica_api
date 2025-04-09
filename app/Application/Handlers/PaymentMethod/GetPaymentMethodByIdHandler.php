<?php

namespace App\Application\Handlers\PaymentMethod;

use App\Application\Commands\PaymentMethod\CreatePaymentMethodCommand;
use App\Caixa;
use App\Domain\PaymentMethod\Entities\PaymentMethod;
use App\Domain\PaymentMethod\Repositories\PaymentMethodRepositoryInterface;;

use App\Domain\PaymentMethod\ValueObjects\PaymentMethodId;

class GetPaymentMethodByIdHandler
{
    private PaymentMethodRepositoryInterface $repository;

    public function __construct(PaymentMethodRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePaymentMethodCommand $command): ?Caixa
    {
        return $this->repository->findById(new PaymentMethodId($command->getId()));
    }
}
