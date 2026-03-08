<?php

namespace App\Domain\Service\Entities;

use App\Domain\BaseEntity\Entities\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\Service\ValueObjects\ServiceDescription;
use App\Domain\Service\ValueObjects\ServiceId;
use App\Domain\Service\ValueObjects\ServiceName;
use App\Domain\Service\ValueObjects\ServiceType;
use App\Domain\Service\ValueObjects\ServiceUnit;
use App\Domain\Service\ValueObjects\ServiceValue;
use App\Servico;

class Service extends BaseEntity
{
    protected ServiceId $id;
    protected ServiceName $name;
    protected ServiceType $type;
    protected ServiceDescription $description;
    protected ServiceValue $value;
    protected ServiceUnit $unit;

    public function id(ServiceId $id): Service
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?ServiceId
    {
        return $this->id ?? null;
    }

    public function unit(ServiceUnit $unit): Service
    {
        $this->unit = $unit;
        return $this;
    }

    public function getUnit(): ?ServiceUnit
    {
        return $this->unit ?? null;
    }

    public function name(ServiceName $name): Service
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?ServiceName
    {
        return $this->name ?? null;
    }

    public function type(ServiceType $type): Service
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): ?ServiceType
    {
        return $this->type ?? null;
    }

    public function description(ServiceDescription $description): Service
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): ?ServiceDescription
    {
        return $this->description ?? null;
    }

    public function value(ServiceValue $value): Service
    {
        $this->value = $value;
        return $this;
    }

    public function getValue(): ?ServiceValue
    {
        return $this->value ?? null;
    }

    public static function buildEntity(array $data): Service
    {
        $entity = (new self());
        $mapping = [
            ['keys' => ['id'], 'callback' => fn ($value) => $entity->id(new ServiceId($value))],
            ['keys' => ['name'], 'callback' => fn ($value) => $entity->name(new ServiceName((string)$value))],
            ['keys' => ['description', 'descricao'], 'callback' => fn ($value) => $entity->description(new ServiceDescription((string)$value))],
            ['keys' => ['value', 'vrServico'], 'callback' => fn ($value) => $entity->value(new ServiceValue((float)$value))],
            ['keys' => ['type'], 'callback' => fn ($value) => $entity->type(new ServiceType((string)$value))],
            ['keys' => ['active'], 'callback' => fn ($value) => $entity->active((string)$value)],
            ['keys' => ['userId', 'user_id'], 'callback' => fn ($value) => $entity->userId(new BaseEntityUserId((string)$value))],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn ($value) => $entity->userUpdateId(new BaseEntityUserId((string)$value))],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn ($value) => $entity->tenantId(new BaseEntityTenantId((string)$value))],
            ['keys' => ['unit', 'unidade'], 'callback' => fn ($value) => $entity->unit(new ServiceUnit((string)$value))],
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

    public function build(): Servico
    {
        $data = [
            'id' => isset($this->id) ? (string)$this->id : null,
            'name' => isset($this->name) ? (string)$this->name : null,
            'descricao' => isset($this->description) ? (string)$this->description : null,
            'vrServico' => isset($this->value) ? (string)$this->value : null,
            'type' => isset($this->type) ? (string)$this->type : null,
            'tenant_id' => isset($this->tenantId) ? (string)$this->tenantId : null,
            'active' => isset($this->active) ? (string)$this->active : null,
            'user_id' => isset($this->userId) ? (string)$this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string)$this->userUpdateId : null,
            'unidade' => isset($this->unit) ? (string)$this->unit : null,
        ];

        $data = array_filter($data, function ($value) {
            return $value !== null;
        });

        return new Servico($data);
    }
}
