<?php

namespace App\Domain\PaymentMethod\Entities;

use App\FormaPagamento;
use App\Domain\BaseEntity\Entities\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\FinancialOperator\Entities\FinancialOperator;
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
use App\Domain\PaymentPlan\Entities\PaymentPlan;

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

    /**
     * Financial Operators associated with the Payment Method
     *
     * @var array<FinancialOperator>
     */
    protected array $financialOperators;

    /**
     * Payment Plans associated with the Payment Method
     *
     * @var array<PaymentPlan>
     */
    protected array $paymentPlans;

    public function id(PaymentMethodId $id): PaymentMethod
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?PaymentMethodId
    {
        return $this->id ?? null;
    }

    public function billingCode(PaymentMethodBillingCode $billingCode): PaymentMethod
    {
        $this->billingCode = $billingCode;
        return $this;
    }

    public function getBillingCode(): ?PaymentMethodBillingCode
    {
        return $this->billingCode ?? null;
    }

    public function paymentType(PaymentMethodPaymentType $paymentType): PaymentMethod
    {
        $this->paymentType = $paymentType;
        return $this;
    }

    public function getPaymentType(): ?PaymentMethodPaymentType
    {
        return $this->paymentType ?? null;
    }

    public function hasCommission(PaymentMethodHasCommission $hasCommission): PaymentMethod
    {
        $this->hasCommission = $hasCommission;
        return $this;
    }

    public function getHasCommission(): ?PaymentMethodHasCommission
    {
        return $this->hasCommission ?? null;
    }

    public function hasCreditLimit(PaymentMethodHasCreditLimit $hasCreditLimit): PaymentMethod
    {
        $this->hasCreditLimit = $hasCreditLimit;
        return $this;
    }

    public function getHasCreditLimit(): ?PaymentMethodHasCreditLimit
    {
        return $this->hasCreditLimit ?? null;
    }

    public function hasCounterAdjustment(PaymentMethodHasCounterAdjustment $hasCounterAdjustment): PaymentMethod
    {
        $this->hasCounterAdjustment = $hasCounterAdjustment;
        return $this;
    }

    public function getHasCounterAdjustment(): ?PaymentMethodHasCounterAdjustment
    {
        return $this->hasCounterAdjustment ?? null;
    }

    public function hasCashAdjustment(PaymentMethodHasCashAdjustment $hasCashAdjustment): PaymentMethod
    {
        $this->hasCashAdjustment = $hasCashAdjustment;
        return $this;
    }

    public function getHasCashAdjustment(): ?PaymentMethodHasCashAdjustment
    {
        return $this->hasCashAdjustment ?? null;
    }

    public function hasDownPayment(PaymentMethodHasDownPayment $hasDownPayment): PaymentMethod
    {
        $this->hasDownPayment = $hasDownPayment;
        return $this;
    }

    public function getHasDownPayment(): ?PaymentMethodHasDownPayment
    {
        return $this->hasDownPayment ?? null;
    }

    public function hasFinancialOperator(PaymentMethodHasFinancialOperator $hasFinancialOperator): PaymentMethod
    {
        $this->hasFinancialOperator = $hasFinancialOperator;
        return $this;
    }

    public function getHasFinancialOperator(): ?PaymentMethodHasFinancialOperator
    {
        return $this->hasFinancialOperator ?? null;
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

    public function addPaymentPlan(PaymentPlan $paymentPlan): PaymentMethod
    {
        $this->paymentPlans[] = $paymentPlan;
        return $this;
    }

    public function getPaymentPlans(): ?array
    {
        return $this->paymentPlans ?? null;
    }

    public function addFinancialOperator(FinancialOperator $financialOperator): PaymentMethod
    {
        $this->financialOperators[] = $financialOperator;
        return $this;
    }

    public function getFinancialOperators(): ?array
    {
        return $this->financialOperators ?? null;
    }

    public static function buildEntity(array $data): PaymentMethod
    {
        $entity = (new self());
        $mapping = [
            ['keys' => ['id'], 'callback' => fn($value) => $entity->id(new PaymentMethodId($value))],
            ['keys' => ['name'], 'callback' => fn($value) => $entity->name(new PaymentMethodName((string)$value))],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn($value) => $entity->tenantId(new BaseEntityTenantId((string)$value))],
            ['keys' => ['active'], 'callback' => fn($value) => $entity->active((string)$value)],
            ['keys' => ['userId', 'user_id'], 'callback' => fn($value) => $entity->userId(new BaseEntityUserId((string)$value))],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn($value) => $entity->userUpdateId(new BaseEntityUserId((string)$value))],
            ['keys' => ['type', 'tipo'], 'callback' => fn($value) => $entity->type(new PaymentMethodType((string)$value))],
            ['keys' => ['branchId', 'filial_id'], 'callback' => fn($value) => $entity->branchId(new PaymentMethodBranchId((string)$value))],
            ['keys' => ['paymentType', 'tpPagamento'], 'callback' => fn($value) => $entity->paymentType(new PaymentMethodPaymentType((string)$value))],
            ['keys' => ['billingCode', 'cdCobrancaTipo'], 'callback' => fn($value) => $entity->billingCode(new PaymentMethodBillingCode((string)$value))],
            ['keys' => ['hasCommission', 'hasComissao'], 'callback' => fn($value) => $entity->hasCommission(new PaymentMethodHasCommission((string)$value))],
            ['keys' => ['hasCreditLimit', 'hasLimiteDeCredito'], 'callback' => fn($value) => $entity->hasCreditLimit(new PaymentMethodHasCreditLimit((string)$value))],
            ['keys' => ['hasCounterAdjustment', 'hasAcertoBalcao'], 'callback' => fn($value) => $entity->hasCounterAdjustment(new PaymentMethodHasCounterAdjustment((string)$value))],
            ['keys' => ['hasCashAdjustment', 'hasAcertoCaixa'], 'callback' => fn($value) => $entity->hasCashAdjustment(new PaymentMethodHasCashAdjustment((string)$value))],
            ['keys' => ['hasDownPayment', 'hasEntrada'], 'callback' => fn($value) => $entity->hasDownPayment(new PaymentMethodHasDownPayment((string)$value))],
            ['keys' => ['hasFinancialOperator', 'hasOperadorFinanceiro'], 'callback' => fn($value) => $entity->hasFinancialOperator(new PaymentMethodHasFinancialOperator((string)$value))],
        ];

        foreach ($mapping as $map) {
            foreach ($map['keys'] as $key) {
                if (isset($data[$key])) {
                    $map['callback']($data[$key]);
                    break;
                }
            }
        }

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
