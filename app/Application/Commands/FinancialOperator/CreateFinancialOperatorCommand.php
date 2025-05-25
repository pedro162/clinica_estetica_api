<?php

namespace App\Application\Commands\FinancialOperator;

use App\Utilitarios;
use Exception;

class CreateFinancialOperatorCommand
{
    protected string $id;
    protected string $userId;
    protected string $userUpdateId;
    protected string $tenantId;
    protected string $active;
    protected string $branchId;
    protected string $tariffValue;
    protected string $discountValue;
    protected string $discountPercentage;
    protected string $currentRemittanceNumber;
    protected string $ourNumber;
    protected string $protestDaysQuantity;
    protected string $assumeDuplicata;
    protected string $boletoUpdateLocationType;
    protected string $isDefault;
    protected string $isReleased;
    protected string $personId;

    public function id(string $id): CreateFinancialOperatorCommand
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id ?? null;
    }

    public function tenantId(string $tenantId): CreateFinancialOperatorCommand
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function getTenantId(): ?string
    {
        return $this->tenantId ?? null;
    }

    public function userId(string $userId): CreateFinancialOperatorCommand
    {
        $this->userId = $userId;
        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->userId ?? null;
    }

    public function userUpdateId(string $userUpdateId): CreateFinancialOperatorCommand
    {
        $this->userUpdateId = $userUpdateId;
        return $this;
    }

    public function getUserUpdateId(): ?string
    {
        return $this->userUpdateId ?? null;
    }

    public function active(string $active): CreateFinancialOperatorCommand
    {
        $this->active = $active;
        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active ?? null;
    }

    public function branchId(string $branchId): CreateFinancialOperatorCommand
    {
        $this->branchId = $branchId;
        return $this;
    }

    public function getBranchId(): ?string
    {
        return $this->branchId ?? null;
    }

    public function tariffValue(string $tariffValue): CreateFinancialOperatorCommand
    {
        $this->tariffValue = $tariffValue;
        return $this;
    }

    public function getTariffValue(): ?string
    {
        return $this->tariffValue ?? null;
    }

    public function discountValue(string $discountValue): CreateFinancialOperatorCommand
    {
        $this->discountValue = $discountValue;
        return $this;
    }

    public function getDiscountValue(): ?string
    {
        return $this->discountValue ?? null;
    }

    public function discountPercentage(string $discountPercentage): CreateFinancialOperatorCommand
    {
        $this->discountPercentage = $discountPercentage;
        return $this;
    }

    public function getDiscountPercentage(): ?string
    {
        return $this->discountPercentage ?? null;
    }

    public function currentRemittanceNumber(string $currentRemittanceNumber): CreateFinancialOperatorCommand
    {
        $this->currentRemittanceNumber = $currentRemittanceNumber;
        return $this;
    }

    public function getCurrentRemittanceNumber(): ?string
    {
        return $this->currentRemittanceNumber ?? null;
    }

    public function ourNumber(string $ourNumber): CreateFinancialOperatorCommand
    {
        $this->ourNumber = $ourNumber;
        return $this;
    }

    public function getOurNumber(): ?string
    {
        return $this->ourNumber ?? null;
    }

    public function protestDaysQuantity(string $protestDaysQuantity): CreateFinancialOperatorCommand
    {
        $this->protestDaysQuantity = $protestDaysQuantity;
        return $this;
    }

    public function getProtestDaysQuantity(): ?string
    {
        return $this->protestDaysQuantity ?? null;
    }

    public function assumeDuplicata(string $assumeDuplicata): CreateFinancialOperatorCommand
    {
        $this->assumeDuplicata = $assumeDuplicata;
        return $this;
    }

    public function getAssumeDuplicata(): ?string
    {
        return $this->assumeDuplicata ?? null;
    }

    public function boletoUpdateLocationType(string $boletoUpdateLocationType): CreateFinancialOperatorCommand
    {
        $this->boletoUpdateLocationType = $boletoUpdateLocationType;
        return $this;
    }

    public function getBoletoUpdateLocationType(): ?string
    {
        return $this->boletoUpdateLocationType ?? null;
    }

    public function isDefault(string $isDefault): CreateFinancialOperatorCommand
    {
        $this->isDefault = $isDefault;
        return $this;
    }

    public function getIsDefault(): ?string
    {
        return $this->isDefault ?? null;
    }

    public function isReleased(string $isReleased): CreateFinancialOperatorCommand
    {
        $this->isReleased = $isReleased;
        return $this;
    }

    public function getIsReleased(): ?string
    {
        return $this->isReleased ?? null;
    }

    public function personId(string $personId): CreateFinancialOperatorCommand
    {
        $this->personId = $personId;
        return $this;
    }

    public function getPersonId(): ?string
    {
        return $this->personId ?? null;
    }

    public static function build(array $data): CreateFinancialOperatorCommand
    {
        $entity = (new self());
        $mapping = [
            ['keys' => ['id'], 'callback' => fn($value) => $entity->id($value)],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn($value) => $entity->tenantId((string)$value)],
            ['keys' => ['active'], 'callback' => fn($value) => $entity->active((string)$value)],
            ['keys' => ['userId', 'user_id'], 'callback' => fn($value) => $entity->userId((string)$value)],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn($value) => $entity->userUpdateId((string)$value)],
            ['keys' => ['branchId', 'branch_id', 'filial_id'], 'callback' => fn($value) => $entity->branchId((string)$value)],
            ['keys' => ['tariffValue', 'vrTarifa'], 'callback' => fn($value) => $entity->tariffValue((string)$value)],
            ['keys' => ['discountValue', 'vrDesconto'], 'callback' => fn($value) => $entity->discountValue((string)$value)],
            ['keys' => ['discountPercentage', 'vrPorcentagemDesconto'], 'callback' => fn($value) => $entity->discountPercentage((string)$value)],
            ['keys' => ['currentRemittanceNumber', 'nrRemessaAtual'], 'callback' => fn($value) => $entity->currentRemittanceNumber((string)$value)],
            ['keys' => ['ourNumber', 'nrNossoNumero'], 'callback' => fn($value) => $entity->ourNumber((string)$value)],
            ['keys' => ['protestDaysQuantity', 'qtdDiasProtesto'], 'callback' => fn($value) => $entity->protestDaysQuantity((string)$value)],
            ['keys' => ['assumeDuplicata', 'isAssumeDuplicata'], 'callback' => fn($value) => $entity->assumeDuplicata((string)$value)],
            ['keys' => ['boletoUpdateLocationType', 'tpLocalAtualizacaoBoleto'], 'callback' => fn($value) => $entity->boletoUpdateLocationType((string)$value)],
            ['keys' => ['isDefault', 'isPadrao'], 'callback' => fn($value) => $entity->isDefault((string)$value)],
            ['keys' => ['isReleased', 'isLiberado'], 'callback' => fn($value) => $entity->isReleased((string)$value)],
            ['keys' => ['personId', 'pessoa_id'], 'callback' => fn($value) => $entity->personId((string)$value)],
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

    public function getDataProperties(): array
    {
        $data = [
            'id' => $this->id ?? '',
            'tenantId' => $this->tenantId ?? '',
            'userId' => $this->userId ?? '',
            'userUpdateId' => $this->userUpdateId ?? '',
            'active' => $this->active ?? '',
            'branchId' => $this->branchId ?? '',
            'tariffValue' => $this->tariffValue ?? '',
            'discountValue' => $this->discountValue ?? '',
            'discountPercentage' => $this->discountPercentage ?? '',
            'currentRemittanceNumber' => $this->currentRemittanceNumber ?? '',
            'ourNumber' => $this->ourNumber ?? '',
            'protestDaysQuantity' => $this->protestDaysQuantity ?? '',
            'assumeDuplicata' => $this->assumeDuplicata ?? '',
            'boletoUpdateLocationType' => $this->boletoUpdateLocationType ?? '',
            'isDefault' => $this->isDefault ?? '',
            'isReleased' => $this->isReleased ?? '',
            'personId' => $this->personId ?? '',
        ];

        return array_filter($data, fn($value) => $value !== null && !empty($value));
    }
}
