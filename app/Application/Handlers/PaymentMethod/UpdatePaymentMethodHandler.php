<?php

namespace App\Application\Handlers\PaymentMethod;

use App\Application\Commands\PaymentMethod\CreatePaymentMethodCommand;
use App\Domain\FinancialOperator\Entities\FinancialOperator;
use App\Domain\PaymentMethod\Entities\PaymentMethod;
use App\Domain\PaymentMethod\Repositories\PaymentMethodRepositoryInterface;
use App\Domain\PaymentPlan\Entities\PaymentPlan;

;

class UpdatePaymentMethodHandler
{
    private PaymentMethodRepositoryInterface $repository;

    public function __construct(PaymentMethodRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePaymentMethodCommand $command): void
    {
        $entity = PaymentMethod::buildEntity($command->getDataProperties());
        $this->repository->update($entity);
    }

    public function syncFinancialOperators(CreatePaymentMethodCommand $command): void
    {
        $entity = PaymentMethod::buildEntity($command->getDataProperties());
        $financialOperators = $command->getFinanceOperators() ?? [];
        $financialOperators = array_map(
            fn ($item) =>  $entity->addFinancialOperator(
                FinancialOperator::buildEntity($item->getDataProperties())
            ),
            $financialOperators
        );

        $this->repository->syncFinancialOperator($entity);
    }

    public function syncPaymentPlans(CreatePaymentMethodCommand $command): void
    {
        $entity = PaymentMethod::buildEntity($command->getDataProperties());
        $paymentPlans = $command->getPaymentPlans() ?? [];
        $paymentPlans = array_map(
            fn ($item) =>  $entity->addPaymentPlan(
                PaymentPlan::buildEntity($item->getDataProperties())
            ),
            $paymentPlans
        );

        $this->repository->syncPaymentPlan($entity);
    }
}
