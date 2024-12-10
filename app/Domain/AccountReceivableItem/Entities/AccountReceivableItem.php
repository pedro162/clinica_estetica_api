<?php

namespace App\Domain\AccountReceivableItem\Entities;

use App\Caixa;
use App\Domain\BaseEntity\Entities\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemStatus;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemBranchId;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemId;
use App\Domain\AccountReceivableItem\ValueObjects\AccountReceivableItemDescription;

class AccountReceivableItem extends BaseEntity
{
    protected AccountReceivableItemId $id;
    protected AccountReceivableItemDescription $desciption;
    protected AccountReceivableItemStatus $status;
    protected AccountReceivableItemBranchId $branchId;

    public function id(AccountReceivableItemId $id): AccountReceivableItem
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?AccountReceivableItemId
    {
        return $this->id ?? null;
    }

    public function branchId(AccountReceivableItemBranchId $branchId): AccountReceivableItem
    {
        $this->branchId = $branchId;
        return $this;
    }

    public function getBranchId(): ?AccountReceivableItemBranchId
    {
        return $this->branchId ?? null;
    }

    public function desciption(AccountReceivableItemDescription $desciption): AccountReceivableItem
    {
        $this->desciption = $desciption;
        return $this;
    }

    public function getDescription(): ?AccountReceivableItemDescription
    {
        return $this->desciption ?? null;
    }

    public function status(AccountReceivableItemStatus $status): AccountReceivableItem
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): ?AccountReceivableItemStatus
    {
        return $this->status ?? null;
    }

    public static function buildEntity(array $data): AccountReceivableItem
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
            ->id(new AccountReceivableItemId($id))
            ->desciption(new AccountReceivableItemDescription((string)($data['nmCidade'] ?? $data['desciption'] ?? '')))
            ->tenantId(new BaseEntityTenantId($tenantId))
            ->active(((string)($data['active'] ?? '')))
            ->userId(new BaseEntityUserId($userId))
            ->userUpdateId(new BaseEntityUserId($userUpdateId))
            ->status(new AccountReceivableItemStatus((string) $status))
            ->branchId(new AccountReceivableItemBranchId($branchId));

        return $entity;
    }

    public function build(): Caixa
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

        return new Caixa($data);
    }
}
