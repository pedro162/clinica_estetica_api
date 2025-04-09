<?php

namespace App\Application\Handlers\PaymentMethod;

use App\Application\Commands\PaymentMethod\CreatePaymentMethodCommand;
use App\Caixa;
use App\Domain\PaymentMethod\Entities\PaymentMethod;
use App\Domain\PaymentMethod\Repositories\PaymentMethodRepositoryInterface;;

class CreatePaymentMethodHandler
{
    private PaymentMethodRepositoryInterface $repository;

    public function __construct(PaymentMethodRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePaymentMethodCommand $command): ?Caixa
    {
        $entity = PaymentMethod::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
