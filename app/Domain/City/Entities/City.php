<?php

namespace App\Domain\City\Entities;

use App\Domain\City\ValueObjects\CityCode;
use App\Domain\City\ValueObjects\CityId;
use App\Domain\City\ValueObjects\CityName;
use App\Domain\City\ValueObjects\CityTenantId;
use App\Cidade;

class City
{
    protected CityId $id;
    protected CityName $name;
    protected CityName $acronym;
    protected CityName $stateId;
    protected CityCode $code;
    protected CityTenantId $tenantId;
    protected string $active;
    protected string $userId;
    protected string $userUpdateId;

    public function id(CityId $id): City
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?CityId
    {
        return $this->id ?? null;
    }

    public function name(CityName $name): City
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?CityName
    {
        return $this->name ?? null;
    }

    public function code(CityCode $code): City
    {
        $this->code = $code;
        return $this;
    }

    public function tenantId(CityTenantId $tenantId): City
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function getTenantId(): ?CityTenantId
    {
        return $this->tenantId ?? null;
    }

    public function getCode(): ?CityCode
    {
        return $this->code ?? null;
    }

    public function build(): Cidade
    {
        $data = [
            'id' => isset($this->id) ? (string)$this->id : null,
            'nmCidade' => isset($this->name) ? (string)$this->name : null,
            'sigla' => isset($this->acronym) ? (string)$this->acronym : null,
            'estado_id' => isset($this->stateId) ? (string)$this->stateId : null,
            'cdCidade' => isset($this->code) ? (string)$this->code : null,
            'tenant_id' => isset($this->tenantId) ? (string)$this->tenantId : null,
            'active' => isset($this->active) ? (string)$this->active : null,
            'user_id' => isset($this->userId) ? (string)$this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string)$this->userUpdateId : null,
        ];
        return new Cidade($data);
    }
}
