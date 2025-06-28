<?php

namespace App\Application\Services\PaymentPlan;

use App\Application\Commands\PaymentPlan\CreatePaymentPlanCommand;
use App\Application\Handlers\PaymentPlan\CreatePaymentPlanHandler;
use App\Application\Handlers\PaymentPlan\DestroyPaymentPlanHandler;
use App\Application\Handlers\PaymentPlan\GetAllPaymentPlanHandler;
use App\Application\Handlers\PaymentPlan\GetPaymentPlanByIdHandler;
use App\Application\Handlers\PaymentPlan\UpdatePaymentPlanHandler;
use App\PlanoPagamento;
use App\Domain\PaymentPlan\Entities\PaymentPlan;
use Illuminate\Support\Collection;

class PaymentPlanApplicationService implements PaymentPlanApplicationServiceInterface
{
    private CreatePaymentPlanHandler $createPaymentPlanHandler;
    protected GetAllPaymentPlanHandler $getAllPaymentPlanHandler;
    protected UpdatePaymentPlanHandler $updatePaymentPlanHandler;
    protected DestroyPaymentPlanHandler $destroyPaymentPlanHandler;
    protected GetPaymentPlanByIdHandler $getPaymentPlanByIdHandler;

    public function __construct(
        CreatePaymentPlanHandler $createPaymentPlanHandler,
        GetAllPaymentPlanHandler $getAllPaymentPlanHandler,
        UpdatePaymentPlanHandler $updatePaymentPlanHandler,
        GetPaymentPlanByIdHandler $getPaymentPlanByIdHandler,
        DestroyPaymentPlanHandler $destroyPaymentPlanHandler
    ) {
        $this->createPaymentPlanHandler = $createPaymentPlanHandler;
        $this->getAllPaymentPlanHandler = $getAllPaymentPlanHandler;
        $this->updatePaymentPlanHandler = $updatePaymentPlanHandler;
        $this->destroyPaymentPlanHandler = $destroyPaymentPlanHandler;
        $this->getPaymentPlanByIdHandler = $getPaymentPlanByIdHandler;
    }

    public function store(
        CreatePaymentPlanCommand $command
    ): ?PlanoPagamento {
        return $this->createPaymentPlanHandler->handler($command);
    }

    public function update(
        CreatePaymentPlanCommand $command
    ): void {

        $this->updatePaymentPlanHandler->handler($command);
    }

    public function destroy(
        CreatePaymentPlanCommand $command
    ): void {

        $this->destroyPaymentPlanHandler->handler($command);
    }

    public function getAll(array $data = []): ?Collection
    {
        return $this->getAllPaymentPlanHandler->handler($data);
    }

    public function findById(
        CreatePaymentPlanCommand $command
    ): ?PlanoPagamento {

        return $this->getPaymentPlanByIdHandler->handler($command);
    }
}
