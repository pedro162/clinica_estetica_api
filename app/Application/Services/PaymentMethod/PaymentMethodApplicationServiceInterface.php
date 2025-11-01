<?php

namespace App\Application\Services\PaymentMethod;

use App\Application\Commands\PaymentMethod\CreatePaymentMethodCommand;
use App\FormaPagamento;
use App\Domain\PaymentMethod\Entities\PaymentMethod;
use Illuminate\Support\Collection;

interface PaymentMethodApplicationServiceInterface
{
    public function store(
        CreatePaymentMethodCommand $command
    ): ?FormaPagamento;

    public function findById(
        CreatePaymentMethodCommand $command
    ): ?FormaPagamento;

    public function update(
        CreatePaymentMethodCommand $command
    ): void;

    public function destroy(
        CreatePaymentMethodCommand $command
    ): void;

    public function getAll(array $data = []): ?Collection;

    public function syncFinancialOperators(
        CreatePaymentMethodCommand $command
    ): void;

    public function syncPaymentPlans(
        CreatePaymentMethodCommand $command
    ): void;
}
