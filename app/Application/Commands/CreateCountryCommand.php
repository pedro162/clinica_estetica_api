<?php

namespace App\Application\Commands;

class CreateCountryCommand
{

    protected string $id;
    protected string $name;
    protected string $code;
    protected bool $isDefault;
    protected string $userId;
    protected string $tenantId;

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
}
