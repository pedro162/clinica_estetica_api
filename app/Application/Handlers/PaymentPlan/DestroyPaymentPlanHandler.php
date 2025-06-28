<?php

namespace App\Application\Handlers\PaymentPlan;

use App\Application\Commands\PaymentPlan\CreatePaymentPlanCommand;
use App\Domain\PaymentPlan\Entities\PaymentPlan;
use App\Domain\PaymentPlan\Repositories\PaymentPlanRepositoryInterface;;

class DestroyPaymentPlanHandler
{
    private PaymentPlanRepositoryInterface $repository;

    public function __construct(PaymentPlanRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePaymentPlanCommand $command): void
    {
        $entity = PaymentPlan::buildEntity($command->getDataProperties());
        $this->repository->destroy($entity);
    }
}
