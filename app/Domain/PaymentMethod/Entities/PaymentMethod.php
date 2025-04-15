<?php

namespace App\Domain\PaymentMethod\Entities;

use App\FormaPagamento;
use App\Domain\BaseEntity\Entities\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodBalance;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodBillingCode;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodBranchId;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodHasCashAdjustment;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodHasCommission;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodHasCounterAdjustment;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodHasCreditLimit;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodHasDownPayment;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodHasFinancialOperator;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodId;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodName;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodPaymentType;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodType;

class PaymentMethod extends BaseEntity
{
    protected PaymentMethodId $id;
    protected PaymentMethodName $name;
    protected PaymentMethodType $type;
    protected PaymentMethodBillingCode $billingCode;
    protected PaymentMethodPaymentType $paymentType;
    protected PaymentMethodHasCommission $hasCommission;
    protected PaymentMethodHasCreditLimit $hasCreditLimit;
    protected PaymentMethodHasCounterAdjustment $hasCounterAdjustment;
    protected PaymentMethodHasCashAdjustment $hasCashAdjustment;
    protected PaymentMethodHasDownPayment $hasDownPayment;
    protected PaymentMethodHasFinancialOperator $hasFinancialOperator;
    protected PaymentMethodBranchId $branchId;

    public function id(PaymentMethodId $id): PaymentMethod
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?PaymentMethodId
    {
        return $this->id ?? null;
    }

    public function branchId(PaymentMethodBranchId $branchId): PaymentMethod
    {
        $this->branchId = $branchId;
        return $this;
    }

    public function getBranchId(): ?PaymentMethodBranchId
    {
        return $this->branchId ?? null;
    }

    public function name(PaymentMethodName $name): PaymentMethod
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?PaymentMethodName
    {
        return $this->name ?? null;
    }

    public function type(PaymentMethodType $type): PaymentMethod
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): ?PaymentMethodType
    {
        return $this->type ?? null;
    }

    public static function buildEntity(array $data): PaymentMethod
    {
        $tenantId = $data['tenant_id'] ?? $data['tenantId'] ?? 0;
        $tenantId = (string) (!empty($tenantId) ? $tenantId : 0);

        $userId = $data['user_id'] ?? $data['userId'] ?? 0;
        $userId = (string) (!empty($userId) ? $userId : 0);

        $userUpdateId = $data['user_update_id'] ?? $data['userUpdateId'] ?? 0;
        $userUpdateId = (string) (!empty($userUpdateId) ? $userUpdateId : 0);

        $stateId = $data['state_id'] ?? $data['stateId'] ?? 0;
        $stateId = (string) (!empty($stateId) ? $stateId : 0);

        $id = $data['city_id'] ?? $data['id'] ?? 0;
        $id = (string) (!empty($id) ? $id : 0);

        $type = $data['type'] ?? '';

        $branchId = (string) ($data['branchId'] ?? $data['filial_id'] ?? 0);
        $paymentType = (string) ($data['paymentType'] ?? $data['tpPagamento'] ?? '');
        $billingCode = (string) ($data['billingCode'] ?? $data['cdCobrancaTipo'] ?? '');
        $hasCommission = (string) ($data['hasCommission'] ?? $data['hasComissao'] ?? '');
        $hasCreditLimit = (string) ($data['hasCreditLimit'] ?? $data['hasLimiteDeCredito'] ?? '');
        $hasCounterAdjustment = (string) ($data['hasCounterAdjustment'] ?? $data['hasAcertoBalcao'] ?? '');
        $hasCashAdjustment = (string) ($data['hasCashAdjustment'] ?? $data['hasAcertoCaixa'] ?? '');
        $hasDownPayment = (string) ($data['hasDownPayment'] ?? $data['hasEntrada'] ?? '');
        $hasFinancialOperator = (string) ($data['hasFinancialOperator'] ?? $data['hasOperadorFinanceiro'] ?? '');

        $entity = (new self())
            ->id(new PaymentMethodId($id))
            ->name(new PaymentMethodName((string)($data['nmCidade'] ?? $data['name'] ?? '')))
            ->tenantId(new BaseEntityTenantId($tenantId))
            ->active(((string)($data['active'] ?? '')))
            ->userId(new BaseEntityUserId($userId))
            ->userUpdateId(new BaseEntityUserId($userUpdateId))
            ->type(new PaymentMethodType((string)$type))
            ->branchId(new PaymentMethodBranchId($branchId))
            ->paymentType(new PaymentMethodBranchId($paymentType))
            ->billingCode(new PaymentMethodBranchId($billingCode))
            ->hasCommission(new PaymentMethodBranchId($hasCommission))
            ->hasCreditLimit(new PaymentMethodBranchId($hasCreditLimit))
            ->hasCounterAdjustment(new PaymentMethodBranchId($hasCounterAdjustment))
            ->hasCashAdjustment(new PaymentMethodBranchId($hasCashAdjustment))
            ->hasDownPayment(new PaymentMethodBranchId($hasDownPayment))
            ->hasFinancialOperator(new PaymentMethodBranchId($hasFinancialOperator));

        return $entity;
    }

    public function build(): FormaPagamento
    {
        $data = [
            'id' => isset($this->id) ? (string)$this->id : null,
            'filial_id' => isset($this->branchId) ? (string)$this->branchId : null,
            'name' => isset($this->name) ? (string)$this->name : null,
            'tipo' => isset($this->type) ? (string)$this->type : null,
            'cdCobrancaTipo' => isset($this->billingCode) ? (string)$this->billingCode : null,
            'tpPagamento' => isset($this->paymentType) ? (string)$this->paymentType : null,
            'hasComissao' => isset($this->hasCommission) ? (string)$this->hasCommission : null,
            'hasLimiteDeCredito' => isset($this->hasCreditLimit) ? (string)$this->hasCreditLimit : null,
            'hasAcertoBalcao' => isset($this->hasCounterAdjustment) ? (string)$this->hasCounterAdjustment : null,
            'hasAcertoCaixa' => isset($this->hasCashAdjustment) ? (string)$this->hasCashAdjustment : null,
            'hasEntrada' => isset($this->hasDownPayment) ? (string)$this->hasDownPayment : null,
            'hasOperadorFinanceiro' => isset($this->hasFinancialOperator) ? (string)$this->hasFinancialOperator : null,
            'tenant_id' => isset($this->tenantId) ? (string)$this->tenantId : null,
            'active' => isset($this->active) ? (string)$this->active : null,
            'user_id' => isset($this->userId) ? (string)$this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string)$this->userUpdateId : null,
        ];

        $data = array_filter($data, function ($value) {
            return $value !== null;
        });

        return new FormaPagamento($data);
    }
}
