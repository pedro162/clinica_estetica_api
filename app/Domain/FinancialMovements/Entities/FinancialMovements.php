<?php

namespace App\Domain\FinancialMovements\Entities;

use App\FinanceiroMovimentacoe;
use App\Domain\BaseEntity\Entities\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\FinancialMovements\ValueObjects\FinancialMovementsBranchId;
use App\Domain\FinancialMovements\ValueObjects\FinancialMovementsId;

class FinancialMovements extends BaseEntity
{
    protected FinancialMovementsId $id;
    protected FinancialMovementsBranchId $branchId;

    public function id(FinancialMovementsId $id): FinancialMovements
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?FinancialMovementsId
    {
        return $this->id ?? null;
    }

    public function branchId(FinancialMovementsBranchId $branchId): FinancialMovements
    {
        $this->branchId = $branchId;
        return $this;
    }

    public function getBranchId(): ?FinancialMovementsBranchId
    {
        return $this->branchId ?? null;
    }

    public static function buildEntity(array $data): FinancialMovements
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

        $branchId = (string) ($data['branchId'] ?? $data['filial_id'] ?? 0);

        $entity = (new self())
            ->id(new FinancialMovementsId($id))
            ->tenantId(new BaseEntityTenantId($tenantId))
            ->active(((string)($data['active'] ?? '')))
            ->userId(new BaseEntityUserId($userId))
            ->branchId(new FinancialMovementsBranchId($branchId))
            ->userUpdateId(new BaseEntityUserId($userUpdateId));

        return $entity;
    }

    public function build(): FinanceiroMovimentacoe
    {
        $data = [
            'id' => isset($this->id) ? (string)$this->id : null,
            'filial_id' => isset($this->branchId) ? (string)$this->branchId : null,
            'tenant_id' => isset($this->tenantId) ? (string)$this->tenantId : null,
            'active' => isset($this->active) ? (string)$this->active : null,
            'user_id' => isset($this->userId) ? (string)$this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string)$this->userUpdateId : null,
        ];

        $data = array_filter($data, function ($value) {
            return $value !== null;
        });

        return new FinanceiroMovimentacoe($data);
    }
}
