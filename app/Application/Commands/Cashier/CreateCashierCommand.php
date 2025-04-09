<?php

namespace App\Application\Commands\Cashier;

use App\Utilitarios;
use Exception;

class CreateCashierCommand
{

    protected string $id;
    protected string $name;
    protected string $type;
    protected string $userId;
    protected string $userUpdateId;
    protected string $tenantId;
    protected string $openStatus;
    protected string $active;
    protected string $blockStatus;
    protected float $minValue;
    protected float $maxValue;
    protected float $balance;
    protected string $acceptTransfer;
    protected string $balanceType;
    protected string $branchId;


    public function id(string $id): CreateCashierCommand
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id ?? null;
    }

    public function minValue(float $minValue): CreateCashierCommand
    {
        $this->minValue = $minValue;
        return $this;
    }

    public function getMinValue(): ?float
    {
        return $this->minValue ?? null;
    }

    public function maxValue(float $maxValue): CreateCashierCommand
    {
        $this->maxValue = $maxValue;
        return $this;
    }

    public function getMaxValue(): ?float
    {
        return $this->maxValue ?? null;
    }

    public function balance(float $balance): CreateCashierCommand
    {
        $this->balance = $balance;
        return $this;
    }

    public function getBalance(): ?string
    {
        return $this->balance ?? null;
    }

    public function balanceType(string $balanceType): CreateCashierCommand
    {
        $this->balanceType = $balanceType;
        return $this;
    }

    public function getBalanceType(): ?string
    {
        return $this->balanceType ?? null;
    }

    public function acceptTransfer(string $acceptTransfer): CreateCashierCommand
    {
        $this->acceptTransfer = $acceptTransfer;
        return $this;
    }

    public function getAcceptTransfer(): ?string
    {
        return $this->acceptTransfer ?? null;
    }

    public function tenantId(string $tenantId): CreateCashierCommand
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function getTenantId(): ?string
    {
        return $this->tenantId ?? null;
    }

    public function name(string $name): CreateCashierCommand
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    public function type(string $type): CreateCashierCommand
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type ?? null;
    }

    public function userId(string $userId): CreateCashierCommand
    {
        $this->userId = $userId;
        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->userId ?? null;
    }

    public function userUpdateId(string $userUpdateId): CreateCashierCommand
    {
        $this->userUpdateId = $userUpdateId;
        return $this;
    }

    public function getUserUpdateId(): ?string
    {
        return $this->userUpdateId ?? null;
    }

    public function active(string $active): CreateCashierCommand
    {
        $this->active = $active;
        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active ?? null;
    }

    public function openStatus(string $openStatus): CreateCashierCommand
    {
        $this->openStatus = $openStatus;
        return $this;
    }

    public function getOpenStatus(): ?string
    {
        return $this->openStatus ?? null;
    }

    public function blockStatus(string $blockStatus): CreateCashierCommand
    {
        $this->blockStatus = $blockStatus;
        return $this;
    }

    public function getBlockStatus(): ?string
    {
        return $this->blockStatus ?? null;
    }

    public function branchId(string $branchId): CreateCashierCommand
    {
        $this->branchId = $branchId;
        return $this;
    }

    public function getBranchId(): ?string
    {
        return $this->branchId ?? null;
    }

    public static function build(array $data): CreateCashierCommand
    {
        $minValue = Utilitarios::removeMaskMoney($data['vrMin'] ?? $data['minValue'] ?? 0);
        $maxValue = Utilitarios::removeMaskMoney($data['vrMax'] ?? $data['maxValue'] ?? 0);
        $balance = Utilitarios::removeMaskMoney($data['balance'] ?? $data['vrSaldo'] ?? 0);
        $balanceType = $data['tpSaldo'] ?? $data['balanceType'] ?? '';

        $balanceType = 'positivo';

        if ($balance < 0) {
            $balanceType = 'negativo';
        }

        $entity = (new self)
            ->id((string)($data['id'] ?? 0))
            ->name((string)($data['name'] ?? ''))
            ->type((string)($data['type'] ?? ''))
            ->tenantId((string)($data['tenantId'] ?? $data['tenant_id'] ?? ''))
            ->openStatus((string)($data['status_abertura'] ?? $data['openStatus'] ?? 'close'))
            ->userId((string)($data['userId'] ?? $data['user_id'] ?? \Auth::User()->id))
            ->userUpdateId((string)($data['userUpdateId'] ?? $data['user_update_id'] ?? \Auth::User()->id))
            ->active((string)($data['active'] ?? 'yes'))
            ->blockStatus((string)($data['status_bloqueio'] ?? $data['blockStatus'] ?? 'liberado'))
            ->minValue((float)($minValue))
            ->maxValue((float)($maxValue))
            ->acceptTransfer((string)($data['aceita_transferencia'] ?? $data['acceptTransfer'] ?? ''))
            ->balanceType((string)($balanceType))
            ->branchId((string)($data['filial_id'] ?? $data['branchId'] ?? ''))
            ->balance((float)($balance));

        return $entity;
    }

    public function getDataProperties(): array
    {
        $data = [
            'id' => (string)($this->id ?? ''),
            'name' => (string)($this->name ?? ''),
            'type' => (string)($this->type ?? ''),
            'blockStatus' => (string)($this->blockStatus ?? ''),
            'tenantId' => (string)($this->tenantId ?? ''),
            'openStatus' => (string)($this->openStatus ?? ''),
            'userId' => (string)($this->userId ?? ''),
            'userUpdateId' => (string)($this->userUpdateId ?? ''),
            'active' => (string)($this->active ?? ''),
            'minValue' => (float)($this->minValue ?? 0),
            'maxValue' => (float)($this->maxValue ?? 0),
            'acceptTransfer' => (string)($this->acceptTransfer ?? ''),
            'balanceType' => (string)($this->balanceType ?? ''),
            'balance' => (string)($this->balance ?? ''),
            'branchId' => (string)($this->branchId ?? ''),
        ];

        return array_filter($data, function ($value) {
            return $value !== null && !empty($value);
        });
    }
}
