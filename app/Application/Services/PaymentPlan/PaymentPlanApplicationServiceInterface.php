<?php

namespace App\Application\Services\PaymentPlan;

use App\Application\Commands\PaymentPlan\CreatePaymentPlanCommand;
use App\PlanoPagamento;
use Illuminate\Support\Collection;

interface PaymentPlanApplicationServiceInterface
{
    public function store(
        CreatePaymentPlanCommand $command
    ): ?PlanoPagamento;

    public function findById(
        CreatePaymentPlanCommand $command
    ): ?PlanoPagamento;

    public function update(
        CreatePaymentPlanCommand $command
    ): void;

    public function destroy(
        CreatePaymentPlanCommand $command
    ): void;

    public function getAll(array $data = []): ?Collection;
}
