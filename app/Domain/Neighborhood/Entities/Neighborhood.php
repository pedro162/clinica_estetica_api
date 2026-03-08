<?php

namespace App\Domain\Neighborhood\Entities;

use App\Bairro;
use App\Domain\BaseEntity\Entities\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\Neighborhood\ValueObjects\NeighborhoodCityId;
use App\Domain\Neighborhood\ValueObjects\NeighborhoodIbgeCode;
use App\Domain\Neighborhood\ValueObjects\NeighborhoodId;
use App\Domain\Neighborhood\ValueObjects\NeighborhoodName;
use App\Domain\Neighborhood\ValueObjects\NeighborhoodZipCode;

class Neighborhood extends BaseEntity
{
    protected ?NeighborhoodId $id = null;
    protected ?NeighborhoodName $name = null;
    protected ?NeighborhoodIbgeCode $codIbge = null;
    protected ?NeighborhoodZipCode $cep = null;
    protected ?NeighborhoodCityId $cityId = null;

    public function id(NeighborhoodId $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?NeighborhoodId
    {
        return $this->id ?? null;
    }

    public function name(NeighborhoodName $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?NeighborhoodName
    {
        return $this->name ?? null;
    }

    public function codIbge(NeighborhoodIbgeCode $codIbge): self
    {
        $this->codIbge = $codIbge;
        return $this;
    }

    public function getCodIbge(): ?NeighborhoodIbgeCode
    {
        return $this->codIbge ?? null;
    }

    public function cep(NeighborhoodZipCode $cep): self
    {
        $this->cep = $cep;
        return $this;
    }

    public function getCep(): ?NeighborhoodZipCode
    {
        return $this->cep ?? null;
    }

    public function cityId(NeighborhoodCityId $cityId): self
    {
        $this->cityId = $cityId;
        return $this;
    }

    public function getCityId(): ?NeighborhoodCityId
    {
        return $this->cityId ?? null;
    }

    public static function buildEntity(array $data): self
    {
        $entity = new self();

        $mapping = [
            ['keys' => ['id'], 'callback' => fn ($v) => $entity->id(new NeighborhoodId((string) $v))],
            ['keys' => ['name'], 'callback' => fn ($v) => $entity->name(new NeighborhoodName((string) $v))],
            ['keys' => ['codIbge'], 'callback' => fn ($v) => $entity->codIbge(new NeighborhoodIbgeCode((string) $v))],
            ['keys' => ['cep'], 'callback' => fn ($v) => $entity->cep(new NeighborhoodZipCode((string) $v))],
            ['keys' => ['cidade_id', 'cityId'], 'callback' => fn ($v) => $entity->cityId(new NeighborhoodCityId((string) $v))],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn ($v) => $entity->tenantId(new BaseEntityTenantId((string) $v))],
            ['keys' => ['userId', 'user_id'], 'callback' => fn ($v) => $entity->userId(new BaseEntityUserId((string) $v))],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn ($v) => $entity->userUpdateId(new BaseEntityUserId((string) $v))],
            ['keys' => ['active'], 'callback' => fn ($v) => $entity->active((string) $v)],
        ];

        foreach ($mapping as $map) {
            foreach ($map['keys'] as $key) {
                if (array_key_exists($key, $data)) {
                    $map['callback']($data[$key]);
                    break;
                }
            }
        }

        return $entity;
    }

    public function build(): Bairro
    {
        $data = [
            'id'             => $this->id ? (string) $this->id : null,
            'name'           => $this->name ? (string) $this->name : null,
            'codIbge'        => $this->codIbge ? (string) $this->codIbge : null,
            'cep'            => $this->cep ? (string) $this->cep : null,
            'cidade_id'      => $this->cityId ? (string) $this->cityId : null,
            'tenant_id'      => isset($this->tenantId) ? (string) $this->tenantId : null,
            'user_id'        => isset($this->userId) ? (string) $this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string) $this->userUpdateId : null,
            'active'         => $this->active ?? null,
        ];

        $data = array_filter($data, static fn ($v) => $v !== null);

        return new Bairro($data);
    }
}
