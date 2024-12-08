<?php

namespace App\Domain\BaseEntity\Entities;

use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;

abstract class BaseEntity
{
    protected BaseEntityTenantId $tenantId;
    protected string $active;
    protected BaseEntityUserId $userId;
    protected BaseEntityUserId $userUpdateId;

    public function tenantId(BaseEntityTenantId $tenantId): BaseEntity
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function getTenantId(): ?BaseEntityTenantId
    {
        return $this->tenantId ?? null;
    }

    public function active(string $active): BaseEntity
    {
        $this->active = $active;
        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active ?? null;
    }
    public function userId(BaseEntityUserId $userId): BaseEntity
    {
        $this->userId = $userId;
        return $this;
    }

    public function getUserId(): ?BaseEntityUserId
    {
        return $this->userId ?? null;
    }

    public function userUpdateId(BaseEntityUserId $userUpdateId): BaseEntity
    {
        $this->userUpdateId = $userUpdateId;
        return $this;
    }

    public function getUserUpdateId(): ?BaseEntityUserId
    {
        return $this->userUpdateId ?? null;
    }
}
