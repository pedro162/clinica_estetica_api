<?php

namespace App\Domain\AccountReceivable\Entities;

use App\ContaReceber;
use App\Domain\BaseEntity\Entities\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableStatus;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableBranchId;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableId;
use App\Domain\AccountReceivable\ValueObjects\AccountReceivableDescription;

class AccountReceivable extends BaseEntity
{
    protected AccountReceivableId $id;
    protected AccountReceivableDescription $desciption;
    protected AccountReceivableStatus $status;
    protected AccountReceivableBranchId $branchId;

    public function id(AccountReceivableId $id): AccountReceivable
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?AccountReceivableId
    {
        return $this->id ?? null;
    }

    public function branchId(AccountReceivableBranchId $branchId): AccountReceivable
    {
        $this->branchId = $branchId;
        return $this;
    }

    public function getBranchId(): ?AccountReceivableBranchId
    {
        return $this->branchId ?? null;
    }

    public function desciption(AccountReceivableDescription $desciption): AccountReceivable
    {
        $this->desciption = $desciption;
        return $this;
    }

    public function getDescription(): ?AccountReceivableDescription
    {
        return $this->desciption ?? null;
    }

    public function status(AccountReceivableStatus $status): AccountReceivable
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): ?AccountReceivableStatus
    {
        return $this->status ?? null;
    }

    public static function buildEntity(array $data): AccountReceivable
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

        $status = $data['status'] ?? $data['status_bloqueio'] ?? '';
        $branchId = (string) ($data['branchId'] ?? $data['filial_id'] ?? 0);

        $entity = (new self())
            ->id(new AccountReceivableId($id))
            ->desciption(new AccountReceivableDescription((string)($data['nmCidade'] ?? $data['desciption'] ?? '')))
            ->tenantId(new BaseEntityTenantId($tenantId))
            ->active(((string)($data['active'] ?? '')))
            ->userId(new BaseEntityUserId($userId))
            ->userUpdateId(new BaseEntityUserId($userUpdateId))
            ->status(new AccountReceivableStatus((string) $status))
            ->branchId(new AccountReceivableBranchId($branchId));

        return $entity;
    }

    public function build(): ContaReceber
    {
        $data = [
            'id' => isset($this->id) ? (string)$this->id : null,
            'branchId' => isset($this->branchId) ? (string)$this->branchId : null,
            'desciption' => isset($this->desciption) ? (string)$this->desciption : null,
            'status_bloqueio' => isset($this->status) ? (string)$this->status : null,
            'tenant_id' => isset($this->tenantId) ? (string)$this->tenantId : null,
            'active' => isset($this->active) ? (string)$this->active : null,
            'user_id' => isset($this->userId) ? (string)$this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string)$this->userUpdateId : null,
        ];

        $data = array_filter($data, function ($value) {
            return $value !== null;
        });

        return new ContaReceber($data);
    }
}
