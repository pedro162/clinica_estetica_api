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
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableReceivableAccountId;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableResponsibleId;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableReturnedValue;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableTenantId;

class AccountReceivable extends BaseEntity
{
    protected AccountReceivableId $id;
    protected AccountReceivableDescription $desciption;
    protected AccountReceivableStatus $status;
    protected AccountReceivableBranchId $branchId;
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
    protected AccountReceivableTenantId $tenantId;
    protected AccountReceivablePaymentDate $paymentDate;
    protected AccountReceivableClearanceDate $clearanceDate;
    protected AccountReceivableReceivableAccountId $receivableAccountId;
    protected AccountReceivableClearancePersonId $clearancePersonId;
    protected AccountReceivableClearanceType $clearanceType;
    protected AccountReceivableResponsibleId $responsibleId;

    public function id(AccountReceivableId $id): AccountReceivable
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?AccountReceivableId
    {
        return $this->id ?? null;
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

    public function desciption(AccountReceivableDescription $desciption): AccountReceivable
    {
        $this->desciption = $desciption;
        return $this;
    }

    public function getDescription(): ?AccountReceivableDescription
    {
        return $this->desciption ?? null;
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

    public function getStatus(): ?AccountReceivableStatus
    {
        return $this->status ?? null;
    }

    public static function buildEntity(array $data): AccountReceivable
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

        $status = $data['status'] ?? $data['status_bloqueio'] ?? '';
        $branchId = (string) ($data['branchId'] ?? $data['filial_id'] ?? 0);

        $entity = (new self())
            ->id(new AccountReceivableId($id))
            ->desciption(new AccountReceivableDescription((string)($data['nmCidade'] ?? $data['desciption'] ?? '')))
            ->tenantId(new BaseEntityTenantId($tenantId))
            ->active(((string)($data['active'] ?? '')))
            ->userId(new BaseEntityUserId($userId))
            ->userUpdateId(new BaseEntityUserId($userUpdateId))
            ->status(new AccountReceivableStatus((string) $status))
            ->branchId(new AccountReceivableBranchId($branchId));

        return $entity;
    }

    public function build(): ContaReceber
    {
        $data = [
            'id' => isset($this->id) ? (string)$this->id : null,
            'branchId' => isset($this->branchId) ? (string)$this->branchId : null,
            'desciption' => isset($this->desciption) ? (string)$this->desciption : null,
            'status_bloqueio' => isset($this->status) ? (string)$this->status : null,
            'tenant_id' => isset($this->tenantId) ? (string)$this->tenantId : null,
            'active' => isset($this->active) ? (string)$this->active : null,
            'user_id' => isset($this->userId) ? (string)$this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string)$this->userUpdateId : null,
        ];

        $data = array_filter($data, function ($value) {
            return $value !== null;
        });

        return new ContaReceber($data);
    }
}
