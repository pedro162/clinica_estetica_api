<?php

namespace App\Application\Handlers\PaymentPlan;

use App\Application\Commands\PaymentPlan\CreatePaymentPlanCommand;
use App\PlanoPagamento;
use App\Domain\PaymentPlan\Entities\PaymentPlan;
use App\Domain\PaymentPlan\Repositories\PaymentPlanRepositoryInterface;;

class CreatePaymentPlanHandler
{
    private PaymentPlanRepositoryInterface $repository;

    public function __construct(PaymentPlanRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePaymentPlanCommand $command): ?PlanoPagamento
    {
        $entity = PaymentPlan::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
