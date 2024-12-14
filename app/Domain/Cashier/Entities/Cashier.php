<?php

namespace App\Domain\Cashier\Entities;

use App\Caixa;
use App\Domain\BaseEntity\Entities\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\Cashier\ValueObjects\CashierAcceptTransfer;
use App\Domain\Cashier\ValueObjects\CashierBalance;
use App\Domain\Cashier\ValueObjects\CashierBalanceType;
use App\Domain\Cashier\ValueObjects\CashierBlockStatus;
use App\Domain\Cashier\ValueObjects\CashierBranchId;
use App\Domain\Cashier\ValueObjects\CashierId;
use App\Domain\Cashier\ValueObjects\CashierMaxValue;
use App\Domain\Cashier\ValueObjects\CashierMinValue;
use App\Domain\Cashier\ValueObjects\CashierName;
use App\Domain\Cashier\ValueObjects\CashierOpenStatus;
use App\Domain\Cashier\ValueObjects\CashierType;

class Cashier extends BaseEntity
{
    protected CashierId $id;
    protected CashierName $name;
    protected CashierType $type;
    protected CashierMinValue $minValue;
    protected CashierMaxValue $maxValue;
    protected CashierBalanceType $balanceType;
    protected CashierBlockStatus $blockStatus;
    protected CashierOpenStatus $openStatus;
    protected CashierAcceptTransfer $acceptTransfer;
    protected CashierBalance $balance;
    protected CashierBranchId $branchId;

    public function id(CashierId $id): Cashier
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?CashierId
    {
        return $this->id ?? null;
    }

    public function branchId(CashierBranchId $branchId): Cashier
    {
        $this->branchId = $branchId;
        return $this;
    }

    public function getBranchId(): ?CashierBranchId
    {
        return $this->branchId ?? null;
    }

    public function name(CashierName $name): Cashier
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?CashierName
    {
        return $this->name ?? null;
    }

    public function type(CashierType $type): Cashier
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): ?CashierType
    {
        return $this->type ?? null;
    }

    public function minValue(CashierMinValue $minValue): Cashier
    {
        $this->minValue = $minValue;
        return $this;
    }

    public function getMinValue(): ?CashierMinValue
    {
        return $this->minValue ?? null;
    }

    public function maxValue(CashierMaxValue $maxValue): Cashier
    {
        $this->maxValue = $maxValue;
        return $this;
    }

    public function getMaxValue(): ?CashierMaxValue
    {
        return $this->maxValue ?? null;
    }

    public function balanceType(CashierBalanceType $balanceType): Cashier
    {
        $this->balanceType = $balanceType;
        return $this;
    }

    public function getBalanceType(): ?CashierBalanceType
    {
        return $this->balanceType ?? null;
    }

    public function blockStatus(CashierBlockStatus $blockStatus): Cashier
    {
        $this->blockStatus = $blockStatus;
        return $this;
    }

    public function getBlockStatus(): ?CashierBlockStatus
    {
        return $this->blockStatus ?? null;
    }

    public function openStatus(CashierOpenStatus $openStatus): Cashier
    {
        $this->openStatus = $openStatus;
        return $this;
    }

    public function getOpenStatus(): ?CashierBlockStatus
    {
        return $this->openStatus ?? null;
    }

    public function acceptTransfer(CashierAcceptTransfer $acceptTransfer): Cashier
    {
        $this->acceptTransfer = $acceptTransfer;
        return $this;
    }

    public function getAcceptTransfer(): ?CashierAcceptTransfer
    {
        return $this->acceptTransfer ?? null;
    }

    public function balance(CashierBalance $balance): Cashier
    {
        $this->balance = $balance;
        return $this;
    }

    public function getBalance(): ?CashierBalance
    {
        return $this->balance ?? null;
    }

    public static function buildEntity(array $data): Cashier
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

        $type = $data['type'] ?? '';
        $minValue = $data['minValue'] ?? $data['vrMin'] ?? 0;
        $maxValue = $data['maxValue'] ?? $data['vrMax'] ?? 0;
        $balanceType = $data['balanceType'] ?? $data['tpSaldo'] ?? '';
        $balance = $data['balance'] ?? $data['vrSaldo'] ?? 0;
        $blockStatus = $data['blockStatus'] ?? $data['status_bloqueio'] ?? '';
        $openStatus = $data['openStatus'] ?? $data['status_abertura'] ?? '';
        $acceptTransfer = $data['acceptTransfer'] ?? $data['aceita_transferencia'] ?? '';

        $branchId = (string) ($data['branchId'] ?? $data['filial_id'] ?? 0);

        $entity = (new self())
            ->id(new CashierId($id))
            ->name(new CashierName((string)($data['nmCidade'] ?? $data['name'] ?? '')))
            ->tenantId(new BaseEntityTenantId($tenantId))
            ->active(((string)($data['active'] ?? '')))
            ->userId(new BaseEntityUserId($userId))
            ->userUpdateId(new BaseEntityUserId($userUpdateId))
            ->type(new CashierType((string)$type))
            ->minValue(new CashierMinValue((float) $minValue))
            ->maxValue(new CashierMaxValue((float) $maxValue))
            ->balanceType(new CashierBalanceType((string) $balanceType))
            ->balance(new CashierBalance((float) $balance))
            ->blockStatus(new CashierBlockStatus((string) $blockStatus))
            ->openStatus(new CashierOpenStatus((string) $openStatus))
            ->acceptTransfer(new CashierAcceptTransfer((string) $acceptTransfer))
            ->branchId(new CashierBranchId($branchId));

        return $entity;
    }

    public function build(): Caixa
    {
        $data = [
            'id' => isset($this->id) ? (string)$this->id : null,
            'branchId' => isset($this->branchId) ? (string)$this->branchId : null,
            'name' => isset($this->name) ? (string)$this->name : null,
            'vrMin' => isset($this->minValue) ? (string)$this->minValue : null,
            'vrMax' => isset($this->maxValue) ? (string)$this->maxValue : null,
            'vrSaldo' => isset($this->balance) ? (string)$this->balance : null,
            'tpSaldo' => isset($this->balanceType) ? (string)$this->balanceType : null,
            'status_abertura' => isset($this->openStatus) ? (string)$this->openStatus : null,
            'status_bloqueio' => isset($this->blockStatus) ? (string)$this->blockStatus : null,
            'aceita_transferencia' => isset($this->acceptTransfer) ? (string)$this->acceptTransfer : null,
            'tenant_id' => isset($this->tenantId) ? (string)$this->tenantId : null,
            'active' => isset($this->active) ? (string)$this->active : null,
            'user_id' => isset($this->userId) ? (string)$this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string)$this->userUpdateId : null,
        ];

        $data = array_filter($data, function ($value) {
            return $value !== null;
        });

        return new Caixa($data);
    }
}
