<?php

namespace App\Domain\AccountReceivable\Entities;

use App\ContaReceber;
use App\Domain\BaseEntity\Entities\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableStatus;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableBranchId;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableClearanceDate;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableClearancePersonId;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableClearanceType;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableId;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableDescription;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableDiscountValue;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableDocument;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableDueDate;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableFeeValue;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableFinancialOperatorId;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableGrossValue;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableInterestValue;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableIsImportedData;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableNetValue;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableOriginalDueDate;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivablePaidValue;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivablePaymentDate;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivablePaymentMethodId;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivablePaymentPlanId;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivablePersonId;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableReceivableAccountId;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableResponsibleId;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableReturnedValue;

class AccountReceivable extends BaseEntity
{
    protected AccountReceivableId $id;
    protected AccountReceivableDescription $description;
    protected AccountReceivableStatus $status;
    protected AccountReceivableBranchId $branchId;
    protected AccountReceivablePersonId $personId;
    protected AccountReceivableDocument $document;
    protected AccountReceivableOriginalDueDate $originalDueDate;
    protected AccountReceivableDueDate $dueDate;
    protected AccountReceivableGrossValue $grossValue;
    protected AccountReceivableNetValue $netValue;
    protected AccountReceivableReturnedValue $returnedValue;
    protected AccountReceivablePaidValue $paidValue;
    protected AccountReceivableFeeValue $feeValue;
    protected AccountReceivableDiscountValue $discountValue;
    protected AccountReceivableInterestValue $interestValue;
    protected AccountReceivableIsImportedData $isImportedData;
    protected AccountReceivablePaymentMethodId $paymentMethodId;
    protected AccountReceivablePaymentPlanId $paymentPlanId;
    protected AccountReceivableFinancialOperatorId $financialOperatorId;
    protected AccountReceivablePaymentDate $paymentDate;
    protected AccountReceivableClearanceDate $clearanceDate;
    protected AccountReceivableReceivableAccountId $receivableAccountId;
    protected AccountReceivableClearancePersonId $clearancePersonId;
    protected AccountReceivableClearanceType $clearanceType;
    protected AccountReceivableResponsibleId $responsibleId;
    protected string $reference;
    protected string $referenceId;

    public function id(AccountReceivableId $id): AccountReceivable
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?AccountReceivableId
    {
        return $this->id ?? null;
    }

    public function personId(AccountReceivablePersonId $personId): AccountReceivable
    {
        $this->personId = $personId;
        return $this;
    }

    public function getPersonId(): ?AccountReceivablePersonId
    {
        return $this->personId ?? null;
    }

    public function branchId(AccountReceivableBranchId $branchId): AccountReceivable
    {
        $this->branchId = $branchId;
        return $this;
    }

    public function getBranchId(): ?AccountReceivableBranchId
    {
        return $this->branchId ?? null;
    }

    public function description(AccountReceivableDescription $description): AccountReceivable
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): ?AccountReceivableDescription
    {
        return $this->description ?? null;
    }

    public function active(string $active): AccountReceivable
    {
        $this->active = $active;
        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active ?? null;
    }

    public function document(AccountReceivableDocument $document): AccountReceivable
    {
        $this->document = $document;
        return $this;
    }

    public function getDocument(): ?AccountReceivableDocument
    {
        return $this->document ?? null;
    }

    public function originalDueDate(AccountReceivableOriginalDueDate $originalDueDate): AccountReceivable
    {
        $this->originalDueDate = $originalDueDate;
        return $this;
    }

    public function getOriginalDueDate(): ?AccountReceivableOriginalDueDate
    {
        return $this->originalDueDate ?? null;
    }

    public function dueDate(AccountReceivableDueDate $dueDate): AccountReceivable
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    public function getDueDate(): ?AccountReceivableDueDate
    {
        return $this->dueDate ?? null;
    }

    public function grossValue(AccountReceivableGrossValue $grossValue): AccountReceivable
    {
        $this->grossValue = $grossValue;
        return $this;
    }

    public function getGrossValue(): ?AccountReceivableGrossValue
    {
        return $this->grossValue ?? null;
    }

    public function netValue(AccountReceivableNetValue $netValue): AccountReceivable
    {
        $this->netValue = $netValue;
        return $this;
    }

    public function getNetValue(): ?AccountReceivableNetValue
    {
        return $this->netValue ?? null;
    }

    public function returnedValue(AccountReceivableReturnedValue $returnedValue): AccountReceivable
    {
        $this->returnedValue = $returnedValue;
        return $this;
    }

    public function getReturnedValue(): ?AccountReceivableReturnedValue
    {
        return $this->returnedValue ?? null;
    }

    public function paidValue(AccountReceivablePaidValue $paidValue): AccountReceivable
    {
        $this->paidValue = $paidValue;
        return $this;
    }

    public function getPaidValue(): ?AccountReceivablePaidValue
    {
        return $this->paidValue ?? null;
    }

    public function feeValue(AccountReceivableFeeValue $feeValue): AccountReceivable
    {
        $this->feeValue = $feeValue;
        return $this;
    }

    public function getFeeValue(): ?AccountReceivableFeeValue
    {
        return $this->feeValue ?? null;
    }

    public function discountValue(AccountReceivableDiscountValue $discountValue): AccountReceivable
    {
        $this->discountValue = $discountValue;
        return $this;
    }

    public function getDiscountValue(): ?AccountReceivableDiscountValue
    {
        return $this->discountValue ?? null;
    }

    public function interestValue(AccountReceivableInterestValue $interestValue): AccountReceivable
    {
        $this->interestValue = $interestValue;
        return $this;
    }

    public function getInterestValue(): ?AccountReceivableInterestValue
    {
        return $this->interestValue ?? null;
    }

    public function responsibleId(AccountReceivableResponsibleId $responsibleId): AccountReceivable
    {
        $this->responsibleId = $responsibleId;
        return $this;
    }

    public function getResponsibleId(): ?AccountReceivableResponsibleId
    {
        return $this->responsibleId ?? null;
    }

    public function isImportedData(AccountReceivableIsImportedData $isImportedData): AccountReceivable
    {
        $this->isImportedData = $isImportedData;
        return $this;
    }

    public function getIsImportedData(): ?AccountReceivableIsImportedData
    {
        return $this->isImportedData ?? null;
    }

    public function paymentMethodId(AccountReceivablePaymentMethodId $paymentMethodId): AccountReceivable
    {
        $this->paymentMethodId = $paymentMethodId;
        return $this;
    }

    public function getPaymentMethodId(): ?AccountReceivablePaymentMethodId
    {
        return $this->paymentMethodId ?? null;
    }

    public function paymentPlanId(AccountReceivablePaymentPlanId $paymentPlanId): AccountReceivable
    {
        $this->paymentPlanId = $paymentPlanId;
        return $this;
    }

    public function getPaymentPlanId(): ?AccountReceivablePaymentPlanId
    {
        return $this->paymentPlanId ?? null;
    }

    public function financialOperatorId(AccountReceivableFinancialOperatorId $financialOperatorId): AccountReceivable
    {
        $this->financialOperatorId = $financialOperatorId;
        return $this;
    }

    public function getFinancialOperatorId(): ?AccountReceivableFinancialOperatorId
    {
        return $this->financialOperatorId ?? null;
    }

    public function paymentDate(AccountReceivablePaymentDate $paymentDate): AccountReceivable
    {
        $this->paymentDate = $paymentDate;
        return $this;
    }

    public function getPaymentDate(): ?AccountReceivablePaymentDate
    {
        return $this->paymentDate ?? null;
    }

    public function clearanceDate(AccountReceivableClearanceDate $clearanceDate): AccountReceivable
    {
        $this->clearanceDate = $clearanceDate;
        return $this;
    }

    public function getClearanceDate(): ?AccountReceivableClearanceDate
    {
        return $this->clearanceDate ?? null;
    }

    public function receivableAccountId(AccountReceivableReceivableAccountId $receivableAccountId): AccountReceivable
    {
        $this->receivableAccountId = $receivableAccountId;
        return $this;
    }

    public function getReceivableAccountId(): ?AccountReceivableReceivableAccountId
    {
        return $this->receivableAccountId ?? null;
    }

    public function clearancePersonId(AccountReceivableClearancePersonId $clearancePersonId): AccountReceivable
    {
        $this->clearancePersonId = $clearancePersonId;
        return $this;
    }

    public function getClearancePersonId(): ?AccountReceivableClearancePersonId
    {
        return $this->clearancePersonId ?? null;
    }

    public function clearanceType(AccountReceivableClearanceType $clearanceType): AccountReceivable
    {
        $this->clearanceType = $clearanceType;
        return $this;
    }

    public function getClearanceType(): ?AccountReceivableClearanceType
    {
        return $this->clearanceType ?? null;
    }

    public function status(AccountReceivableStatus $status): AccountReceivable
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): ?AccountReceivableStatus
    {
        return $this->status ?? null;
    }

    public function reference(string $reference): AccountReceivable
    {
        $this->reference = $reference;
        return $this;
    }

    public function getRegerence(): ?string
    {
        return $this->reference ?? '';
    }

    public function referenceId(string $referenceId): AccountReceivable
    {
        $this->referenceId = $referenceId;
        return $this;
    }

    public function getRegerenceId(): ?string
    {
        return $this->referenceId ?? '';
    }

    public static function buildEntity(array $data): AccountReceivable
    {
        $entity = (new self());
        $mapping = [
            ['keys' => ['id'], 'callback' => fn($value) => $entity->id(new AccountReceivableId($value))],
            ['keys' => ['descricao', 'description'], 'callback' => fn($value) => $entity->description(new AccountReceivableDescription((string)$value))],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn($value) => $entity->tenantId(new BaseEntityTenantId($value))],
            ['keys' => ['active'], 'callback' => fn($value) => $entity->active((string)$value)],
            ['keys' => ['userId', 'user_id'], 'callback' => fn($value) => $entity->userId(new BaseEntityUserId($value))],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn($value) => $entity->userUpdateId(new BaseEntityUserId($value))],
            ['keys' => ['status'], 'callback' => fn($value) => $entity->status(new AccountReceivableStatus((string)$value))],
            ['keys' => ['branchId', 'filial_id'], 'callback' => fn($value) => $entity->branchId(new AccountReceivableBranchId((string)$value))],
            ['keys' => ['document', 'documento'], 'callback' => fn($value) => $entity->document(new AccountReceivableDocument((string)$value))],
            ['keys' => ['originalDueDate', 'dtVencimentoOriginal'], 'callback' => fn($value) => $entity->originalDueDate(new AccountReceivableOriginalDueDate((string)$value))],
            ['keys' => ['dueDate', 'dtVencimento'], 'callback' => fn($value) => $entity->dueDate(new AccountReceivableDueDate((string)$value))],
            ['keys' => ['grossValue', 'vrBruto'], 'callback' => fn($value) => $entity->grossValue(new AccountReceivableGrossValue((string)$value))],
            ['keys' => ['netValue', 'vrLiquido'], 'callback' => fn($value) => $entity->netValue(new AccountReceivableNetValue((string)$value))],
            ['keys' => ['returnedValue', 'vrDevolvido'], 'callback' => fn($value) => $entity->returnedValue(new AccountReceivableReturnedValue((string)$value))],
            ['keys' => ['paidValue', 'vrPago'], 'callback' => fn($value) => $entity->paidValue(new AccountReceivablePaidValue((string)$value))],
            ['keys' => ['feeValue', 'vrTaxa'], 'callback' => fn($value) => $entity->feeValue(new AccountReceivableFeeValue((string)$value))],
            ['keys' => ['discountValue', 'vrDesconto'], 'callback' => fn($value) => $entity->discountValue(new AccountReceivableDiscountValue((string)$value))],
            ['keys' => ['interestValue', 'vrJuros'], 'callback' => fn($value) => $entity->interestValue(new AccountReceivableInterestValue((string)$value))],
            ['keys' => ['isImportedData', 'importacao_dados'], 'callback' => fn($value) => $entity->isImportedData(new AccountReceivableIsImportedData((string)$value))],
            ['keys' => ['paymentMethodId', 'forma_pagamento_id'], 'callback' => fn($value) => $entity->paymentMethodId(new AccountReceivablePaymentMethodId((string)$value))],
            ['keys' => ['paymentPlanId', 'plano_pagamento_id'], 'callback' => fn($value) => $entity->paymentPlanId(new AccountReceivablePaymentPlanId((string)$value))],
            ['keys' => ['financialOperatorId', 'operador_financeiro_id'], 'callback' => fn($value) => $entity->financialOperatorId(new AccountReceivableFinancialOperatorId((string)$value))],
            ['keys' => ['paymentDate'], 'callback' => fn($value) => $entity->paymentDate(new AccountReceivablePaymentDate((string)$value))],
            ['keys' => ['clearanceDate'], 'callback' => fn($value) => $entity->clearanceDate(new AccountReceivableClearanceDate((string)$value))],
            ['keys' => ['receivableAccountId'], 'callback' => fn($value) => $entity->receivableAccountId(new AccountReceivableReceivableAccountId((string)$value))],
            ['keys' => ['clearancePersonId'], 'callback' => fn($value) => $entity->clearancePersonId(new AccountReceivableClearancePersonId((string)$value))],
            ['keys' => ['clearanceType'], 'callback' => fn($value) => $entity->clearanceType(new AccountReceivableClearanceType((string)$value))],
            ['keys' => ['responsibleId', 'responsavel_id'], 'callback' => fn($value) => $entity->responsibleId(new AccountReceivableResponsibleId((string)$value))],
            ['keys' => ['personId', 'pessoa_id'], 'callback' => fn($value) => $entity->personId(new AccountReceivablePersonId((string)$value))],
            ['keys' => ['reference', 'referencia'], 'callback' => fn($value) => $entity->reference((string)$value)],
            ['keys' => ['referenceId', 'referencia_id'], 'callback' => fn($value) => $entity->referenceId((string)$value)],
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

    public function build(): ContaReceber
    {
        $data = [
            'id' => isset($this->id) ? (string)$this->id : null,
            'descricao' => isset($this->description) ? (string) $this->description : null,
            'tenant_id' => isset($this->tenantId) ? (string) $this->tenantId : null,
            'active' => isset($this->active) ? (string) $this->active : null,
            'user_id' => isset($this->userId) ? (string) $this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string) $this->userUpdateId : null,
            'status' => isset($this->status) ? (string) $this->status : null,
            'filial_id' => isset($this->branchId) ? (string) $this->branchId : null,
            'documento' => isset($this->document) ? (string) $this->document : null,
            'dtVencimentoOriginal' => isset($this->originalDueDate) ? (string) $this->originalDueDate : null,
            'dtVencimento' => isset($this->dueDate) ? (string) $this->dueDate : null,
            'vrBruto' => isset($this->grossValue) ? (string) $this->grossValue : null,
            'vrLiquido' => isset($this->netValue) ? (string) $this->netValue : null,
            'vrDevolvido' => isset($this->returnedValue) ? (string) $this->returnedValue : null,
            'vrPago' => isset($this->paidValue) ? (string) $this->paidValue : null,
            'vrTaxa' => isset($this->feeValue) ? (string) $this->feeValue : null,
            'vrDesconto' => isset($this->discountValue) ? (string) $this->discountValue : null,
            'vrJuros' => isset($this->interestValue) ? (string) $this->interestValue : null,
            'importacao_dados' => isset($this->isImportedData) ? (string) $this->isImportedData : null,
            'forma_pagamento_id' => isset($this->paymentMethodId) ? (string) $this->paymentMethodId : null,
            'plano_pagamento_id' => isset($this->paymentPlanId) ? (string) $this->paymentPlanId : null,
            'operador_financeiro_id' => isset($this->financialOperatorId) ? (string) $this->financialOperatorId : null,
            'responsavel_id' => isset($this->responsibleId) ? (string) $this->responsibleId : null,
            'pessoa_id' => isset($this->personId) ? (string) $this->personId : null,
        ];

        $data = array_filter($data, function ($value) {
            return $value !== null;
        });

        return new ContaReceber($data);
    }
}
