<?php

namespace App\Application\Commands\Service;

class CreateServiceCommand
{
    protected string $id;
    protected string $name;
    protected string $description;
    protected float $value;
    protected string $type;
    protected string $userId;
    protected string $userUpdateId;
    protected string $tenantId;
    protected string $active;
    protected string $unit;

    public function id(string $id): CreateServiceCommand
    {
        $this->id = $id;
        return $this;
    }

    public function tenantId(string $tenantId): CreateServiceCommand
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function name(string $name): CreateServiceCommand
    {
        $this->name = $name;
        return $this;
    }

    public function description(string $description): CreateServiceCommand
    {
        $this->description = $description;
        return $this;
    }

    public function type(string $type): CreateServiceCommand
    {
        $this->type = $type;
        return $this;
    }

    public function value(string $value): CreateServiceCommand
    {
        $this->value = $value;
        return $this;
    }

    public function userId(string $userId): CreateServiceCommand
    {
        $this->userId = $userId;
        return $this;
    }

    public function userUpdateId(string $userUpdateId): CreateServiceCommand
    {
        $this->userUpdateId = $userUpdateId;
        return $this;
    }

    public function active(string $active): CreateServiceCommand
    {
        $this->active = $active;
        return $this;
    }

    public function unit(string $unit): CreateServiceCommand
    {
        $this->unit = $unit;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id ?? null;
    }

    public function getTenantId(): ?string
    {
        return $this->tenantId ?? null;
    }

    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    public function getDescription(): ?string
    {
        return $this->description ?? null;
    }

    public function getType(): ?string
    {
        return $this->type ?? null;
    }

    public function getValue(): ?string
    {
        return $this->value ?? null;
    }

    public function getUserId(): ?string
    {
        return $this->userId ?? null;
    }

    public function getUserUpdateId(): ?string
    {
        return $this->userUpdateId ?? null;
    }

    public function getActive(): ?string
    {
        return $this->active ?? null;
    }

    public function getUnit(): ?string
    {
        return $this->unit ?? null;
    }

    public static function build(array $data): CreateServiceCommand
    {
        $entity = (new self());
        $mapping = [
            ['keys' => ['id'], 'callback' => fn ($value) => $entity->id((string) $value)],
            ['keys' => ['name'], 'callback' => fn ($value) => $entity->name((string)$value)],
            ['keys' => ['description', 'descricao'], 'callback' => fn ($value) => $entity->description((string) $value)],
            ['keys' => ['value', 'vrServico'], 'callback' => fn ($value) => $entity->value((float)$value)],
            ['keys' => ['type'], 'callback' => fn ($value) => $entity->type((string)$value)],
            ['keys' => ['active'], 'callback' => fn ($value) => $entity->active((string)$value)],
            ['keys' => ['userId', 'user_id'], 'callback' => fn ($value) => $entity->userId((string) $value)],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn ($value) => $entity->userUpdateId((string) $value)],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn ($value) => $entity->tenantId((string) $value)],
            ['keys' => ['unit', 'unidade'], 'callback' => fn ($value) => $entity->unit((string) $value)],
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

    public function getDataProperties(): array
    {
        $data = [
            'id' => (string)($this->id ?? ''),
            'name' => (string)($this->name ?? ''),
            'description' => (string)($this->description ?? ''),
            'type' => (string)($this->type ?? ''),
            'value' => (float)($this->value ?? 0),
            'tenantId' => (string)($this->tenantId ?? ''),
            'userId' => (string)($this->userId ?? ''),
            'userUpdateId' => (string)($this->userUpdateId ?? ''),
            'active' => (string)($this->active ?? ''),
            'unit' => (string)($this->unit ?? ''),
        ];

        return  array_filter($data, fn ($value) => $value !== null && trim($value) != '');
    }
}
