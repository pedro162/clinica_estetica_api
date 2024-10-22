<?php

namespace App\Domain\Country\Entities;

use App\Domain\Country\ValueObjects\CountryCode;
use App\Domain\Country\ValueObjects\CountryId;
use App\Domain\Country\ValueObjects\CountryName;
use App\Domain\Country\ValueObjects\CountryTenantId;
use App\Domain\Country\ValueObjects\CountryIsDefault;
use App\Pais;

class Country
{
    protected CountryId $id;
    protected CountryName $name;
    protected CountryCode $code;
    protected CountryIsDefault $isDefault;
    protected CountryTenantId $tenantId;
    protected string $active;
    protected string $userId;
    protected string $userUpdateId;

    public function id(CountryId $id): Country
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?CountryId
    {
        return $this->id ?? null;
    }

    public function name(CountryName $name): Country
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?CountryName
    {
        return $this->name ?? null;
    }

    public function isDefault(CountryIsDefault $isDefault): Country
    {
        $this->isDefault = $isDefault;
        return $this;
    }

    public function code(CountryCode $code): Country
    {
        $this->code = $code;
        return $this;
    }

    public function getIsDefault(): ?CountryIsDefault
    {
        return $this->isDefault ?? null;
    }

    public function tenantId(CountryTenantId $tenantId): Country
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function getTenantId(): ?CountryTenantId
    {
        return $this->tenantId ?? null;
    }

    public function getCode(): ?CountryCode
    {
        return $this->code ?? null;
    }

    public function build(): Pais
    {
        $data = [
            'id' => isset($this->id) ? (string)$this->id : null,
            'nmPais' => isset($this->name) ? (string)$this->name : null,
            'padrao' => isset($this->isDefault)
                ? (string)($this->isDefault == 'true' ? 'yes' : 'no')
                : null,
            'cdPais' => isset($this->code) ? (string)$this->code : null,
            'tenant_id' => isset($this->tenantId) ? (string)$this->tenantId : null,
            'active' => isset($this->active) ? (string)$this->active : null,
            'user_id' => isset($this->userId) ? (string)$this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string)$this->userUpdateId : null,
        ];
        return new Pais($data);
    }
}
