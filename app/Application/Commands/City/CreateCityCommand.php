<?php

namespace App\Application\Commands\City;

class CreateCityCommand
{

    protected string $id;
    protected string $name;
    protected string $code;
    protected string $userId;
    protected string $tenantId;

    public function id(string $id): CreateCityCommand
    {
        $this->id = $id;
        return $this;
    }

    public function tenantId(string $tenantId): CreateCityCommand
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function name(string $name): CreateCityCommand
    {
        $this->name = $name;
        return $this;
    }

    public function code(string $code): CreateCityCommand
    {
        $this->code = $code;
        return $this;
    }

    public function userId(string $userId): CreateCityCommand
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

    public function getUserId(): ?string
    {
        return $this->userId ?? null;
    }

    public static function build(array $data): CreateCityCommand
    {
        $entity = (new self)
            ->id($data['id'])
            ->name($data['name'])
            ->code($data['code'])
            ->tenantId($data['tenantId'])
            ->userId($data['userId']);

        return $entity;
    }
}
