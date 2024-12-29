<?php

namespace App\Application\Commands\AccountReceivableItem;

use App\Utilitarios;

class CreateAccountReceivableItemCommand
{

    protected string $id;
    protected string $description;
    protected string $document;
    protected string $originalDueDate;
    protected string $dueDate;
    protected string $grossValue;
    protected string $netValue;
    protected string $returnedValue;
    protected string $paidValue;
    protected string $feeValue;
    protected string $discountValue;
    protected string $interestValue;
    protected string $responsibleId;
    protected string $isImportedData;
    protected string $paymentMethodId;
    protected string $paymentPlanId;
    protected string $financialOperatorId;
    protected string $status;
    protected string $userId;
    protected string $userUpdateId;
    protected string $tenantId;
    protected string $active;
    protected string $branchId;
    protected string $paymentDate;
    protected string $clearanceDate;
    protected string $reversalDescription;
    protected string $receivableAccountId;
    protected string $reversalPersonId;
    protected string $clearancePersonId;
    protected string $refundPersonId;
    protected string $cashboxId;
    protected string $accountReceivableId;
    protected string $clearanceType;
    protected string $clearanceHash;

    public function id(string $id): CreateAccountReceivableItemCommand
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id ?? null;
    }

    public function accountReceivableId(string $accountReceivableId): CreateAccountReceivableItemCommand
    {
        $this->accountReceivableId = $accountReceivableId;
        return $this;
    }

    public function getAccountReceivableId(): ?string
    {
        return $this->accountReceivableId ?? null;
    }

    public function tenantId(string $tenantId): CreateAccountReceivableItemCommand
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function getTenantId(): ?string
    {
        return $this->tenantId ?? null;
    }

    public function description(string $description): CreateAccountReceivableItemCommand
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description ?? null;
    }

    public function userId(string $userId): CreateAccountReceivableItemCommand
    {
        $this->userId = $userId;
        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->userId ?? null;
    }

    public function userUpdateId(string $userUpdateId): CreateAccountReceivableItemCommand
    {
        $this->userUpdateId = $userUpdateId;
        return $this;
    }

    public function getUserUpdateId(): ?string
    {
        return $this->userUpdateId ?? null;
    }

    public function active(string $active): CreateAccountReceivableItemCommand
    {
        $this->active = $active;
        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active ?? null;
    }

    public function branchId(string $branchId): CreateAccountReceivableItemCommand
    {
        $this->branchId = $branchId;
        return $this;
    }

    public function getBranchId(): ?string
    {
        return $this->branchId ?? null;
    }

    public function document(string $document): CreateAccountReceivableItemCommand
    {
        $this->document = $document;
        return $this;
    }

    public function getDocument(): ?string
    {
        return $this->document ?? null;
    }

    public function originalDueDate(string $originalDueDate): CreateAccountReceivableItemCommand
    {
        $this->originalDueDate = $originalDueDate;
        return $this;
    }

    public function getOriginalDueDate(): ?string
    {
        return $this->originalDueDate ?? null;
    }

    public function dueDate(string $dueDate): CreateAccountReceivableItemCommand
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    public function getDueDate(): ?string
    {
        return $this->dueDate ?? null;
    }

    public function grossValue(string $grossValue): CreateAccountReceivableItemCommand
    {
        $this->grossValue = $grossValue;
        return $this;
    }

    public function getGrossValue(): ?string
    {
        return $this->grossValue ?? null;
    }

    public function netValue(string $netValue): CreateAccountReceivableItemCommand
    {
        $this->netValue = $netValue;
        return $this;
    }

    public function getNetValue(): ?string
    {
        return $this->netValue ?? null;
    }

    public function returnedValue(string $returnedValue): CreateAccountReceivableItemCommand
    {
        $this->returnedValue = $returnedValue;
        return $this;
    }

    public function getReturnedValue(): ?string
    {
        return $this->returnedValue ?? null;
    }

    public function paidValue(string $paidValue): CreateAccountReceivableItemCommand
    {
        $this->paidValue = $paidValue;
        return $this;
    }

    public function getPaidValue(): ?string
    {
        return $this->paidValue ?? null;
    }

    public function feeValue(string $feeValue): CreateAccountReceivableItemCommand
    {
        $this->feeValue = $feeValue;
        return $this;
    }

    public function getFeeValue(): ?string
    {
        return $this->feeValue ?? null;
    }

    public function discountValue(string $discountValue): CreateAccountReceivableItemCommand
    {
        $this->discountValue = $discountValue;
        return $this;
    }

    public function getDiscountValue(): ?string
    {
        return $this->discountValue ?? null;
    }

    public function interestValue(string $interestValue): CreateAccountReceivableItemCommand
    {
        $this->interestValue = $interestValue;
        return $this;
    }

    public function getInterestValue(): ?string
    {
        return $this->interestValue ?? null;
    }

    public function responsibleId(string $responsibleId): CreateAccountReceivableItemCommand
    {
        $this->responsibleId = $responsibleId;
        return $this;
    }

    public function getResponsibleId(): ?string
    {
        return $this->responsibleId ?? null;
    }

    public function isImportedData(string $isImportedData): CreateAccountReceivableItemCommand
    {
        $this->isImportedData = $isImportedData;
        return $this;
    }

    public function getIsImportedData(): ?string
    {
        return $this->isImportedData ?? null;
    }

    public function paymentMethodId(string $paymentMethodId): CreateAccountReceivableItemCommand
    {
        $this->paymentMethodId = $paymentMethodId;
        return $this;
    }

    public function getPaymentMethodId(): ?string
    {
        return $this->paymentMethodId ?? null;
    }

    public function paymentPlanId(string $paymentPlanId): CreateAccountReceivableItemCommand
    {
        $this->paymentPlanId = $paymentPlanId;
        return $this;
    }

    public function getPaymentPlanId(): ?string
    {
        return $this->paymentPlanId ?? null;
    }

    public function financialOperatorId(string $financialOperatorId): CreateAccountReceivableItemCommand
    {
        $this->financialOperatorId = $financialOperatorId;
        return $this;
    }

    public function getFinancialOperatorId(): ?string
    {
        return $this->financialOperatorId ?? null;
    }

    public function status(string $status): CreateAccountReceivableItemCommand
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status ?? null;
    }

    public function paymentDate(string $paymentDate): CreateAccountReceivableItemCommand
    {
        $this->paymentDate = $paymentDate;
        return $this;
    }

    public function getPaymentDate(): ?string
    {
        return $this->paymentDate ?? null;
    }

    public function clearanceDate(string $clearanceDate): CreateAccountReceivableItemCommand
    {
        $this->clearanceDate = $clearanceDate;
        return $this;
    }

    public function getClearanceDate(): ?string
    {
        return $this->clearanceDate ?? null;
    }

    public function reversalDescription(string $reversalDescription): CreateAccountReceivableItemCommand
    {
        $this->reversalDescription = $reversalDescription;
        return $this;
    }

    public function getReversalDescription(): ?string
    {
        return $this->reversalDescription ?? null;
    }

    public function receivableAccountId(string $receivableAccountId): CreateAccountReceivableItemCommand
    {
        $this->receivableAccountId = $receivableAccountId;
        return $this;
    }

    public function getReceivableAccountId(): ?string
    {
        return $this->receivableAccountId ?? null;
    }

    public function reversalPersonId(string $reversalPersonId): CreateAccountReceivableItemCommand
    {
        $this->reversalPersonId = $reversalPersonId;
        return $this;
    }

    public function getReversalPersonId(): ?string
    {
        return $this->reversalPersonId ?? null;
    }

    public function clearancePersonId(string $clearancePersonId): CreateAccountReceivableItemCommand
    {
        $this->clearancePersonId = $clearancePersonId;
        return $this;
    }

    public function getClearancePersonId(): ?string
    {
        return $this->clearancePersonId ?? null;
    }

    public function refundPersonId(string $refundPersonId): CreateAccountReceivableItemCommand
    {
        $this->refundPersonId = $refundPersonId;
        return $this;
    }

    public function getRefundPersonId(): ?string
    {
        return $this->refundPersonId ?? null;
    }

    public function cashboxId(string $cashboxId): CreateAccountReceivableItemCommand
    {
        $this->cashboxId = $cashboxId;
        return $this;
    }

    public function getCashboxId(): ?string
    {
        return $this->cashboxId ?? null;
    }

    public function clearanceType(string $clearanceType): CreateAccountReceivableItemCommand
    {
        $this->clearanceType = $clearanceType;
        return $this;
    }

    public function getClearanceType(): ?string
    {
        return $this->clearanceType ?? null;
    }

    public function clearanceHash(string $clearanceHash): CreateAccountReceivableItemCommand
    {
        $this->clearanceHash = $clearanceHash;
        return $this;
    }

    public function getClearanceHash(): ?string
    {
        return $this->clearanceHash ?? null;
    }

    public static function build(array $data): CreateAccountReceivableItemCommand
    {
        $grossValue = Utilitarios::removeMaskMoney($data['grossValue'] ?? $data['vrBruto'] ?? 0);
        $netValue = Utilitarios::removeMaskMoney($data['netValue'] ?? $data['vrLiquido'] ?? 0);
        $returnedValue = Utilitarios::removeMaskMoney($data['returnedValue'] ?? $data['vrDevolvido'] ?? 0);
        $paidValue = Utilitarios::removeMaskMoney($data['paidValue'] ?? $data['vrPago'] ?? 0);
        $feeValue = Utilitarios::removeMaskMoney($data['feeValue'] ?? $data['vrTaxa'] ?? 0);
        $discountValue = Utilitarios::removeMaskMoney($data['discountValue'] ?? $data['vrDesconto'] ?? 0);
        $interestValue = Utilitarios::removeMaskMoney($data['interestValue'] ?? $data['vrJuros'] ?? 0);

        $entity = (new self)
            ->id((string)($data['id'] ?? 0))
            ->description((string)($data['description'] ?? ''))
            ->tenantId((string)($data['tenantId'] ?? ''))
            ->userId((string)($data['userId'] ?? ''))
            ->userUpdateId((string)($data['userId'] ?? ''))
            ->active((string)($data['active'] ?? 'yes'))
            ->branchId((string)($data['filial_id'] ?? $data['branchId'] ?? ''))
            ->document((string) ($data['document'] ?? $data['documento'] ?? ''))
            ->originalDueDate((string) ($data['originalDueDate'] ?? $data['dtVencimentoOriginal'] ?? ''))
            ->dueDate((string) ($data['dueDate'] ?? $data['dtVencimento'] ?? ''))
            ->paymentDate((string) ($data['paymentDate'] ?? $data['dtPagamento'] ?? ''))
            ->clearanceDate((string) ($data['clearanceDate'] ?? $data['dtBaixa'] ?? ''))
            ->reversalDescription((string) ($data['reversalDescription'] ?? $data['ds_estorno'] ?? ''))
            ->receivableAccountId((string) ($data['receivableAccountId'] ?? $data['conta_receber_id'] ?? ''))
            ->reversalPersonId((string) ($data['reversalPersonId'] ?? $data['pessoa_estorno_id'] ?? ''))
            ->clearancePersonId((string) ($data['clearancePersonId'] ?? $data['pessoa_baixa_id'] ?? ''))
            ->refundPersonId((string) ($data['refundPersonId'] ?? $data['pessoa_devolucao_id'] ?? ''))
            ->cashboxId((string) ($data['cashboxId'] ?? $data['caixa_id'] ?? ''))
            ->clearanceType((string) ($data['clearanceType'] ?? $data['tpBaixa'] ?? ''))
            ->clearanceHash((string) ($data['clearanceHash'] ?? $data['rashBaixa'] ?? ''))
            ->grossValue((string) $grossValue)
            ->netValue((string) $netValue)
            ->returnedValue((string) $returnedValue)
            ->paidValue((string) $paidValue)
            ->feeValue((string) $feeValue)
            ->discountValue((string) $discountValue)
            ->interestValue((string) $interestValue)
            ->responsibleId((string) ($data['responsibleId'] ?? $data['responsavel_id'] ?? ''))
            ->isImportedData((string) ($data['isImportedData'] ?? $data['importacao_dados'] ?? ''))
            ->paymentMethodId((string) ($data['paymentMethodId'] ??  $data['forma_pagamentos_id'] ?? $data['forma_pagamento_id'] ?? ''))
            ->paymentPlanId((string) ($data['paymentPlanId'] ?? $data['plano_pagamento_id'] ?? ''))
            ->financialOperatorId((string) ($data['financialOperatorId'] ?? $data['operador_financeiro_id'] ?? ''))
            ->status((string) ($data['status'] ?? ''));

        return $entity;
    }

    public function getDataProperties(): array
    {
        $data = [
            'id' => (string)($this->id ?? ''),
            'description' => (string)($this->description ?? ''),
            'tenantId' => (string)($this->tenantId ?? ''),
            'userId' => (string)($this->userId ?? ''),
            'userUpdateId' => (string)($this->userUpdateId ?? ''),
            'active' => (string)($this->active ?? ''),
            'branchId' => (string)($this->branchId ?? ''),
            'document' => (string) ($this->document ?? ''),
            'originalDueDate' => (string) ($this->originalDueDate ?? ''),
            'dueDate' => (string) ($this->dueDate ?? ''),
            'grossValue' => (string) ($this->grossValue ?? ''),
            'netValue' => (string) ($this->netValue ?? ''),
            'returnedValue' => (string) ($this->returnedValue ?? ''),
            'paidValue' => (string) ($this->paidValue ?? ''),
            'feeValue' => (string) ($this->feeValue ?? ''),
            'discountValue' => (string) ($this->discountValue ?? ''),
            'interestValue' => (string) ($this->interestValue ?? ''),
            'responsibleId' => (string) ($this->responsibleId ?? ''),
            'isImportedData' => (string) ($this->isImportedData ?? ''),
            'paymentMethodId' => (string) ($this->paymentMethodId ?? ''),
            'paymentPlanId' => (string) ($this->paymentPlanId ?? ''),
            'financialOperatorId' => (string) ($this->financialOperatorId ?? ''),
            'status' => (string) ($this->status ?? ''),
            'userId' => (string) ($this->userId ?? ''),
            'userUpdateId' => (string) ($this->userUpdateId ?? ''),
            'tenantId' => (string) ($this->tenantId ?? ''),
            'active' => (string) ($this->active ?? ''),
            'branchId' => (string) ($this->branchId ?? ''),
            'paymentDate' => (string) ($this->paymentDate ?? ''),
            'clearanceDate' => (string) ($this->clearanceDate ?? ''),
            'reversalDescription' => (string) ($this->reversalDescription ?? ''),
            'receivableAccountId' => (string) ($this->receivableAccountId ?? ''),
            'reversalPersonId' => (string) ($this->reversalPersonId ?? ''),
            'clearancePersonId' => (string) ($this->clearancePersonId ?? ''),
            'refundPersonId' => (string) ($this->refundPersonId ?? ''),
            'cashboxId' => (string) ($this->cashboxId ?? ''),
            'clearanceType' => (string) ($this->clearanceType ?? ''),
            'clearanceHash' => (string) ($this->clearanceHash ?? ''),
        ];

        return array_filter($data, function ($value) {
            return $value !== null && !empty($value);
        });
    }
}
