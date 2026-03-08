<?php

namespace App\Domain\PaymentPlan\Repositories;

use App\Domain\PaymentPlan\Entities\PaymentPlan;
use App\Domain\PaymentPlan\ValueObjects\PaymentPlanId;
use App\PlanoPagamento;

interface PaymentPlanRepositoryInterface
{
    public function save(PaymentPlan $task): ?PlanoPagamento;
    public function findById(PaymentPlanId $id): ?PlanoPagamento;
    public function getAll(array $filter = []): ?array;
    public function update(PaymentPlan $parameter): void;
    public function destroy(PaymentPlan $parameter): void;
}
