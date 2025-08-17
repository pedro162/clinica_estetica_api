<?php

namespace App\Application\Commands\Country;

class CreateCountryCommand
{
    protected string $id;
    protected string $name;
    protected string $code;
    protected bool $isDefault;
    protected string $userId;
    protected string $userUpdateId;
    protected string $tenantId;
    protected string $active;

    public function id(string $id): CreateCountryCommand
    {
        $this->id = $id;
        return $this;
    }

    public function tenantId(string $tenantId): CreateCountryCommand
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function name(string $name): CreateCountryCommand
    {
        $this->name = $name;
        return $this;
    }

    public function code(string $code): CreateCountryCommand
    {
        $this->code = $code;
        return $this;
    }

    public function isDefault(bool $isDefault): CreateCountryCommand
    {
        $this->isDefault = $isDefault;
        return $this;
    }

    public function userId(string $userId): CreateCountryCommand
    {
        $this->userId = $userId;
        return $this;
    }

    public function userUpdateId(string $userUpdateId): CreateCountryCommand
    {
        $this->userUpdateId = $userUpdateId;
        return $this;
    }

    public function active(string $active): self
    {
        $this->active = $active;
        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active ?? null;
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

    public function getCode(): ?string
    {
        return $this->code ?? null;
    }

    public function getIsDefault(): ?bool
    {
        return $this->isDefault ?? null;
    }

    public function getUserId(): ?string
    {
        return $this->userId ?? null;
    }

    public function getUserUpdateId(): ?string
    {
        return $this->userUpdateId ?? null;
    }

    public static function build(array $data): CreateCountryCommand
    {
        $entity = (new self());
        $mapping = [
            ['keys' => ['id'], 'callback' => fn($value) => $entity->id($value)],
            ['keys' => ['name', 'nmPais'], 'callback' => fn($value) => $entity->name((string)$value)],
            ['keys' => ['code', 'cdPais'], 'callback' => fn($value) => $entity->code((string)$value)],
            ['keys' => ['isDefault', 'padrao'], 'callback' => fn($value) => $entity->isDefault($value === 'yes' || $value === true  ? true : false)],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn($value) => $entity->tenantId((string)$value)],
            ['keys' => ['active'], 'callback' => fn($value) => $entity->active((string)$value)],
            ['keys' => ['userId', 'user_id'], 'callback' => fn($value) => $entity->userId((string)$value)],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn($value) => $entity->userUpdateId((string)$value)],
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
            'id' => $this->id ?? '',
            'name' => $this->name ?? '',
            'code' => $this->code ?? '',
            'isDefault' => $this->isDefault ?? null,
            'tenantId' => $this->tenantId ?? '',
            'userId' => $this->userId ?? '',
            'userUpdateId' => $this->userUpdateId ?? '',
            'active' => $this->active ?? '',
        ];

        return  array_filter($data, fn($value) => $value !== null && trim($value) != '');
    }
}
