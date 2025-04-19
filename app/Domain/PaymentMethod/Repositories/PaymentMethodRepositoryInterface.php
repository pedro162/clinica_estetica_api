<?php

namespace App\Domain\PaymentMethod\Repositories;

use App\FormaPagamento;
use App\Domain\PaymentMethod\Entities\PaymentMethod;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodId;

interface PaymentMethodRepositoryInterface
{
    public function save(PaymentMethod $task): ?FormaPagamento;
    public function findById(PaymentMethodId $id): ?FormaPagamento;
    public function getAll(array $filter = []): ?array;
    public function update(PaymentMethod $parameter): void;
    public function destroy(PaymentMethod $parameter): void;
}
