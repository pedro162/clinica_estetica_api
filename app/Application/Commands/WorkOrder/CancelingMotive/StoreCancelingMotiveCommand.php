<?php

namespace App\Application\Commands\WorkOrder\CancelingMotive;

class StoreCancelingMotiveCommand
{
    protected ?string $id = null;
    protected ?string $tenantId = null;
    protected ?string $userId = null;
    protected ?string $userUpdateId = null;
    protected ?string $active = null;
    protected ?string $motive = null;
    protected ?int $personId = null;

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

    public function userId(string $userId): self
    {
        $this->userId = $userId;
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

    public function motive(?string $motive): self
    {
        $this->motive = $motive;
        return $this;
    }

    public function personId(int $personId): self
    {
        $this->personId = $personId;
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

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function getUserUpdateId(): ?string
    {
        return $this->userUpdateId;
    }

    public function getActive(): ?string
    {
        return $this->active;
    }

    public function getMotive(): ?string
    {
        return $this->motive;
    }

    public static function build(array $data): self
    {
        $entity = new self();

        $mapping = [
            ['keys' => ['id'], 'callback' => fn($v) => $entity->id((string) $v)],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn($v) => $entity->tenantId((string) $v)],
            ['keys' => ['userId', 'user_id'], 'callback' => fn($v) => $entity->userId((string) $v)],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn($v) => $entity->userUpdateId((string) $v)],
            ['keys' => ['active'], 'callback' => fn($v) => $entity->active((string) $v)],
            ['keys' => ['motivo', 'motive'], 'callback' => fn($v) => $entity->motive((string) $v)],
            ['keys' => ['pessoa_id', 'person_id'], 'callback' => fn($v) => $entity->personId((int) $v)],
        ];

        foreach ($mapping as $map) {
            foreach ($map['keys'] as $key) {
                if (array_key_exists($key, $data) && $data[$key] !== null) {
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
            'id' => $this->id,
            'tenant_id' => $this->tenantId,
            'user_id' => $this->userId,
            'user_update_id' => $this->userUpdateId,
            'active' => $this->active,
            'motive' => $this->motive,
            'person_id' => $this->personId,
        ];

        return array_filter($data, fn($v) => $v !== null);
    }
}
