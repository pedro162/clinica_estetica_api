<?php

namespace App\Domain\CreditCardBrand\Entities;

use App\Domain\BaseEntity\Entities\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;;

use App\Domain\CreditCardBrand\ValueObjects\CreditCardBrandId;
use App\Domain\CreditCardBrand\ValueObjects\CreditCardBrandIsStandard;
use App\Domain\CreditCardBrand\ValueObjects\CreditCardBrandName;
use App\BandeiraCartao;

class CreditCardBrand extends BaseEntity
{
    protected CreditCardBrandId $id;
    protected CreditCardBrandName $name;
    protected CreditCardBrandIsStandard $standard;

    public function id(CreditCardBrandId $id): CreditCardBrand
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?CreditCardBrandId
    {
        return $this->id ?? null;
    }

    public function name(CreditCardBrandName $name): CreditCardBrand
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?CreditCardBrandName
    {
        return $this->name ?? null;
    }

    public function standard(CreditCardBrandIsStandard $standard): CreditCardBrand
    {
        $this->standard = $standard;
        return $this;
    }

    public function getStandard(): ?CreditCardBrandIsStandard
    {
        return $this->standard ?? null;
    }

    public static function buildEntity(array $data): CreditCardBrand
    {
        $entity = (new self());
        $mapping = [
            ['keys' => ['id'], 'callback' => fn($value) => $entity->id(new CreditCardBrandId($value))],
            ['keys' => ['name'], 'callback' => fn($value) => $entity->name(new CreditCardBrandName((string)$value))],
            ['keys' => ['standard'], 'callback' => fn($value) => $entity->standard(new CreditCardBrandIsStandard((string)$value))],
            ['keys' => ['active'], 'callback' => fn($value) => $entity->active((string)$value)],
            ['keys' => ['userId', 'user_id'], 'callback' => fn($value) => $entity->userId(new BaseEntityUserId((string)$value))],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn($value) => $entity->userUpdateId(new BaseEntityUserId((string)$value))],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn($value) => $entity->tenantId(new BaseEntityTenantId((string)$value))],
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

    public function toArray(): array
    {
        return [
            'id' => isset($this->id) ? (string)$this->id : null,
            'name' => isset($this->name) ? (string)$this->name : null,
            'standard' => isset($this->standard) ? (string)$this->standard : null,
            'active' => isset($this->active) ? (string)$this->active : null,
            'userId' => isset($this->userId) ? (string)$this->userId : null,
            'userUpdateId' => isset($this->userUpdateId) ? (string)$this->userUpdateId : null,
            'tenantId' => isset($this->tenantId) ? (string)$this->tenantId : null,
        ];
    }

    public function build(): BandeiraCartao
    {
        $data = [
            'id' => isset($this->id) ? (string)$this->id : null,
            'name' => isset($this->name) ? (string)$this->name : null,
            'standard' => isset($this->standard) ? (string)$this->standard : null,
            'tenant_id' => isset($this->tenantId) ? (string)$this->tenantId : null,
            'active' => isset($this->active) ? (string)$this->active : null,
            'user_id' => isset($this->userId) ? (string)$this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string)$this->userUpdateId : null,
        ];

        $data = array_filter($data, function ($value) {
            return $value !== null;
        });

        return new BandeiraCartao($data);
    }
}
