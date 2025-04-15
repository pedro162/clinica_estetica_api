<?php

namespace App\Application\Commands\PaymentMethod;

use App\Utilitarios;
use Exception;

class CreatePaymentMethodCommand
{
    protected string $id;
    protected string $name;
    protected string $type;
    protected string $userId;
    protected string $userUpdateId;
    protected string $tenantId;
    protected string $active;
    protected string $branchId;
    protected string $billingCode;
    protected string $hasCommission;
    protected string $paymentType;
    protected string $hasInstallments;
    protected string $hasCreditLimit;
    protected string $hasCounterAdjustment;
    protected string $hasCashAdjustment;
    protected string $hasDownPayment;
    protected string $hasFinancialOperator;

    public function id(string $id): CreatePaymentMethodCommand
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id ?? null;
    }

    public function tenantId(string $tenantId): CreatePaymentMethodCommand
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function getTenantId(): ?string
    {
        return $this->tenantId ?? null;
    }

    public function name(string $name): CreatePaymentMethodCommand
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    public function type(string $type): CreatePaymentMethodCommand
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type ?? null;
    }

    public function userId(string $userId): CreatePaymentMethodCommand
    {
        $this->userId = $userId;
        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->userId ?? null;
    }

    public function userUpdateId(string $userUpdateId): CreatePaymentMethodCommand
    {
        $this->userUpdateId = $userUpdateId;
        return $this;
    }

    public function getUserUpdateId(): ?string
    {
        return $this->userUpdateId ?? null;
    }

    public function active(string $active): CreatePaymentMethodCommand
    {
        $this->active = $active;
        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active ?? null;
    }

    public function billingCode(string $billingCode): CreatePaymentMethodCommand
    {
        $this->billingCode = $billingCode;
        return $this;
    }

    public function getBillingCode(): ?string
    {
        return $this->billingCode ?? null;
    }

    public function hasCommission(string $hasCommission): CreatePaymentMethodCommand
    {
        $this->hasCommission = $hasCommission;
        return $this;
    }

    public function getHasCommission(): ?string
    {
        return $this->hasCommission ?? null;
    }

    public function paymentType(string $paymentType): CreatePaymentMethodCommand
    {
        $this->paymentType = $paymentType;
        return $this;
    }

    public function getPaymentType(): ?string
    {
        return $this->paymentType ?? null;
    }

    public function hasInstallments(string $hasInstallments): CreatePaymentMethodCommand
    {
        $this->hasInstallments = $hasInstallments;
        return $this;
    }

    public function getHasInstallments(): ?string
    {
        return $this->hasInstallments ?? null;
    }

    public function hasCreditLimit(string $hasCreditLimit): CreatePaymentMethodCommand
    {
        $this->hasCreditLimit = $hasCreditLimit;
        return $this;
    }

    public function getHasCreditLimit(): ?string
    {
        return $this->hasCreditLimit ?? null;
    }

    public function hasCounterAdjustment(string $hasCounterAdjustment): CreatePaymentMethodCommand
    {
        $this->hasCounterAdjustment = $hasCounterAdjustment;
        return $this;
    }

    public function getHasCounterAdjustment(): ?string
    {
        return $this->hasCounterAdjustment ?? null;
    }

    public function hasCashAdjustment(string $hasCashAdjustment): CreatePaymentMethodCommand
    {
        $this->hasCashAdjustment = $hasCashAdjustment;
        return $this;
    }

    public function getHasCashAdjustment(): ?string
    {
        return $this->hasCashAdjustment ?? null;
    }

    public function hasDownPayment(string $hasDownPayment): CreatePaymentMethodCommand
    {
        $this->hasDownPayment = $hasDownPayment;
        return $this;
    }

    public function getHasDownPayment(): ?string
    {
        return $this->hasDownPayment ?? null;
    }

    public function hasFinancialOperator(string $hasFinancialOperator): CreatePaymentMethodCommand
    {
        $this->hasFinancialOperator = $hasFinancialOperator;
        return $this;
    }

    public function getHasFinancialOperator(): ?string
    {
        return $this->hasFinancialOperator ?? null;
    }

    public static function build(array $data): CreatePaymentMethodCommand
    {
        $entity = (new self)
            ->id((string)($data['id'] ?? 0))
            ->name((string)($data['name'] ?? ''))
            ->type((string)($data['type'] ?? ''))
            ->tenantId((string)($data['tenantId'] ?? $data['tenant_id'] ?? ''))
            ->userId((string)($data['userId'] ?? $data['user_id'] ?? ''))
            ->userUpdateId((string)($data['userUpdateId'] ?? $data['user_update_id'] ?? ''))
            ->active((string)($data['active'] ?? 'yes'))
            ->billingCode((string)($data['billingCode'] ?? ''))
            ->hasCommission((string)($data['hasCommission'] ?? 'no'))
            ->paymentType((string)($data['paymentType'] ?? 'cash'))
            ->hasInstallments((string)($data['hasInstallments'] ?? 'yes'))
            ->hasCreditLimit((string)($data['hasCreditLimit'] ?? 'no'))
            ->hasCounterAdjustment((string)($data['hasCounterAdjustment'] ?? 'no'))
            ->hasCashAdjustment((string)($data['hasCashAdjustment'] ?? 'no'))
            ->hasDownPayment((string)($data['hasDownPayment'] ?? 'no'))
            ->hasFinancialOperator((string)($data['hasFinancialOperator'] ?? 'no'));

        return $entity;
    }

    public function getDataProperties(): array
    {
        $data = [
            'id' => $this->id ?? '',
            'name' => $this->name ?? '',
            'type' => $this->type ?? '',
            'tenantId' => $this->tenantId ?? '',
            'userId' => $this->userId ?? '',
            'userUpdateId' => $this->userUpdateId ?? '',
            'active' => $this->active ?? '',
            'branchId' => $this->branchId ?? '',
            'billingCode' => $this->billingCode ?? '',
            'hasCommission' => $this->hasCommission ?? '',
            'paymentType' => $this->paymentType ?? '',
            'hasInstallments' => $this->hasInstallments ?? '',
            'hasCreditLimit' => $this->hasCreditLimit ?? '',
            'hasCounterAdjustment' => $this->hasCounterAdjustment ?? '',
            'hasCashAdjustment' => $this->hasCashAdjustment ?? '',
            'hasDownPayment' => $this->hasDownPayment ?? '',
            'hasFinancialOperator' => $this->hasFinancialOperator ?? '',
        ];

        return array_filter($data, fn($value) => $value !== null && !empty($value));
    }
}
