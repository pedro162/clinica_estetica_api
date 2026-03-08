<?php

namespace App\Application\Handlers\PaymentPlan;

use App\Application\Commands\PaymentPlan\CreatePaymentPlanCommand;
use App\Domain\PaymentPlan\Repositories\PaymentPlanRepositoryInterface;
use App\PlanoPagamento;

;

use App\Domain\PaymentPlan\ValueObjects\PaymentPlanId;

class GetPaymentPlanByIdHandler
{
    private PaymentPlanRepositoryInterface $repository;

    public function __construct(PaymentPlanRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePaymentPlanCommand $command): ?PlanoPagamento
    {
        return $this->repository->findById(new PaymentPlanId($command->getId()));
    }
}
