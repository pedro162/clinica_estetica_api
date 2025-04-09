<?php

namespace App\Application\Services\PaymentMethod;

use App\Application\Commands\PaymentMethod\CreatePaymentMethodCommand;
use App\Cidade;
use App\Domain\PaymentMethod\Entities\PaymentMethod;
use Illuminate\Support\Collection;

interface PaymentMethodApplicationServiceInterface
{
    public function store(
        CreatePaymentMethodCommand $command
    ): ?Cidade;

    public function findById(
        CreatePaymentMethodCommand $command
    ): ?Cidade;

    public function update(
        CreatePaymentMethodCommand $command
    ): void;

    public function getAll(array $data = []): ?Collection;
}
