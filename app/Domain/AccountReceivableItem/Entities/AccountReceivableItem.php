<?php

namespace App\Domain\AccountReceivableItem\Entities;

use App\ContaReceberItem;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemActive;
use App\Domain\BaseEntity\Entities\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemStatus;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemBranchId;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemCashboxId;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemClearanceDate;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemClearanceHash;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemClearancePersonId;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemClearanceType;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemId;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemDescription;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemDiscountValue;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemDocument;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemDueDate;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemFeeValue;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemFinancialOperatorId;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemGrossValue;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemInterestValue;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemIsImportedData;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemNetValue;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemOriginalDueDate;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemPaidValue;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemPaymentDate;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemPaymentMethodId;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemPaymentPlanId;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemReceivableAccountId;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemRefundPersonId;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemResponsibleId;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemReturnedValue;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemReversalDescription;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemReversalPersonId;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemTenantId;

class AccountReceivableItem extends BaseEntity
{
    protected AccountReceivableItemId $id;
    protected AccountReceivableItemDescription $desciption;
    protected AccountReceivableItemStatus $status;
    protected AccountReceivableItemBranchId $branchId;
    protected AccountReceivableItemDocument $document;
    protected AccountReceivableItemOriginalDueDate $originalDueDate;
    protected AccountReceivableItemDueDate $dueDate;
    protected AccountReceivableItemGrossValue $grossValue;
    protected AccountReceivableItemNetValue $netValue;
    protected AccountReceivableItemReturnedValue $returnedValue;
    protected AccountReceivableItemPaidValue $paidValue;
    protected AccountReceivableItemFeeValue $feeValue;
    protected AccountReceivableItemDiscountValue $discountValue;
    protected AccountReceivableItemInterestValue $interestValue;
    protected AccountReceivableItemResponsibleId $responsibleId;
    protected AccountReceivableItemIsImportedData $isImportedData;
    protected AccountReceivableItemPaymentMethodId $paymentMethodId;
    protected AccountReceivableItemPaymentPlanId $paymentPlanId;
    protected AccountReceivableItemFinancialOperatorId $financialOperatorId;
    protected AccountReceivableItemTenantId $tenantId;
    protected AccountReceivableItemActive $active;
    protected AccountReceivableItemPaymentDate $paymentDate;
    protected AccountReceivableItemClearanceDate $clearanceDate;
    protected AccountReceivableItemReversalDescription $reversalDescription;
    protected AccountReceivableItemReceivableAccountId $receivableAccountId;
    protected AccountReceivableItemReversalPersonId $reversalPersonId;
    protected AccountReceivableItemClearancePersonId $clearancePersonId;
    protected AccountReceivableItemRefundPersonId $refundPersonId;
    protected AccountReceivableItemCashboxId $cashboxId;
    protected AccountReceivableItemClearanceType $clearanceType;
    protected AccountReceivableItemClearanceHash $clearanceHash;

    public function id(AccountReceivableItemId $id): AccountReceivableItem
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?AccountReceivableItemId
    {
        return $this->id ?? null;
    }

    public function branchId(AccountReceivableItemBranchId $branchId): AccountReceivableItem
    {
        $this->branchId = $branchId;
        return $this;
    }

    public function getBranchId(): ?AccountReceivableItemBranchId
    {
        return $this->branchId ?? null;
    }

    public function desciption(AccountReceivableItemDescription $desciption): AccountReceivableItem
    {
        $this->desciption = $desciption;
        return $this;
    }

    public function getDescription(): ?AccountReceivableItemDescription
    {
        return $this->desciption ?? null;
    }

    public function status(AccountReceivableItemStatus $status): AccountReceivableItem
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): ?AccountReceivableItemStatus
    {
        return $this->status ?? null;
    }

    public function active(string $active): AccountReceivableItem
    {
        $this->active = $active;
        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active ?? null;
    }

    public function document(AccountReceivableItemDocument $document): AccountReceivableItem
    {
        $this->document = $document;
        return $this;
    }

    public function getDocument(): ?AccountReceivableItemDocument
    {
        return $this->document ?? null;
    }

    public function originalDueDate(AccountReceivableItemOriginalDueDate $originalDueDate): AccountReceivableItem
    {
        $this->originalDueDate = $originalDueDate;
        return $this;
    }

    public function getOriginalDueDate(): ?AccountReceivableItemOriginalDueDate
    {
        return $this->originalDueDate ?? null;
    }

    public function dueDate(AccountReceivableItemDueDate $dueDate): AccountReceivableItem
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    public function getDueDate(): ?AccountReceivableItemDueDate
    {
        return $this->dueDate ?? null;
    }

    public function grossValue(AccountReceivableItemGrossValue $grossValue): AccountReceivableItem
    {
        $this->grossValue = $grossValue;
        return $this;
    }

    public function getGrossValue(): ?AccountReceivableItemGrossValue
    {
        return $this->grossValue ?? null;
    }

    public function netValue(AccountReceivableItemNetValue $netValue): AccountReceivableItem
    {
        $this->netValue = $netValue;
        return $this;
    }

    public function getNetValue(): ?AccountReceivableItemNetValue
    {
        return $this->netValue ?? null;
    }

    public function returnedValue(AccountReceivableItemReturnedValue $returnedValue): AccountReceivableItem
    {
        $this->returnedValue = $returnedValue;
        return $this;
    }

    public function getReturnedValue(): ?AccountReceivableItemReturnedValue
    {
        return $this->returnedValue ?? null;
    }

    public function paidValue(AccountReceivableItemPaidValue $paidValue): AccountReceivableItem
    {
        $this->paidValue = $paidValue;
        return $this;
    }

    public function getPaidValue(): ?AccountReceivableItemPaidValue
    {
        return $this->paidValue ?? null;
    }

    public function feeValue(AccountReceivableItemFeeValue $feeValue): AccountReceivableItem
    {
        $this->feeValue = $feeValue;
        return $this;
    }

    public function getFeeValue(): ?AccountReceivableItemFeeValue
    {
        return $this->feeValue ?? null;
    }

    public function discountValue(AccountReceivableItemDiscountValue $discountValue): AccountReceivableItem
    {
        $this->discountValue = $discountValue;
        return $this;
    }

    public function getDiscountValue(): ?AccountReceivableItemDiscountValue
    {
        return $this->discountValue ?? null;
    }

    public function interestValue(AccountReceivableItemInterestValue $interestValue): AccountReceivableItem
    {
        $this->interestValue = $interestValue;
        return $this;
    }

    public function getInterestValue(): ?AccountReceivableItemInterestValue
    {
        return $this->interestValue ?? null;
    }

    public function responsibleId(AccountReceivableItemResponsibleId $responsibleId): AccountReceivableItem
    {
        $this->responsibleId = $responsibleId;
        return $this;
    }

    public function getResponsibleId(): ?AccountReceivableItemResponsibleId
    {
        return $this->responsibleId ?? null;
    }

    public function isImportedData(AccountReceivableItemIsImportedData $isImportedData): AccountReceivableItem
    {
        $this->isImportedData = $isImportedData;
        return $this;
    }

    public function getIsImportedData(): ?AccountReceivableItemIsImportedData
    {
        return $this->isImportedData ?? null;
    }

    public function paymentMethodId(AccountReceivableItemPaymentMethodId $paymentMethodId): AccountReceivableItem
    {
        $this->paymentMethodId = $paymentMethodId;
        return $this;
    }

    public function getPaymentMethodId(): ?AccountReceivableItemPaymentMethodId
    {
        return $this->paymentMethodId ?? null;
    }

    public function paymentPlanId(AccountReceivableItemPaymentPlanId $paymentPlanId): AccountReceivableItem
    {
        $this->paymentPlanId = $paymentPlanId;
        return $this;
    }

    public function getPaymentPlanId(): ?AccountReceivableItemPaymentPlanId
    {
        return $this->paymentPlanId ?? null;
    }

    public function financialOperatorId(AccountReceivableItemFinancialOperatorId $financialOperatorId): AccountReceivableItem
    {
        $this->financialOperatorId = $financialOperatorId;
        return $this;
    }

    public function getFinancialOperatorId(): ?AccountReceivableItemFinancialOperatorId
    {
        return $this->financialOperatorId ?? null;
    }

    public function paymentDate(AccountReceivableItemPaymentDate $paymentDate): AccountReceivableItem
    {
        $this->paymentDate = $paymentDate;
        return $this;
    }

    public function getPaymentDate(): ?AccountReceivableItemPaymentDate
    {
        return $this->paymentDate ?? null;
    }

    public function clearanceDate(AccountReceivableItemClearanceDate $clearanceDate): AccountReceivableItem
    {
        $this->clearanceDate = $clearanceDate;
        return $this;
    }

    public function getClearanceDate(): ?AccountReceivableItemClearanceDate
    {
        return $this->clearanceDate ?? null;
    }

    public function reversalDescription(AccountReceivableItemReversalDescription $reversalDescription): AccountReceivableItem
    {
        $this->reversalDescription = $reversalDescription;
        return $this;
    }

    public function getReversalDescription(): ?AccountReceivableItemReversalDescription
    {
        return $this->reversalDescription ?? null;
    }

    public function receivableAccountId(AccountReceivableItemReceivableAccountId $receivableAccountId): AccountReceivableItem
    {
        $this->receivableAccountId = $receivableAccountId;
        return $this;
    }

    public function getReceivableAccountId(): ?AccountReceivableItemReceivableAccountId
    {
        return $this->receivableAccountId ?? null;
    }

    public function reversalPersonId(AccountReceivableItemReversalPersonId $reversalPersonId): AccountReceivableItem
    {
        $this->reversalPersonId = $reversalPersonId;
        return $this;
    }

    public function getReversalPersonId(): ?AccountReceivableItemReversalPersonId
    {
        return $this->reversalPersonId ?? null;
    }

    public function clearancePersonId(AccountReceivableItemClearancePersonId $clearancePersonId): AccountReceivableItem
    {
        $this->clearancePersonId = $clearancePersonId;
        return $this;
    }

    public function getClearancePersonId(): ?AccountReceivableItemClearancePersonId
    {
        return $this->clearancePersonId ?? null;
    }

    public function refundPersonId(AccountReceivableItemRefundPersonId $refundPersonId): AccountReceivableItem
    {
        $this->refundPersonId = $refundPersonId;
        return $this;
    }

    public function getRefundPersonId(): ?AccountReceivableItemRefundPersonId
    {
        return $this->refundPersonId ?? null;
    }

    public function cashboxId(AccountReceivableItemCashboxId $cashboxId): AccountReceivableItem
    {
        $this->cashboxId = $cashboxId;
        return $this;
    }

    public function getCashboxId(): ?AccountReceivableItemCashboxId
    {
        return $this->cashboxId ?? null;
    }

    public function clearanceType(AccountReceivableItemClearanceType $clearanceType): AccountReceivableItem
    {
        $this->clearanceType = $clearanceType;
        return $this;
    }

    public function getClearanceType(): ?AccountReceivableItemClearanceType
    {
        return $this->clearanceType ?? null;
    }

    public function clearanceHash(AccountReceivableItemClearanceHash $clearanceHash): AccountReceivableItem
    {
        $this->clearanceHash = $clearanceHash;
        return $this;
    }

    public function getClearanceHash(): ?AccountReceivableItemClearanceHash
    {
        return $this->clearanceHash ?? null;
    }

    public static function buildEntity(array $data): AccountReceivableItem
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
            ->id(new AccountReceivableItemId($id))
            ->desciption(new AccountReceivableItemDescription((string)($data['nmCidade'] ?? $data['desciption'] ?? '')))
            ->tenantId(new BaseEntityTenantId($tenantId))
            ->active(((string)($data['active'] ?? '')))
            ->userId(new BaseEntityUserId($userId))
            ->userUpdateId(new BaseEntityUserId($userUpdateId))
            ->status(new AccountReceivableItemStatus((string) $status))
            ->branchId(new AccountReceivableItemBranchId($branchId))
            ->originalDueDate(new AccountReceivableItemOriginalDueDate((string)($data['originalDueDate'] ?? '')))
            ->dueDate(new AccountReceivableItemDueDate((string)($data['dueDate'] ?? '')))
            ->grossValue(new AccountReceivableItemGrossValue((string)($data['grossValue'] ?? '')))
            ->netValue(new AccountReceivableItemNetValue((string)($data['netValue'] ?? '')))
            ->returnedValue(new AccountReceivableItemReturnedValue((string)($data['returnedValue'] ?? '')))
            ->paidValue(new AccountReceivableItemPaidValue((string)($data['paidValue'] ?? '')))
            ->feeValue(new AccountReceivableItemFeeValue((string)($data['feeValue'] ?? '')))
            ->discountValue(new AccountReceivableItemDiscountValue((string)($data['discountValue'] ?? '')))
            ->interestValue(new AccountReceivableItemInterestValue((string)($data['interestValue'] ?? '')))
            ->isImportedData(new AccountReceivableItemIsImportedData((string)($data['isImportedData'] ?? '')))
            ->paymentMethodId(new AccountReceivableItemPaymentMethodId((string)($data['paymentMethodId'] ?? '')))
            ->paymentPlanId(new AccountReceivableItemPaymentPlanId((string)($data['paymentPlanId'] ?? '')))
            ->financialOperatorId(new AccountReceivableItemFinancialOperatorId((string)($data['financialOperatorId'] ?? '')))
            ->paymentDate(new AccountReceivableItemPaymentDate((string)($data['paymentDate'] ?? '')))
            ->clearanceDate(new AccountReceivableItemClearanceDate((string)($data['clearanceDate'] ?? '')))
            ->receivableAccountId(new AccountReceivableItemReceivableAccountId((string)($data['receivableAccountId'] ?? '')))
            ->clearancePersonId(new AccountReceivableItemClearancePersonId((string)($data['clearancePersonId'] ?? '')))
            ->clearanceType(new AccountReceivableItemClearanceType((string)($data['clearanceType'] ?? '')))
            ->responsibleId(new AccountReceivableItemResponsibleId((string)($data['responsibleId'] ?? '')))
            ->clearanceHash(new AccountReceivableItemClearanceHash((string)($data['clearanceHash'] ?? '')))
            ->cashboxId(new AccountReceivableItemCashboxId((string)($data['cashboxId'] ?? '')))
            ->refundPersonId(new AccountReceivableItemRefundPersonId((string)($data['refundPersonId'] ?? '')))
            ->reversalPersonId(new AccountReceivableItemReversalPersonId((string)($data['reversalPersonId'] ?? '')))
            ->reversalDescription(new AccountReceivableItemReversalDescription((string)($data['reversalDescription'] ?? '')));

        return $entity;
    }

    public function build(): ContaReceberItem
    {
        $data = [
            'id' => isset($this->id) ? (string)$this->id : null,
            'desciption' => isset($this->desciption) ? (string)$this->desciption : null,
            'tenantId' => isset($this->tenantId) ? (string)$this->tenantId : null,
            'active' => isset($this->active) ? (string)$this->active : null,
            'userId' => isset($this->userId) ? (string)$this->userId : null,
            'userUpdateId' => isset($this->userUpdateId) ? (string)$this->userUpdateId : null,
            'status' => isset($this->status) ? (string)$this->status : null,
            'branchId' => isset($this->branchId) ? (string)$this->branchId : null,
            'originalDueDate' => isset($this->originalDueDate) ? (string)$this->originalDueDate : null,
            'dueDate' => isset($this->dueDate) ? (string)$this->dueDate : null,
            'grossValue' => isset($this->grossValue) ? (string)$this->grossValue : null,
            'netValue' => isset($this->netValue) ? (string)$this->netValue : null,
            'returnedValue' => isset($this->returnedValue) ? (string)$this->returnedValue : null,
            'paidValue' => isset($this->paidValue) ? (string)$this->paidValue : null,
            'feeValue' => isset($this->feeValue) ? (string)$this->feeValue : null,
            'discountValue' => isset($this->discountValue) ? (string)$this->discountValue : null,
            'interestValue' => isset($this->interestValue) ? (string)$this->interestValue : null,
            'isImportedData' => isset($this->isImportedData) ? (string)$this->isImportedData : null,
            'paymentMethodId' => isset($this->paymentMethodId) ? (string)$this->paymentMethodId : null,
            'paymentPlanId' => isset($this->paymentPlanId) ? (string)$this->paymentPlanId : null,
            'financialOperatorId' => isset($this->financialOperatorId) ? (string)$this->financialOperatorId : null,
            'paymentDate' => isset($this->paymentDate) ? (string)$this->paymentDate : null,
            'clearanceDate' => isset($this->clearanceDate) ? (string)$this->clearanceDate : null,
            'receivableAccountId' => isset($this->receivableAccountId) ? (string)$this->receivableAccountId : null,
            'clearancePersonId' => isset($this->clearancePersonId) ? (string)$this->clearancePersonId : null,
            'clearanceType' => isset($this->clearanceType) ? (string)$this->clearanceType : null,
            'responsibleId' => isset($this->responsibleId) ? (string)$this->responsibleId : null,
            'clearanceHash' => isset($this->clearanceHash) ? (string)$this->clearanceHash : null,
            'cashboxId' => isset($this->cashboxId) ? (string)$this->cashboxId : null,
            'refundPersonId' => isset($this->refundPersonId) ? (string)$this->refundPersonId : null,
            'reversalPersonId' => isset($this->reversalPersonId) ? (string)$this->reversalPersonId : null,
            'reversalDescription' => isset($this->reversalDescription) ? (string)$this->reversalDescription : null,
        ];

        $data = array_filter($data, function ($value) {
            return $value !== null;
        });

        return new ContaReceberItem($data);
    }
}
