<?php

namespace App\Domain\PaymentPlan\Entities;

use App\Domain\BaseEntity\Entities\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\PaymentPlan\ValueObjects\PaymentPlanAverageDays;
use App\Domain\PaymentPlan\ValueObjects\PaymentPlanBranchId;
use App\Domain\PaymentPlan\ValueObjects\PaymentPlanDescription;
use App\Domain\PaymentPlan\ValueObjects\PaymentPlanFirstInstallmentDays;
use App\Domain\PaymentPlan\ValueObjects\PaymentPlanGenerateInvoiceManually;
use App\Domain\PaymentPlan\ValueObjects\PaymentPlanId;
use App\Domain\PaymentPlan\ValueObjects\PaymentPlanInstallmentIntervalDays;
use App\Domain\PaymentPlan\ValueObjects\PaymentPlanInstallmentQuantity;
use App\Domain\PaymentPlan\ValueObjects\PaymentPlanIsActive;
use App\Domain\PaymentPlan\ValueObjects\PaymentPlanIsOpen;
use App\Domain\PaymentPlan\ValueObjects\PaymentPlanManualInvoiceSplit;
use App\Domain\PaymentPlan\ValueObjects\PaymentPlanMinInstallments;
use App\Domain\PaymentPlan\ValueObjects\PaymentPlanName;
use App\Domain\PaymentPlan\ValueObjects\PaymentPlanShowAtCounter;
use App\PlanoPagamento;

class PaymentPlan extends BaseEntity
{
    protected PaymentPlanId $id;
    protected PaymentPlanName $name;
    protected PaymentPlanDescription $description;
    protected PaymentPlanAverageDays $averageDays;
    protected PaymentPlanInstallmentQuantity $installmentQuantity;
    protected PaymentPlanManualInvoiceSplit $manualInvoiceSplit;
    protected PaymentPlanGenerateInvoiceManually $generateInvoiceManually;
    protected PaymentPlanIsActive $isActive;
    protected PaymentPlanIsOpen $isOpen;
    protected PaymentPlanMinInstallments $minInstallments;
    protected PaymentPlanFirstInstallmentDays $firstInstallmentDays;
    protected PaymentPlanInstallmentIntervalDays $installmentIntervalDays;
    protected PaymentPlanShowAtCounter $showAtCounter;
    protected PaymentPlanBranchId $branchId;

    public function id(PaymentPlanId $id): PaymentPlan
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?PaymentPlanId
    {
        return $this->id ?? null;
    }

    public function branchId(PaymentPlanBranchId $branchId): PaymentPlan
    {
        $this->branchId = $branchId;
        return $this;
    }

    public function getBranchId(): ?PaymentPlanBranchId
    {
        return $this->branchId ?? null;
    }

    public function name(PaymentPlanName $name): PaymentPlan
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?PaymentPlanName
    {
        return $this->name ?? null;
    }

    public function description(PaymentPlanDescription $description): PaymentPlan
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): ?PaymentPlanDescription
    {
        return $this->description ?? null;
    }

    public function averageDays(PaymentPlanAverageDays $averageDays): PaymentPlan
    {
        $this->averageDays = $averageDays;
        return $this;
    }

    public function getAverageDays(): ?PaymentPlanAverageDays
    {
        return $this->averageDays ?? null;
    }

    public function installmentQuantity(PaymentPlanInstallmentQuantity $installmentQuantity): PaymentPlan
    {
        $this->installmentQuantity = $installmentQuantity;
        return $this;
    }

    public function getInstallmentQuantity(): ?PaymentPlanInstallmentQuantity
    {
        return $this->installmentQuantity ?? null;
    }

    public function manualInvoiceSplit(PaymentPlanManualInvoiceSplit $manualInvoiceSplit): PaymentPlan
    {
        $this->manualInvoiceSplit = $manualInvoiceSplit;
        return $this;
    }

    public function getManualInvoiceSplit(): ?PaymentPlanManualInvoiceSplit
    {
        return $this->manualInvoiceSplit ?? null;
    }

    public function generateInvoiceManually(PaymentPlanGenerateInvoiceManually $generateInvoiceManually): PaymentPlan
    {
        $this->generateInvoiceManually = $generateInvoiceManually;
        return $this;
    }

    public function getGenerateInvoiceManually(): ?PaymentPlanGenerateInvoiceManually
    {
        return $this->generateInvoiceManually ?? null;
    }

    public function isActive(PaymentPlanIsActive $isActive): PaymentPlan
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getIsActive(): ?PaymentPlanIsActive
    {
        return $this->isActive ?? null;
    }

    public function isOpen(PaymentPlanIsOpen $isOpen): PaymentPlan
    {
        $this->isOpen = $isOpen;
        return $this;
    }

    public function getIsOpen(): ?PaymentPlanIsOpen
    {
        return $this->isOpen ?? null;
    }

    public function minInstallments(PaymentPlanMinInstallments $minInstallments): PaymentPlan
    {
        $this->minInstallments = $minInstallments;
        return $this;
    }

    public function getMinInstallments(): ?PaymentPlanMinInstallments
    {
        return $this->minInstallments ?? null;
    }

    public function firstInstallmentDays(PaymentPlanFirstInstallmentDays $firstInstallmentDays): PaymentPlan
    {
        $this->firstInstallmentDays = $firstInstallmentDays;
        return $this;
    }

    public function getFirstInstallmentDays(): ?PaymentPlanFirstInstallmentDays
    {
        return $this->firstInstallmentDays ?? null;
    }

    public function installmentIntervalDays(PaymentPlanInstallmentIntervalDays $installmentIntervalDays): PaymentPlan
    {
        $this->installmentIntervalDays = $installmentIntervalDays;
        return $this;
    }

    public function getInstallmentIntervalDays(): ?PaymentPlanInstallmentIntervalDays
    {
        return $this->installmentIntervalDays ?? null;
    }

    public function showAtCounter(PaymentPlanShowAtCounter $showAtCounter): PaymentPlan
    {
        $this->showAtCounter = $showAtCounter;
        return $this;
    }

    public function getShowAtCounter(): ?PaymentPlanShowAtCounter
    {
        return $this->showAtCounter ?? null;
    }

    public static function buildEntity(array $data): PaymentPlan
    {
        $entity = (new self());
        $mapping = [
            ['keys' => ['id'], 'callback' => fn ($value) => $entity->id(new PaymentPlanId($value))],
            ['keys' => ['name'], 'callback' => fn ($value) => $entity->name(new PaymentPlanName((string)$value))],
            ['keys' => ['descricao', 'description'], 'callback' => fn ($value) => $entity->description(new PaymentPlanDescription((string)$value))],
            ['keys' => ['diasmedios', 'averageDays'], 'callback' => fn ($value) => $entity->averageDays(new PaymentPlanAverageDays((string)$value))],
            ['keys' => ['qtdParcelas', 'installmentQuantity'], 'callback' => fn ($value) => $entity->installmentQuantity(new PaymentPlanInstallmentQuantity((string)$value))],
            ['keys' => ['desdobrarDuplicataManual', 'manualInvoiceSplit'], 'callback' => fn ($value) => $entity->manualInvoiceSplit(new PaymentPlanManualInvoiceSplit((string)$value))],
            ['keys' => ['gerarDuplicataManual', 'generateInvoiceManually'], 'callback' => fn ($value) => $entity->generateInvoiceManually(new PaymentPlanGenerateInvoiceManually((string)$value))],
            ['keys' => ['isAtiva', 'isActive'], 'callback' => fn ($value) => $entity->isActive(new PaymentPlanIsActive((string)$value))],
            ['keys' => ['isAberto', 'isOpen'], 'callback' => fn ($value) => $entity->isOpen(new PaymentPlanIsOpen((string)$value))],
            ['keys' => ['qtdMinParcelas', 'minInstallments'], 'callback' => fn ($value) => $entity->minInstallments(new PaymentPlanMinInstallments((string)$value))],
            ['keys' => ['qtd_dias_pri_parcela', 'firstInstallmentDays'], 'callback' => fn ($value) => $entity->firstInstallmentDays(new PaymentPlanFirstInstallmentDays((string)$value))],
            ['keys' => ['qtdDiasIntervaloParcelas', 'installmentIntervalDays'], 'callback' => fn ($value) => $entity->installmentIntervalDays(new PaymentPlanInstallmentIntervalDays((string)$value))],
            ['keys' => ['exibe_balcao', 'showAtCounter'], 'callback' => fn ($value) => $entity->showAtCounter(new PaymentPlanShowAtCounter((string)$value))],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn ($value) => $entity->tenantId(new BaseEntityTenantId((string)$value))],
            ['keys' => ['active'], 'callback' => fn ($value) => $entity->active((string)$value)],
            ['keys' => ['userId', 'user_id'], 'callback' => fn ($value) => $entity->userId(new BaseEntityUserId((string)$value))],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn ($value) => $entity->userUpdateId(new BaseEntityUserId((string)$value))],
            ['keys' => ['branchId', 'filial_id'], 'callback' => fn ($value) => $entity->branchId(new PaymentPlanBranchId((string)$value))],
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

    public function build(): PlanoPagamento
    {
        $data = [
            'id' => isset($this->id) ? (string)$this->id : null,
            'filial_id' => isset($this->branchId) ? (string)$this->branchId : null,
            'name' => isset($this->name) ? (string)$this->name : null,
            'descricao' => isset($this->description) ? (string)$this->description : null,
            'diasmedios' => isset($this->averageDays) ? (string)$this->averageDays : null,
            'qtdParcelas' => isset($this->installmentQuantity) ? (string)$this->installmentQuantity : null,
            'desdobrarDuplicataManual' => isset($this->manualInvoiceSplit) ? (string)$this->manualInvoiceSplit : null,
            'gerarDuplicataManual' => isset($this->generateInvoiceManually) ? (string)$this->generateInvoiceManually : null,
            'isAtiva' => isset($this->isActive) ? (string)$this->isActive : null,
            'isAberto' => isset($this->isOpen) ? (string)$this->isOpen : null,
            'qtdMinParcelas' => isset($this->minInstallments) ? (string)$this->minInstallments : null,
            'qtd_dias_pri_parcela' => isset($this->firstInstallmentDays) ? (string)$this->firstInstallmentDays : null,
            'qtdDiasIntervaloParcelas' => isset($this->installmentIntervalDays) ? (string)$this->installmentIntervalDays : null,
            'exibe_balcao' => isset($this->showAtCounter) ? (string)$this->showAtCounter : null,
            'tenant_id' => isset($this->tenantId) ? (string)$this->tenantId : null,
            'active' => isset($this->active) ? (string)$this->active : null,
            'user_id' => isset($this->userId) ? (string)$this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string)$this->userUpdateId : null,
        ];

        $data = array_filter($data, function ($value) {
            return $value !== null;
        });

        return new PlanoPagamento($data);
    }
}
