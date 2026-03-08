<?php

namespace App\Application\Handlers\PaymentMethod;

use App\Domain\PaymentMethod\Repositories\PaymentMethodRepositoryInterface;
use Illuminate\Support\Collection;

class GetAllPaymentMethodHandler
{
    private PaymentMethodRepositoryInterface $repository;

    public function __construct(PaymentMethodRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
