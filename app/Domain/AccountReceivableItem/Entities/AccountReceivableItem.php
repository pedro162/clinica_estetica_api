<?php

namespace App\Domain\AccountReceivableItem\Entities;

use App\ContaReceberItem;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableId;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemBranchId;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemCashboxId;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemClearanceDate;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemClearanceHash;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemClearancePersonId;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemClearanceType;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemDescription;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemDiscountValue;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemDocument;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemDueDate;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemFeeValue;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemFinancialOperatorId;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemGrossValue;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemId;
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
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemStatus;
use App\Domain\BaseEntity\Entities\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;

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
    protected AccountReceivableId $accountReceivableId;

    public function id(AccountReceivableItemId $id): AccountReceivableItem
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?AccountReceivableItemId
    {
        return $this->id ?? null;
    }

    public function accountReceivableId(AccountReceivableId $accountReceivableId): AccountReceivableItem
    {
        $this->accountReceivableId = $accountReceivableId;
        return $this;
    }

    public function getAccountReceivableid(): ?AccountReceivableId
    {
        return $this->accountReceivableId ?? null;
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
        $entity = (new self());

        $mapping = [
            ['keys' => ['id'], 'callback' => fn ($value) => $entity->id(new AccountReceivableItemId($value))],
            ['keys' => ['descricao', 'desciption', 'description'], 'callback' => fn ($value) => $entity->desciption(new AccountReceivableItemDescription((string)$value))],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn ($value) => $entity->tenantId(new BaseEntityTenantId($value))],
            ['keys' => ['active'], 'callback' => fn ($value) => $entity->active((string)$value)],
            ['keys' => ['userId', 'user_id'], 'callback' => fn ($value) => $entity->userId(new BaseEntityUserId($value))],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn ($value) => $entity->userUpdateId(new BaseEntityUserId($value))],
            ['keys' => ['status'], 'callback' => fn ($value) => $entity->status(new AccountReceivableItemStatus((string)$value))],
            ['keys' => ['branchId', 'filial_id'], 'callback' => fn ($value) => $entity->branchId(new AccountReceivableItemBranchId((string)$value))],
            ['keys' => ['document', 'documento'], 'callback' => fn ($value) => $entity->document(new AccountReceivableItemDocument((string)$value))],
            ['keys' => ['originalDueDate'], 'callback' => fn ($value) => $entity->originalDueDate(new AccountReceivableItemOriginalDueDate((string)$value))],
            ['keys' => ['dueDate'], 'callback' => fn ($value) => $entity->dueDate(new AccountReceivableItemDueDate((string)$value))],
            ['keys' => ['grossValue', 'vrBruto'], 'callback' => fn ($value) => $entity->grossValue(new AccountReceivableItemGrossValue((string)$value))],
            ['keys' => ['netValue', 'vrLiquido'], 'callback' => fn ($value) => $entity->netValue(new AccountReceivableItemNetValue((string)$value))],
            ['keys' => ['returnedValue', 'vrDevolvido'], 'callback' => fn ($value) => $entity->returnedValue(new AccountReceivableItemReturnedValue((string)$value))],
            ['keys' => ['paidValue', 'vrPago'], 'callback' => fn ($value) => $entity->paidValue(new AccountReceivableItemPaidValue((string)$value))],
            ['keys' => ['feeValue', 'vrTaxa'], 'callback' => fn ($value) => $entity->feeValue(new AccountReceivableItemFeeValue((string)$value))],
            ['keys' => ['discountValue', 'vrDesconto'], 'callback' => fn ($value) => $entity->discountValue(new AccountReceivableItemDiscountValue((string)$value))],
            ['keys' => ['interestValue', 'vrJuros'], 'callback' => fn ($value) => $entity->interestValue(new AccountReceivableItemInterestValue((string)$value))],
            ['keys' => ['isImportedData'], 'callback' => fn ($value) => $entity->isImportedData(new AccountReceivableItemIsImportedData((string)$value))],
            ['keys' => ['paymentMethodId', 'forma_pagamentos_id'], 'callback' => fn ($value) => $entity->paymentMethodId(new AccountReceivableItemPaymentMethodId((string)$value))],
            ['keys' => ['paymentPlanId', 'plano_pagamento_id'], 'callback' => fn ($value) => $entity->paymentPlanId(new AccountReceivableItemPaymentPlanId((string)$value))],
            ['keys' => ['financialOperatorId', 'operador_financeiro_id'], 'callback' => fn ($value) => $entity->financialOperatorId(new AccountReceivableItemFinancialOperatorId((string)$value))],
            ['keys' => ['paymentDate', 'dtPagamento'], 'callback' => fn ($value) => $entity->paymentDate(new AccountReceivableItemPaymentDate((string)$value))],
            ['keys' => ['clearanceDate', 'dtBaixa'], 'callback' => fn ($value) => $entity->clearanceDate(new AccountReceivableItemClearanceDate((string)$value))],
            ['keys' => ['receivableAccountId', 'conta_receber_id'], 'callback' => fn ($value) => $entity->receivableAccountId(new AccountReceivableItemReceivableAccountId((string)$value))],
            ['keys' => ['clearancePersonId', 'pessoa_baixa_id'], 'callback' => fn ($value) => $entity->clearancePersonId(new AccountReceivableItemClearancePersonId((string)$value))],
            ['keys' => ['clearanceType', 'tpBaixa'], 'callback' => fn ($value) => $entity->clearanceType(new AccountReceivableItemClearanceType((string)$value))],
            ['keys' => ['responsibleId'], 'callback' => fn ($value) => $entity->responsibleId(new AccountReceivableItemResponsibleId((string)$value))],
            ['keys' => ['clearanceHash', 'rashBaixa'], 'callback' => fn ($value) => $entity->clearanceHash(new AccountReceivableItemClearanceHash((string)$value))],
            ['keys' => ['cashboxId', 'caixa_id'], 'callback' => fn ($value) => $entity->cashboxId(new AccountReceivableItemCashboxId((string)$value))],
            ['keys' => ['refundPersonId', 'pessoa_devolucao_id'], 'callback' => fn ($value) => $entity->refundPersonId(new AccountReceivableItemRefundPersonId((string)$value))],
            ['keys' => ['reversalPersonId', 'pessoa_estorno_id'], 'callback' => fn ($value) => $entity->reversalPersonId(new AccountReceivableItemReversalPersonId((string)$value))],
            ['keys' => ['reversalDescription', 'ds_estorno'], 'callback' => fn ($value) => $entity->reversalDescription(new AccountReceivableItemReversalDescription((string)$value))],
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

    public function build(): ContaReceberItem
    {
        $data = [
            'id' => isset($this->id) ? (string)$this->id : null,
            'descricao' => isset($this->desciption) ? (string)$this->desciption : null,
            'documento' => isset($this->document) ? (string)$this->document : null,
            'tenant_id' => isset($this->tenantId) ? (string)$this->tenantId : null,
            'active' => isset($this->active) ? (string)$this->active : null,
            'user_id' => isset($this->userId) ? (string)$this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string)$this->userUpdateId : null,
            'status' => isset($this->status) ? (string)$this->status : null,
            'vrBruto' => isset($this->grossValue) ? (string)$this->grossValue : null,
            'vrLiquido' => isset($this->netValue) ? (string)$this->netValue : null,
            'vrDevolvido' => isset($this->returnedValue) ? (string)$this->returnedValue : null,
            'vrPago' => isset($this->paidValue) ? (string)$this->paidValue : null,
            'vrTaxa' => isset($this->feeValue) ? (string)$this->feeValue : null,
            'vrDesconto' => isset($this->discountValue) ? (string)$this->discountValue : null,
            'vrJuros' => isset($this->interestValue) ? (string)$this->interestValue : null,
            'forma_pagamentos_id' => isset($this->paymentMethodId) ? (string)$this->paymentMethodId : null,
            'plano_pagamento_id' => isset($this->paymentPlanId) ? (string)$this->paymentPlanId : null,
            'operador_financeiro_id' => isset($this->financialOperatorId) ? (string)$this->financialOperatorId : null,
            'dtPagamento' => isset($this->paymentDate) ? (string)$this->paymentDate : null,
            'dtBaixa' => isset($this->clearanceDate) ? (string)$this->clearanceDate : null,
            'conta_receber_id' => isset($this->receivableAccountId) ? (string)$this->receivableAccountId : null,
            'pessoa_baixa_id' => isset($this->clearancePersonId) ? (string)$this->clearancePersonId : null,
            'tpBaixa' => isset($this->clearanceType) ? (string)$this->clearanceType : null,
            'rashBaixa' => isset($this->clearanceHash) ? (string)$this->clearanceHash : null,
            'caixa_id' => isset($this->cashboxId) ? (string)$this->cashboxId : null,
            'pessoa_devolucao_id' => isset($this->refundPersonId) ? (string)$this->refundPersonId : null,
            'pessoa_estorno_id' => isset($this->reversalPersonId) ? (string)$this->reversalPersonId : null,
            'ds_estorno' => isset($this->reversalDescription) ? (string)$this->reversalDescription : null,
        ];

        $data = array_filter($data, function ($value) {
            return $value !== null;
        });

        return new ContaReceberItem($data);
    }
}
