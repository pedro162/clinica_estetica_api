<?php

namespace App\Domain\FinancialOperator\Entities;

use App\Domain\BaseEntity\Entities\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\FinancialOperator\ValueObjects\FinancialOperatorAssumeDuplicata;
use App\Domain\FinancialOperator\ValueObjects\FinancialOperatorBoletoUpdateLocationType;
use App\Domain\FinancialOperator\ValueObjects\FinancialOperatorBranchId;
use App\Domain\FinancialOperator\ValueObjects\FinancialOperatorCurrentRemittanceNumber;
use App\Domain\FinancialOperator\ValueObjects\FinancialOperatorDiscountPercentage;
use App\Domain\FinancialOperator\ValueObjects\FinancialOperatorDiscountValue;
use App\Domain\FinancialOperator\ValueObjects\FinancialOperatorId;
use App\Domain\FinancialOperator\ValueObjects\FinancialOperatorIsDefault;
use App\Domain\FinancialOperator\ValueObjects\FinancialOperatorIsReleased;
use App\Domain\FinancialOperator\ValueObjects\FinancialOperatorOurNumber;
use App\Domain\FinancialOperator\ValueObjects\FinancialOperatorPersonId;
use App\Domain\FinancialOperator\ValueObjects\FinancialOperatorProtestDaysQuantity;
use App\Domain\FinancialOperator\ValueObjects\FinancialOperatorTariffValue;
use App\OperadorFinanceiro;

class FinancialOperator extends BaseEntity
{
    protected FinancialOperatorId $id;
    protected FinancialOperatorBranchId $branchId;
    protected FinancialOperatorTariffValue $tariffValue;
    protected FinancialOperatorDiscountValue $discountValue;
    protected FinancialOperatorDiscountPercentage $discountPercentage;
    protected FinancialOperatorCurrentRemittanceNumber $currentRemittanceNumber;
    protected FinancialOperatorOurNumber $ourNumber;
    protected FinancialOperatorProtestDaysQuantity $protestDaysQuantity;
    protected FinancialOperatorAssumeDuplicata $assumeDuplicata;
    protected FinancialOperatorBoletoUpdateLocationType $boletoUpdateLocationType;
    protected FinancialOperatorIsDefault $isDefault;
    protected FinancialOperatorIsReleased $isReleased;
    protected FinancialOperatorPersonId $personId;

    public function id(FinancialOperatorId $id): FinancialOperator
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?FinancialOperatorId
    {
        return $this->id ?? null;
    }

    public function branchId(FinancialOperatorBranchId $branchId): FinancialOperator
    {
        $this->branchId = $branchId;
        return $this;
    }

    public function getBranchId(): ?FinancialOperatorBranchId
    {
        return $this->branchId ?? null;
    }

    public function active(string $active): FinancialOperator
    {
        $this->active = $active;
        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active ?? null;
    }

    public function tariffValue(FinancialOperatorTariffValue $tariffValue): FinancialOperator
    {
        $this->tariffValue = $tariffValue;
        return $this;
    }

    public function getTariffValue(): ?FinancialOperatorTariffValue
    {
        return $this->tariffValue ?? null;
    }

    public function discountValue(FinancialOperatorDiscountValue $discountValue): FinancialOperator
    {
        $this->discountValue = $discountValue;
        return $this;
    }

    public function getDiscountValue(): ?FinancialOperatorDiscountValue
    {
        return $this->discountValue ?? null;
    }

    public function discountPercentage(FinancialOperatorDiscountPercentage $discountPercentage): FinancialOperator
    {
        $this->discountPercentage = $discountPercentage;
        return $this;
    }

    public function getDiscountPercentage(): ?FinancialOperatorDiscountPercentage
    {
        return $this->discountPercentage ?? null;
    }

    public function currentRemittanceNumber(FinancialOperatorCurrentRemittanceNumber $currentRemittanceNumber): FinancialOperator
    {
        $this->currentRemittanceNumber = $currentRemittanceNumber;
        return $this;
    }

    public function getCurrentRemittanceNumber(): ?FinancialOperatorCurrentRemittanceNumber
    {
        return $this->currentRemittanceNumber ?? null;
    }

    public function ourNumber(FinancialOperatorOurNumber $ourNumber): FinancialOperator
    {
        $this->ourNumber = $ourNumber;
        return $this;
    }

    public function getOurNumber(): ?FinancialOperatorOurNumber
    {
        return $this->ourNumber ?? null;
    }

    public function protestDaysQuantity(FinancialOperatorProtestDaysQuantity $protestDaysQuantity): FinancialOperator
    {
        $this->protestDaysQuantity = $protestDaysQuantity;
        return $this;
    }

    public function getProtestDaysQuantity(): ?FinancialOperatorProtestDaysQuantity
    {
        return $this->protestDaysQuantity ?? null;
    }

    public function assumeDuplicata(FinancialOperatorAssumeDuplicata $assumeDuplicata): FinancialOperator
    {
        $this->assumeDuplicata = $assumeDuplicata;
        return $this;
    }

    public function getAssumeDuplicata(): ?FinancialOperatorAssumeDuplicata
    {
        return $this->assumeDuplicata ?? null;
    }

    public function boletoUpdateLocationType(FinancialOperatorBoletoUpdateLocationType $boletoUpdateLocationType): FinancialOperator
    {
        $this->boletoUpdateLocationType = $boletoUpdateLocationType;
        return $this;
    }

    public function getBoletoUpdateLocationType(): ?FinancialOperatorBoletoUpdateLocationType
    {
        return $this->boletoUpdateLocationType ?? null;
    }

    public function isDefault(FinancialOperatorIsDefault $isDefault): FinancialOperator
    {
        $this->isDefault = $isDefault;
        return $this;
    }

    public function getIsDefault(): ?FinancialOperatorIsDefault
    {
        return $this->isDefault ?? null;
    }

    public function isReleased(FinancialOperatorIsReleased $isReleased): FinancialOperator
    {
        $this->isReleased = $isReleased;
        return $this;
    }

    public function getIsReleased(): ?FinancialOperatorIsReleased
    {
        return $this->isReleased ?? null;
    }

    public function personId(FinancialOperatorPersonId $personId): FinancialOperator
    {
        $this->personId = $personId;
        return $this;
    }

    public function getPersonId(): ?FinancialOperatorPersonId
    {
        return $this->personId ?? null;
    }

    public static function buildEntity(array $data): FinancialOperator
    {
        $entity = (new self());
        $mapping = [
            ['keys' => ['id'], 'callback' => fn ($value) => $entity->id(new FinancialOperatorId($value))],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn ($value) => $entity->tenantId(new BaseEntityTenantId((string)$value))],
            ['keys' => ['active'], 'callback' => fn ($value) => $entity->active((string)$value)],
            ['keys' => ['userId', 'user_id'], 'callback' => fn ($value) => $entity->userId(new BaseEntityUserId((string)$value))],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn ($value) => $entity->userUpdateId(new BaseEntityUserId((string)$value))],
            ['keys' => ['branchId', 'filial_id'], 'callback' => fn ($value) => $entity->branchId(new FinancialOperatorBranchId((string)$value))],
            ['keys' => ['tariffValue', 'vrTarifa'], 'callback' => fn ($value) => $entity->tariffValue(new FinancialOperatorTariffValue((string)$value))],
            ['keys' => ['discountValue', 'vrDesconto'], 'callback' => fn ($value) => $entity->discountValue(new FinancialOperatorDiscountValue((string)$value))],
            ['keys' => ['discountPercentage', 'vrPorcentagemDesconto'], 'callback' => fn ($value) => $entity->discountPercentage(new FinancialOperatorDiscountPercentage((string)$value))],
            ['keys' => ['currentRemittanceNumber', 'nrRemessaAtual'], 'callback' => fn ($value) => $entity->currentRemittanceNumber(new FinancialOperatorCurrentRemittanceNumber((string)$value))],
            ['keys' => ['ourNumber', 'nrNossoNumero'], 'callback' => fn ($value) => $entity->ourNumber(new FinancialOperatorOurNumber((string)$value))],
            ['keys' => ['protestDaysQuantity', 'qtdDiasProtesto'], 'callback' => fn ($value) => $entity->protestDaysQuantity(new FinancialOperatorProtestDaysQuantity((string)$value))],
            ['keys' => ['assumeDuplicata', 'isAssumeDuplicata'], 'callback' => fn ($value) => $entity->assumeDuplicata(new FinancialOperatorAssumeDuplicata((string)$value))],
            ['keys' => ['boletoUpdateLocationType', 'tpLocalAtualizacaoBoleto'], 'callback' => fn ($value) => $entity->boletoUpdateLocationType(new FinancialOperatorBoletoUpdateLocationType((string)$value))],
            ['keys' => ['isDefault', 'isPadrao'], 'callback' => fn ($value) => $entity->isDefault(new FinancialOperatorIsDefault((string)$value))],
            ['keys' => ['isReleased', 'isLiberado'], 'callback' => fn ($value) => $entity->isReleased(new FinancialOperatorIsReleased((string)$value))],
            ['keys' => ['personId', 'pessoa_id'], 'callback' => fn ($value) => $entity->personId(new FinancialOperatorPersonId((string)$value))],
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

    public function build(): OperadorFinanceiro
    {
        $data = [
            'id' => isset($this->id) ? (string)$this->id : null,
            'filial_id' => isset($this->branchId) ? (string)$this->branchId : null,
            'tenant_id' => isset($this->tenantId) ? (string)$this->tenantId : null,
            'active' => isset($this->active) ? (string)$this->active : null,
            'user_id' => isset($this->userId) ? (string)$this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string)$this->userUpdateId : null,
            'vrTarifa' => isset($this->tariffValue) ? (string)$this->tariffValue : null,
            'vrDesconto' => isset($this->discountValue) ? (string)$this->discountValue : null,
            'vrPorcentagemDesconto' => isset($this->discountPercentage) ? (string)$this->discountPercentage : null,
            'nrRemessaAtual' => isset($this->currentRemittanceNumber) ? (string)$this->currentRemittanceNumber : null,
            'nrNossoNumero' => isset($this->ourNumber) ? (string)$this->ourNumber : null,
            'qtdDiasProtesto' => isset($this->protestDaysQuantity) ? (string)$this->protestDaysQuantity : null,
            'isAssumeDuplicata' => isset($this->assumeDuplicata) ? (string)$this->assumeDuplicata : null,
            'tpLocalAtualizacaoBoleto' => isset($this->boletoUpdateLocationType) ? (string)$this->boletoUpdateLocationType : null,
            'isPadrao' => isset($this->isDefault) ? (string)$this->isDefault : null,
            'isLiberado' => isset($this->isReleased) ? (string)$this->isReleased : null,
            'pessoa_id' => isset($this->personId) ? (string)$this->personId : null,
        ];

        $data = array_filter($data, function ($value) {
            return $value !== null;
        });

        return new OperadorFinanceiro($data);
    }
}
