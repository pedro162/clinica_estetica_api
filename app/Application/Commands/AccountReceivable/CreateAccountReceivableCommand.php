<?php

namespace App\Application\Commands\AccountReceivable;

use App\Utilitarios;

class CreateAccountReceivableCommand
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
    protected string $personId;
    protected string $reference;
    protected string $referenceId;

    public function id(string $id): CreateAccountReceivableCommand
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id ?? null;
    }

    public function reference(string $reference): CreateAccountReceivableCommand
    {
        $this->reference = $reference;
        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference ?? null;
    }

    public function referenceId(string $referenceId): CreateAccountReceivableCommand
    {
        $this->referenceId = $referenceId;
        return $this;
    }

    public function getReferenceId(): ?string
    {
        return $this->referenceId ?? null;
    }

    public function tenantId(string $tenantId): CreateAccountReceivableCommand
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function getTenantId(): ?string
    {
        return $this->tenantId ?? null;
    }

    public function description(string $description): CreateAccountReceivableCommand
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description ?? null;
    }

    public function userId(string $userId): CreateAccountReceivableCommand
    {
        $this->userId = $userId;
        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->userId ?? null;
    }

    public function userUpdateId(string $userUpdateId): CreateAccountReceivableCommand
    {
        $this->userUpdateId = $userUpdateId;
        return $this;
    }

    public function getUserUpdateId(): ?string
    {
        return $this->userUpdateId ?? null;
    }

    public function active(string $active): CreateAccountReceivableCommand
    {
        $this->active = $active;
        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active ?? null;
    }

    public function branchId(string $branchId): CreateAccountReceivableCommand
    {
        $this->branchId = $branchId;
        return $this;
    }

    public function getBranchId(): ?string
    {
        return $this->branchId ?? null;
    }

    public function document(string $document): CreateAccountReceivableCommand
    {
        $this->document = $document;
        return $this;
    }

    public function getDocument(): ?string
    {
        return $this->document ?? null;
    }

    public function originalDueDate(string $originalDueDate): CreateAccountReceivableCommand
    {
        $this->originalDueDate = $originalDueDate;
        return $this;
    }

    public function getOriginalDueDate(): ?string
    {
        return $this->originalDueDate ?? null;
    }

    public function dueDate(string $dueDate): CreateAccountReceivableCommand
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    public function getDueDate(): ?string
    {
        return $this->dueDate ?? null;
    }

    public function grossValue(string $grossValue): CreateAccountReceivableCommand
    {
        $this->grossValue = $grossValue;
        return $this;
    }

    public function getGrossValue(): ?string
    {
        return $this->grossValue ?? null;
    }

    public function netValue(string $netValue): CreateAccountReceivableCommand
    {
        $this->netValue = $netValue;
        return $this;
    }

    public function getNetValue(): ?string
    {
        return $this->netValue ?? null;
    }

    public function returnedValue(string $returnedValue): CreateAccountReceivableCommand
    {
        $this->returnedValue = $returnedValue;
        return $this;
    }

    public function getReturnedValue(): ?string
    {
        return $this->returnedValue ?? null;
    }

    public function paidValue(string $paidValue): CreateAccountReceivableCommand
    {
        $this->paidValue = $paidValue;
        return $this;
    }

    public function getPaidValue(): ?string
    {
        return $this->paidValue ?? null;
    }

    public function feeValue(string $feeValue): CreateAccountReceivableCommand
    {
        $this->feeValue = $feeValue;
        return $this;
    }

    public function getFeeValue(): ?string
    {
        return $this->feeValue ?? null;
    }

    public function discountValue(string $discountValue): CreateAccountReceivableCommand
    {
        $this->discountValue = $discountValue;
        return $this;
    }

    public function getDiscountValue(): ?string
    {
        return $this->discountValue ?? null;
    }

    public function interestValue(string $interestValue): CreateAccountReceivableCommand
    {
        $this->interestValue = $interestValue;
        return $this;
    }

    public function getInterestValue(): ?string
    {
        return $this->interestValue ?? null;
    }

    public function responsibleId(string $responsibleId): CreateAccountReceivableCommand
    {
        $this->responsibleId = $responsibleId;
        return $this;
    }

    public function getResponsibleId(): ?string
    {
        return $this->responsibleId ?? null;
    }

    public function isImportedData(string $isImportedData): CreateAccountReceivableCommand
    {
        $this->isImportedData = $isImportedData;
        return $this;
    }

    public function getIsImportedData(): ?string
    {
        return $this->isImportedData ?? null;
    }

    public function paymentMethodId(string $paymentMethodId): CreateAccountReceivableCommand
    {
        $this->paymentMethodId = $paymentMethodId;
        return $this;
    }

    public function getPaymentMethodId(): ?string
    {
        return $this->paymentMethodId ?? null;
    }

    public function paymentPlanId(string $paymentPlanId): CreateAccountReceivableCommand
    {
        $this->paymentPlanId = $paymentPlanId;
        return $this;
    }

    public function getPaymentPlanId(): ?string
    {
        return $this->paymentPlanId ?? null;
    }

    public function financialOperatorId(string $financialOperatorId): CreateAccountReceivableCommand
    {
        $this->financialOperatorId = $financialOperatorId;
        return $this;
    }

    public function getFinancialOperatorId(): ?string
    {
        return $this->financialOperatorId ?? null;
    }

    public function status(string $status): CreateAccountReceivableCommand
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status ?? null;
    }

    public function personId(string $personId): CreateAccountReceivableCommand
    {
        $this->personId = $personId;
        return $this;
    }

    public function getPersonId(): ?string
    {
        return $this->personId ?? null;
    }

    public static function build(array $data): CreateAccountReceivableCommand
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
            ->description((string)($data['description'] ?? $data['descricao'] ?? ''))
            ->tenantId((string)($data['tenantId'] ?? ''))
            ->userId((string)($data['userId'] ?? $data['user_id'] ?? ''))
            ->userUpdateId((string)($data['userUpdateId'] ?? $data['user_update_id'] ?? ''))
            ->active((string)($data['active'] ?? 'yes'))
            ->branchId((string)($data['filial_id'] ?? $data['branchId'] ?? ''))
            ->document((string) ($data['document'] ?? $data['documento'] ?? ''))
            ->originalDueDate((string) ($data['originalDueDate'] ?? $data['dtVencimentoOriginal'] ?? ''))
            ->dueDate((string) ($data['dueDate'] ?? $data['dtVencimento'] ?? ''))
            ->grossValue((string) $grossValue)
            ->netValue((string) $netValue)
            ->returnedValue((string) $returnedValue)
            ->paidValue((string) $paidValue)
            ->feeValue((string) $feeValue)
            ->discountValue((string) $discountValue)
            ->interestValue((string) $interestValue)
            ->responsibleId((string) ($data['responsibleId'] ?? $data['responsavel_id'] ?? ''))
            ->isImportedData((string) ($data['isImportedData'] ?? $data['importacao_dados'] ?? ''))
            ->paymentMethodId((string) ($data['paymentMethodId'] ?? $data['forma_pagamento_id'] ?? ''))
            ->paymentPlanId((string) ($data['paymentPlanId'] ?? $data['plano_pagamento_id'] ?? ''))
            ->financialOperatorId((string) ($data['financialOperatorId'] ?? $data['operador_financeiro_id'] ?? ''))
            ->status((string) ($data['status'] ?? ''))
            ->personId((string) ($data['personId'] ?? $data['pessoa_id'] ?? 0))
            ->reference((string) ($data['reference'] ?? $data['referencia'] ?? 0))
            ->referenceId((string) ($data['referenceId'] ?? $data['referencia_id'] ?? 0));

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
            'personId' => (string) ($this->personId ?? ''),
            'reference' => (string) ($this->reference ?? ''),
            'referenceId' => (string) ($this->referenceId ?? ''),
        ];

        return array_filter($data, function ($value) {
            return $value !== null && !empty($value);
        });
    }
}
