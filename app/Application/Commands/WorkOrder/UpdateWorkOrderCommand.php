<?php

namespace App\Application\Commands\WorkOrder;

class UpdateWorkOrderCommand
{
    protected ?string $id = null;
    protected ?string $tenantId = null;
    protected ?string $userUpdateId = null;
    protected ?string $active = null;

    public function id(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function tenantId(string $tenantId): self
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function userUpdateId(string $userUpdateId): self
    {
        $this->userUpdateId = $userUpdateId;
        return $this;
    }

    public function active(string $active): self
    {
        $this->active = $active;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getTenantId(): ?string
    {
        return $this->tenantId;
    }

    public function getUserUpdateId(): ?string
    {
        return $this->userUpdateId;
    }

    public function getActive(): ?string
    {
        return $this->active;
    }

    public static function build(array $data): self
    {
        $entity = new self();

        $mapping = [
            ['keys' => ['id'], 'callback' => fn ($v) => $entity->id((string)$v)],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn ($v) => $entity->tenantId((string)$v)],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn ($v) => $entity->userUpdateId((string)$v)],
            ['keys' => ['active'], 'callback' => fn ($v) => $entity->active((string)$v)],
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
            'tenantId' => (string)($this->tenantId ?? ''),
            'userUpdateId' => (string)($this->userUpdateId ?? ''),
            'active' => (string)($this->active ?? ''),
        ];

        return array_filter($data, fn ($v) => $v !== '' && $v !== null);
    }
}
