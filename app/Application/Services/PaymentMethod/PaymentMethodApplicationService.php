<?php

namespace App\Application\Services\PaymentMethod;

use App\Application\Commands\PaymentMethod\CreatePaymentMethodCommand;
use App\Application\Handlers\PaymentMethod\CreatePaymentMethodHandler;
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
    protected GetPaymentMethodByIdHandler $getPaymentMethodByIdHandler;

    public function __construct(
        CreatePaymentMethodHandler $createPaymentMethodHandler,
        GetAllPaymentMethodHandler $getAllPaymentMethodHandler,
        UpdatePaymentMethodHandler $updatePaymentMethodHandler,
        GetPaymentMethodByIdHandler $getPaymentMethodByIdHandler
    ) {
        $this->createPaymentMethodHandler = $createPaymentMethodHandler;
        $this->getAllPaymentMethodHandler = $getAllPaymentMethodHandler;
        $this->updatePaymentMethodHandler = $updatePaymentMethodHandler;
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

    public function getAll(array $data = []): ?Collection
    {
        return $this->getAllPaymentMethodHandler->handler($data);
    }

    public function findById(
        CreatePaymentMethodCommand $command
    ): ?FormaPagamento {

        return $this->getPaymentMethodByIdHandler->handler($command);
    }
}
