<?php

namespace App\Domain\PaymentMethod\Entities;

use App\Caixa;
use App\Domain\BaseEntity\Entities\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodAcceptTransfer;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodBalance;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodBalanceType;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodBlockStatus;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodBranchId;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodId;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodMaxValue;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodMinValue;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodName;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodOpenStatus;
use App\Domain\PaymentMethod\ValueObjects\PaymentMethodType;

class PaymentMethod extends BaseEntity
{
    protected PaymentMethodId $id;
    protected PaymentMethodName $name;
    protected PaymentMethodType $type;
    protected PaymentMethodMinValue $minValue;
    protected PaymentMethodMaxValue $maxValue;
    protected PaymentMethodBalanceType $balanceType;
    protected PaymentMethodBlockStatus $blockStatus;
    protected PaymentMethodOpenStatus $openStatus;
    protected PaymentMethodAcceptTransfer $acceptTransfer;
    protected PaymentMethodBalance $balance;
    protected PaymentMethodBranchId $branchId;

    public function id(PaymentMethodId $id): PaymentMethod
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?PaymentMethodId
    {
        return $this->id ?? null;
    }

    public function branchId(PaymentMethodBranchId $branchId): PaymentMethod
    {
        $this->branchId = $branchId;
        return $this;
    }

    public function getBranchId(): ?PaymentMethodBranchId
    {
        return $this->branchId ?? null;
    }

    public function name(PaymentMethodName $name): PaymentMethod
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?PaymentMethodName
    {
        return $this->name ?? null;
    }

    public function type(PaymentMethodType $type): PaymentMethod
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): ?PaymentMethodType
    {
        return $this->type ?? null;
    }

    public function minValue(PaymentMethodMinValue $minValue): PaymentMethod
    {
        $this->minValue = $minValue;
        return $this;
    }

    public function getMinValue(): ?PaymentMethodMinValue
    {
        return $this->minValue ?? null;
    }

    public function maxValue(PaymentMethodMaxValue $maxValue): PaymentMethod
    {
        $this->maxValue = $maxValue;
        return $this;
    }

    public function getMaxValue(): ?PaymentMethodMaxValue
    {
        return $this->maxValue ?? null;
    }

    public function balanceType(PaymentMethodBalanceType $balanceType): PaymentMethod
    {
        $this->balanceType = $balanceType;
        return $this;
    }

    public function getBalanceType(): ?PaymentMethodBalanceType
    {
        return $this->balanceType ?? null;
    }

    public function blockStatus(PaymentMethodBlockStatus $blockStatus): PaymentMethod
    {
        $this->blockStatus = $blockStatus;
        return $this;
    }

    public function getBlockStatus(): ?PaymentMethodBlockStatus
    {
        return $this->blockStatus ?? null;
    }

    public function openStatus(PaymentMethodOpenStatus $openStatus): PaymentMethod
    {
        $this->openStatus = $openStatus;
        return $this;
    }

    public function getOpenStatus(): ?PaymentMethodBlockStatus
    {
        return $this->openStatus ?? null;
    }

    public function acceptTransfer(PaymentMethodAcceptTransfer $acceptTransfer): PaymentMethod
    {
        $this->acceptTransfer = $acceptTransfer;
        return $this;
    }

    public function getAcceptTransfer(): ?PaymentMethodAcceptTransfer
    {
        return $this->acceptTransfer ?? null;
    }

    public function balance(PaymentMethodBalance $balance): PaymentMethod
    {
        $this->balance = $balance;
        return $this;
    }

    public function getBalance(): ?PaymentMethodBalance
    {
        return $this->balance ?? null;
    }

    public static function buildEntity(array $data): PaymentMethod
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
            ->id(new PaymentMethodId($id))
            ->name(new PaymentMethodName((string)($data['nmCidade'] ?? $data['name'] ?? '')))
            ->tenantId(new BaseEntityTenantId($tenantId))
            ->active(((string)($data['active'] ?? '')))
            ->userId(new BaseEntityUserId($userId))
            ->userUpdateId(new BaseEntityUserId($userUpdateId))
            ->type(new PaymentMethodType((string)$type))
            ->minValue(new PaymentMethodMinValue((float) $minValue))
            ->maxValue(new PaymentMethodMaxValue((float) $maxValue))
            ->balanceType(new PaymentMethodBalanceType((string) $balanceType))
            ->balance(new PaymentMethodBalance((float) $balance))
            ->blockStatus(new PaymentMethodBlockStatus((string) $blockStatus))
            ->openStatus(new PaymentMethodOpenStatus((string) $openStatus))
            ->acceptTransfer(new PaymentMethodAcceptTransfer((string) $acceptTransfer))
            ->branchId(new PaymentMethodBranchId($branchId));

        return $entity;
    }

    public function build(): Caixa
    {
        $data = [
            'id' => isset($this->id) ? (string)$this->id : null,
            'filial_id' => isset($this->branchId) ? (string)$this->branchId : null,
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
