<?php

namespace App\Domain\City\Entities;

use App\Domain\City\ValueObjects\CityCode;
use App\Domain\City\ValueObjects\CityId;
use App\Domain\City\ValueObjects\CityName;
use App\Domain\City\ValueObjects\CityTenantId;
use App\Cidade;
use App\Domain\City\ValueObjects\CitySlug;
use App\Domain\City\ValueObjects\CityStateId;
use App\Domain\City\ValueObjects\CityUserId;

class City
{
    protected CityId $id;
    protected CityName $name;
    protected CitySlug $slug;
    protected CityStateId $stateId;
    protected CityCode $code;
    protected CityTenantId $tenantId;
    protected string $active;
    protected CityUserId $userId;
    protected CityUserId $userUpdateId;

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

    public function getCode(): ?CityCode
    {
        return $this->code ?? null;
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

    public function active(string $active): City
    {
        $this->active = $active;
        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active ?? null;
    }

    public function slug(CitySlug $slug): City
    {
        $this->slug = $slug;
        return $this;
    }

    public function getSlug(): ?CitySlug
    {
        return $this->slug ?? null;
    }

    public function stateId(CityStateId $stateId): City
    {
        $this->stateId = $stateId;
        return $this;
    }

    public function getStateId(): ?CityStateId
    {
        return $this->stateId ?? null;
    }

    public function userId(CityUserId $userId): City
    {
        $this->userId = $userId;
        return $this;
    }

    public function getUserId(): ?CityUserId
    {
        return $this->userId ?? null;
    }

    public function userUpdateId(CityUserId $userUpdateId): City
    {
        $this->userUpdateId = $userUpdateId;
        return $this;
    }

    public function getUserUpdateId(): ?CityUserId
    {
        return $this->userUpdateId ?? null;
    }

    public static function buildEntity(array $data): City
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
            ->id(new CityId($id))
            ->name(new CityName((string)($data['nmCidade'] ?? $data['name'] ?? '')))
            ->slug(new CitySlug((string)($data['sigla'] ?? $data['slug'] ?? 0)))
            ->stateId(new CityStateId($stateId))
            ->code(new CityCode((string)($data['cdCidade'] ?? $data['code'] ?? 0)))
            ->tenantId(new CityTenantId($tenantId))
            ->active(((string)($data['active'] ?? '')))
            ->userId(new CityUserId($userId))
            ->userUpdateId(new CityUserId($userUpdateId));

        return $entity;
    }

    public function build(): Cidade
    {
        $data = [
            'id' => isset($this->id) ? (string)$this->id : null,
            'nmCidade' => isset($this->name) ? (string)$this->name : null,
            'sigla' => isset($this->slug) ? (string)$this->slug : null,
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
