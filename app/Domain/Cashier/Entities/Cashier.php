<?php

namespace App\Domain\Cashier\Entities;

use App\Caixa;
use App\Domain\BaseEntity\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\Cashier\ValueObjects\CashierId;
use App\Domain\Cashier\ValueObjects\CashierName;

class Cashier extends BaseEntity
{
    protected CashierId $id;
    protected CashierName $name;

    public function id(CashierId $id): Cashier
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?CashierId
    {
        return $this->id ?? null;
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

        $entity = (new self())
            ->id(new CashierId($id))
            ->name(new CashierName((string)($data['nmCidade'] ?? $data['name'] ?? '')))
            ->tenantId(new BaseEntityTenantId($tenantId))
            ->active(((string)($data['active'] ?? '')))
            ->userId(new BaseEntityUserId($userId))
            ->userUpdateId(new BaseEntityUserId($userUpdateId));

        return $entity;
    }

    public function build(): Caixa
    {
        $data = [
            'id' => isset($this->id) ? (string)$this->id : null,
            'nmCidade' => isset($this->name) ? (string)$this->name : null,
            'tenant_id' => isset($this->tenantId) ? (string)$this->tenantId : null,
            'active' => isset($this->active) ? (string)$this->active : null,
            'user_id' => isset($this->userId) ? (string)$this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string)$this->userUpdateId : null,
        ];

        return new Caixa($data);
    }
}
