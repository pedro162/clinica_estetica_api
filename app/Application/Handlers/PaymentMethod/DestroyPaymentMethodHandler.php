<?php

namespace App\Application\Handlers\PaymentMethod;

use App\Application\Commands\PaymentMethod\CreatePaymentMethodCommand;
use App\Domain\PaymentMethod\Entities\PaymentMethod;
use App\Domain\PaymentMethod\Repositories\PaymentMethodRepositoryInterface;

;

class DestroyPaymentMethodHandler
{
    private PaymentMethodRepositoryInterface $repository;

    public function __construct(PaymentMethodRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePaymentMethodCommand $command): void
    {
        $entity = PaymentMethod::buildEntity($command->getDataProperties());
        $this->repository->destroy($entity);
    }
}
