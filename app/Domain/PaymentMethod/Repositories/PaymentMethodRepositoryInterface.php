<?php

namespace App\Domain\PaymentMethod\Repositories;

use App\Caixa;
use App\Domain\PaymentMethod\Entities\PaymentMethod;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodId;

interface PaymentMethodRepositoryInterface
{
    public function save(PaymentMethod $task): ?Caixa;
    public function findById(PaymentMethodId $id): ?Caixa;
    public function getAll(array $filter = []): ?array;
    public function update(PaymentMethod $parameter): void;
}
