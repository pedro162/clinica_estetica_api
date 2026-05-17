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
        $entity = (new self());

        $entity->id((string)($data['id'] ?? 0));
        $entity->active((string)($data['active'] ?? 'yes'));

        $mapping = [
            [
                'keys' => ['id'],
                'callback' => fn ($value) => $entity->id((string) $value)
            ],
            [
                'keys' => ['description', 'descricao'],
                'callback' => fn ($value) => $entity->description((string) $value)
            ],
            [
                'keys' => ['tenantId', 'tenant_id'],
                'callback' => fn ($value) => $entity->tenantId((string) $value)
            ],
            [
                'keys' => ['userId', 'user_id'],
                'callback' => fn ($value) => $entity->userId((string) $value)
            ],
            [
                'keys' => ['userUpdateId', 'user_update_id'],
                'callback' => fn ($value) => $entity->userUpdateId((string) $value)
            ],
            [
                'keys' => ['active'],
                'callback' => fn ($value) => $entity->active((string) $value)
            ],
            [
                'keys' => ['branchId', 'filial_id'],
                'callback' => fn ($value) => $entity->branchId((string) $value)
            ],
            [
                'keys' => ['document', 'documento'],
                'callback' => fn ($value) => $entity->document((string) $value)
            ],
            [
                'keys' => ['originalDueDate', 'dtVencimentoOriginal'],
                'callback' => fn ($value) => $entity->originalDueDate((string) $value)
            ],
            [
                'keys' => ['dueDate', 'dtVencimento'],
                'callback' => fn ($value) => $entity->dueDate((string) $value)
            ],
            [
                'keys' => ['grossValue', 'vrBruto'],
                'callback' => fn ($value) => $entity->grossValue((string)
                Utilitarios::removeMaskMoney($value))
            ],
            [
                'keys' => ['netValue', 'vrLiquido'],
                'callback' => fn ($value) => $entity->netValue((string)
                Utilitarios::removeMaskMoney($value))
            ],
            [
                'keys' => ['returnedValue', 'vrDevolvido'],
                'callback' => fn ($value) => $entity->returnedValue((string)
                Utilitarios::removeMaskMoney($value))
            ],
            [
                'keys' => ['paidValue', 'vrPago'],
                'callback' => fn ($value) => $entity->paidValue((string)
                Utilitarios::removeMaskMoney($value))
            ],
            [
                'keys' => ['feeValue', 'vrTaxa'],
                'callback' => fn ($value) => $entity->feeValue((string)
                Utilitarios::removeMaskMoney($value))
            ],
            [
                'keys' => ['discountValue', 'vrDesconto'],
                'callback' => fn ($value) => $entity->discountValue((string)
                Utilitarios::removeMaskMoney($value))
            ],
            [
                'keys' => ['interestValue', 'vrJuros'],
                'callback' => fn ($value) => $entity->interestValue((string)
                Utilitarios::removeMaskMoney($value))
            ],
            [
                'keys' => ['responsibleId', 'responsavel_id'],
                'callback' => fn ($value) => $entity->responsibleId((string) $value)
            ],
            [
                'keys' => ['isImportedData', 'importacao_dados'],
                'callback' => fn ($value) => $entity->isImportedData((string) $value)
            ],
            [
                'keys' => ['paymentMethodId', 'forma_pagamento_id', 'forma_pagamentos_id'],
                'callback' => fn ($value) => $entity->paymentMethodId((string) $value)
            ],
            [
                'keys' => ['paymentPlanId', 'plano_pagamento_id'],
                'callback' => fn ($value) => $entity->paymentPlanId((string) $value)
            ],
            [
                'keys' => ['financialOperatorId', 'operador_financeiro_id'],
                'callback' => fn ($value) => $entity->financialOperatorId((string) $value)
            ],
            [
                'keys' => ['status'],
                'callback' => fn ($value) => $entity->status((string) $value)
            ],
            [
                'keys' => ['personId', 'pessoa_id'],
                'callback' => fn ($value) => $entity->personId((string) $value)
            ],
            [
                'keys' => ['reference', 'referencia'],
                'callback' => fn ($value) => $entity->reference((string) $value)
            ],
            [
                'keys' => ['referenceId', 'referencia_id'],
                'callback' => fn ($value) => $entity->referenceId((string) $value)
            ],
        ];

        foreach ($mapping as $map) {
            foreach ($map['keys'] as $key) {
                if (array_key_exists($key, $data) && $data[$key] !== null) {
                    $map['callback']($data[$key]);
                    break;
                }
            }
        }

        if (!$entity->getUserUpdateId() && $entity->getUserId()) {
            $entity->userUpdateId($entity->getUserId());
        }

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
            return $value !== null && $value !== '';
        });
    }
}
