<?php

namespace App\Domain\Parameter\Entities;

use App\Domain\Parameter\ValueObjects\ParameterId;
use App\Domain\Parameter\ValueObjects\ParameterName;
use App\Domain\Parameter\ValueObjects\ParameterTenantId;
use App\Domain\Parameter\ValueObjects\ParameterType;
use App\Parametro;

class Parameter
{
    protected ParameterId $id;
    protected ParameterName $name;
    protected ParameterType $type;
    protected ParameterTenantId $tenantId;
    protected string $active;
    protected string $userId;
    protected string $userUpdateId;

    public function id(ParameterId $id): Parameter
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?ParameterId
    {
        return $this->id ?? null;
    }

    public function name(ParameterName $name): Parameter
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?ParameterName
    {
        return $this->name ?? null;
    }

    public function type(ParameterType $type): Parameter
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): ?ParameterType
    {
        return $this->type ?? null;
    }

    public function tenantId(ParameterTenantId $tenantId): Parameter
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function getTenantId(): ?ParameterTenantId
    {
        return $this->tenantId ?? null;
    }

    public function build(): Parametro
    {
        $data = [
            'name' => isset($this->name) ? (string)$this->name : null,
            'type' => isset($this->type) ? (string)$this->type : null,
            'tenant_id' => isset($this->tenantId) ? (string)$this->tenantId : null,
            'active' => isset($this->active) ? (string)$this->active : null,
            'user_id' => isset($this->userId) ? (string)$this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string)$this->userUpdateId : null,
        ];
        return new Parametro($data);
    }
}
