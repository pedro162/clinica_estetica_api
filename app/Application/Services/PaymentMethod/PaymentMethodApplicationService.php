<?php

namespace App\Application\Services\PaymentMethod;

use App\Application\Commands\PaymentMethod\CreatePaymentMethodCommand;
use App\Application\Handlers\PaymentMethod\CreatePaymentMethodHandler;
use App\Application\Handlers\PaymentMethod\DestroyPaymentMethodHandler;
use App\Application\Handlers\PaymentMethod\GetAllPaymentMethodHandler;
use App\Application\Handlers\PaymentMethod\GetPaymentMethodByIdHandler;
use App\Application\Handlers\PaymentMethod\UpdatePaymentMethodHandler;
use App\FormaPagamento;
use App\Domain\PaymentMethod\Entities\PaymentMethod;
use Illuminate\Support\Collection;

class PaymentMethodApplicationService implements PaymentMethodApplicationServiceInterface
{
    private CreatePaymentMethodHandler $createPaymentMethodHandler;
    protected GetAllPaymentMethodHandler $getAllPaymentMethodHandler;
    protected UpdatePaymentMethodHandler $updatePaymentMethodHandler;
    protected DestroyPaymentMethodHandler $destroyPaymentMethodHandler;
    protected GetPaymentMethodByIdHandler $getPaymentMethodByIdHandler;

    public function __construct(
        CreatePaymentMethodHandler $createPaymentMethodHandler,
        GetAllPaymentMethodHandler $getAllPaymentMethodHandler,
        UpdatePaymentMethodHandler $updatePaymentMethodHandler,
        GetPaymentMethodByIdHandler $getPaymentMethodByIdHandler,
        DestroyPaymentMethodHandler $destroyPaymentMethodHandler
    ) {
        $this->createPaymentMethodHandler = $createPaymentMethodHandler;
        $this->getAllPaymentMethodHandler = $getAllPaymentMethodHandler;
        $this->updatePaymentMethodHandler = $updatePaymentMethodHandler;
        $this->destroyPaymentMethodHandler = $destroyPaymentMethodHandler;
        $this->getPaymentMethodByIdHandler = $getPaymentMethodByIdHandler;
    }

    public function store(
        CreatePaymentMethodCommand $command
    ): ?FormaPagamento {
        return $this->createPaymentMethodHandler->handler($command);
    }

    public function update(
        CreatePaymentMethodCommand $command
    ): void {

        $this->updatePaymentMethodHandler->handler($command);
    }

    public function destroy(
        CreatePaymentMethodCommand $command
    ): void {

        $this->destroyPaymentMethodHandler->handler($command);
    }

    public function getAll(array $data = []): ?Collection
    {
        return $this->getAllPaymentMethodHandler->handler($data);
    }

    public function findById(
        CreatePaymentMethodCommand $command
    ): ?FormaPagamento {

        return $this->getPaymentMethodByIdHandler->handler($command);
    }

    public function syncFinancialOperators(
        CreatePaymentMethodCommand $command
    ): void {

        $this->updatePaymentMethodHandler->syncFinancialOperators($command);
    }

    public function syncPaymentPlans(
        CreatePaymentMethodCommand $command
    ): void {

        $this->updatePaymentMethodHandler->syncPaymentPlans($command);
    }
}
