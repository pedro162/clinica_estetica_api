<?php

namespace App\Domain\Category\Entities;

use App\Categoria;
use App\Domain\BaseEntity\Entities\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\Category\ValueObjects\CategoryId;
use App\Domain\Category\ValueObjects\CategoryName;

class Category extends BaseEntity
{
    protected ?CategoryId $id = null;
    protected ?CategoryName $name = null;

    public function id(CategoryId $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?CategoryId
    {
        return $this->id ?? null;
    }

    public function name(CategoryName $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?CategoryName
    {
        return $this->name ?? null;
    }

    public static function buildEntity(array $data): self
    {
        $entity = new self();

        $mapping = [
            ['keys' => ['id'], 'callback' => fn ($v) => $entity->id(new CategoryId((string)$v))],
            ['keys' => ['name'], 'callback' => fn ($v) => $entity->name(new CategoryName((string)$v))],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn ($v) => $entity->tenantId(new BaseEntityTenantId((string)$v))],
            ['keys' => ['userId', 'user_id'], 'callback' => fn ($v) => $entity->userId(new BaseEntityUserId((string)$v))],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn ($v) => $entity->userUpdateId(new BaseEntityUserId((string)$v))],
            ['keys' => ['active'], 'callback' => fn ($v) => $entity->active((string)$v)],
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

    public function build(): Categoria
    {
        $data = [
            'id'         => $this->id ? (string)$this->id : null,
            'name'       => $this->name ? (string)$this->name : null,
            'tenant_id'  => isset($this->tenantId) ? (string)$this->tenantId : null,
            'user_id'    => isset($this->userId) ? (string)$this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string)$this->userUpdateId : null,
            'active'     => $this->active ?? null,
        ];

        $data = array_filter($data, fn ($v) => $v !== null);

        return new Categoria($data);
    }
}
