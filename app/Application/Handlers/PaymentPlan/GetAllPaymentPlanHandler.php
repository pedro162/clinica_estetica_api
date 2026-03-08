<?php

namespace App\Application\Handlers\PaymentPlan;

use App\Domain\PaymentPlan\Repositories\PaymentPlanRepositoryInterface;
use Illuminate\Support\Collection;

class GetAllPaymentPlanHandler
{
    private PaymentPlanRepositoryInterface $repository;

    public function __construct(PaymentPlanRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
