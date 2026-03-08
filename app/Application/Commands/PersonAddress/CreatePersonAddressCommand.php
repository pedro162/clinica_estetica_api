<?php

namespace App\Application\Commands\PersonAddress;

class CreatePersonAddressCommand
{
    protected string $id;
    protected string $street;
    protected string $userId;
    protected string $userUpdateId;
    protected string $tenantId;
    protected string $active;
    protected string $city;
    protected string $number;
    protected string $neighborhood;
    protected string $complement;
    protected string $state;
    protected string $isActive;
    protected string $type;
    protected string $block;
    protected string $importance;
    protected string $postalCode;
    protected string $branchId;

    public function id(string $id): self
    {
        $this->id = $id;
        return $this;
    }
    public function getId(): ?string
    {
        return $this->id ?? null;
    }

    public function street(string $street): self
    {
        $this->street = $street;
        return $this;
    }
    public function getStreet(): ?string
    {
        return $this->street ?? null;
    }

    public function city(string $city): self
    {
        $this->city = $city;
        return $this;
    }
    public function getCity(): ?string
    {
        return $this->city ?? null;
    }

    public function number(string $number): self
    {
        $this->number = $number;
        return $this;
    }
    public function getNumber(): ?string
    {
        return $this->number ?? null;
    }

    public function neighborhood(string $neighborhood): self
    {
        $this->neighborhood = $neighborhood;
        return $this;
    }
    public function getNeighborhood(): ?string
    {
        return $this->neighborhood ?? null;
    }

    public function complement(string $complement): self
    {
        $this->complement = $complement;
        return $this;
    }
    public function getComplement(): ?string
    {
        return $this->complement ?? null;
    }

    public function state(string $state): self
    {
        $this->state = $state;
        return $this;
    }
    public function getState(): ?string
    {
        return $this->state ?? null;
    }

    public function isActive(string $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }
    public function getIsActive(): ?string
    {
        return $this->isActive ?? null;
    }

    public function type(string $type): self
    {
        $this->type = $type;
        return $this;
    }
    public function getType(): ?string
    {
        return $this->type ?? null;
    }

    public function block(string $block): self
    {
        $this->block = $block;
        return $this;
    }
    public function getBlock(): ?string
    {
        return $this->block ?? null;
    }

    public function importance(string $importance): self
    {
        $this->importance = $importance;
        return $this;
    }
    public function getImportance(): ?string
    {
        return $this->importance ?? null;
    }

    public function postalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;
        return $this;
    }
    public function getPostalCode(): ?string
    {
        return $this->postalCode ?? null;
    }

    public function userId(string $userId): self
    {
        $this->userId = $userId;
        return $this;
    }
    public function getUserId(): ?string
    {
        return $this->userId ?? null;
    }

    public function userUpdateId(string $userUpdateId): self
    {
        $this->userUpdateId = $userUpdateId;
        return $this;
    }
    public function getUserUpdateId(): ?string
    {
        return $this->userUpdateId ?? null;
    }

    public function tenantId(string $tenantId): self
    {
        $this->tenantId = $tenantId;
        return $this;
    }
    public function getTenantId(): ?string
    {
        return $this->tenantId ?? null;
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

    public function branchId(string $branchId): self
    {
        $this->branchId = $branchId;
        return $this;
    }
    public function getBranchId(): ?string
    {
        return $this->branchId ?? null;
    }

    public static function build(array $data): self
    {
        $entity = new self();
        $mapping = [
            ['keys' => ['id'], 'callback' => fn ($v) => $entity->id($v)],
            ['keys' => ['street', 'logradouro'], 'callback' => fn ($v) => $entity->street($v)],
            ['keys' => ['city', 'cidade'], 'callback' => fn ($v) => $entity->city($v)],
            ['keys' => ['number', 'numero'], 'callback' => fn ($v) => $entity->number($v)],
            ['keys' => ['neighborhood', 'bairro'], 'callback' => fn ($v) => $entity->neighborhood($v)],
            ['keys' => ['complement', 'complemento'], 'callback' => fn ($v) => $entity->complement($v)],
            ['keys' => ['state', 'estado'], 'callback' => fn ($v) => $entity->state($v)],
            ['keys' => ['isActive', 'ativo'], 'callback' => fn ($v) => $entity->isActive($v)],
            ['keys' => ['type', 'tipo'], 'callback' => fn ($v) => $entity->type($v)],
            ['keys' => ['block', 'bloco'], 'callback' => fn ($v) => $entity->block($v)],
            ['keys' => ['importance', 'importancia'], 'callback' => fn ($v) => $entity->importance($v)],
            ['keys' => ['postalCode', 'cep'], 'callback' => fn ($v) => $entity->postalCode($v)],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn ($v) => $entity->tenantId($v)],
            ['keys' => ['userId', 'user_id'], 'callback' => fn ($v) => $entity->userId($v)],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn ($v) => $entity->userUpdateId($v)],
            ['keys' => ['active'], 'callback' => fn ($v) => $entity->active($v)],
            ['keys' => ['branchId', 'filial_id'], 'callback' => fn ($v) => $entity->branchId($v)],
        ];

        foreach ($mapping as $map) {
            foreach ($map['keys'] as $key) {
                if (isset($data[$key])) {
                    $map['callback']((string) $data[$key]);
                    break;
                }
            }
        }

        return $entity;
    }

    public function getDataProperties(): array
    {
        $data = [
            'id' => $this->getId(),
            'street' => $this->getStreet(),
            'city' => $this->getCity(),
            'number' => $this->getNumber(),
            'neighborhood' => $this->getNeighborhood(),
            'complement' => $this->getComplement(),
            'state' => $this->getState(),
            'isActive' => $this->getIsActive(),
            'type' => $this->getType(),
            'block' => $this->getBlock(),
            'importance' => $this->getImportance(),
            'postalCode' => $this->getPostalCode(),
            'tenantId' => $this->getTenantId(),
            'userId' => $this->getUserId(),
            'userUpdateId' => $this->getUserUpdateId(),
            'active' => $this->getActive(),
        ];

        return array_filter($data, fn ($value) => $value !== null && $value !== '');
    }
}
