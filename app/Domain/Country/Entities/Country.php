<?php

namespace App\Domain\Country\Entities;

use App\Domain\BaseEntity\Entities\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\Country\ValueObjects\CountryCode;
use App\Domain\Country\ValueObjects\CountryId;
use App\Domain\Country\ValueObjects\CountryIsDefault;
use App\Domain\Country\ValueObjects\CountryName;
use App\Pais;

class Country extends BaseEntity
{
    protected CountryId $id;
    protected CountryName $name;
    protected CountryCode $code;
    protected CountryIsDefault $isDefault;

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

    public function getCode(): ?CountryCode
    {
        return $this->code ?? null;
    }

    public static function buildEntity(array $data): Country
    {
        $entity = (new self());
        $mapping = [
            ['keys' => ['id'], 'callback' => fn ($value) => $entity->id(new CountryId($value))],
            ['keys' => ['name', 'nmPais'], 'callback' => fn ($value) => $entity->name(new CountryName((string)$value))],
            ['keys' => ['code', 'cdPais'], 'callback' => fn ($value) => $entity->code(new CountryCode((string)$value))],
            ['keys' => ['isDefault', 'padrao'], 'callback' => fn ($value) => $entity->isDefault(new CountryIsDefault($value === 'yes' || $value === true ? true : false))],
            ['keys' => ['active'], 'callback' => fn ($value) => $entity->active((string)$value)],
            ['keys' => ['userId', 'user_id'], 'callback' => fn ($value) => $entity->userId(new BaseEntityUserId((string)$value))],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn ($value) => $entity->userUpdateId(new BaseEntityUserId((string)$value))],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn ($value) => $entity->tenantId(new BaseEntityTenantId((string)$value))],
        ];

        foreach ($mapping as $map) {
            foreach ($map['keys'] as $key) {
                if (isset($data[$key])) {
                    $map['callback']($data[$key]);
                    break;
                }
            }
        }

        return $entity;
    }

    public function build(): Pais
    {
        $data = [
            'id' => isset($this->id) ? (string)$this->id : null,
            'nmPais' => isset($this->name) ? (string)$this->name : null,
            'padrao' => isset($this->isDefault)
                ? (string)($this->isDefault == true ? 'yes' : 'no')
                : null,
            'cdPais' => isset($this->code) ? (string)$this->code : null,
            'tenant_id' => isset($this->tenantId) ? (string)$this->tenantId : null,
            'active' => isset($this->active) ? (string)$this->active : null,
            'user_id' => isset($this->userId) ? (string)$this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string)$this->userUpdateId : null,
        ];

        $data = array_filter($data, function ($value) {
            return $value !== null;
        });

        return new Pais($data);
    }
}
