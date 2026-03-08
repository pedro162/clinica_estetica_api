<?php

namespace App\Application\Commands\Neighborhood;

class UpdateNeighborhoodCommand
{
    protected ?string $id = null;
    protected ?string $name = null;
    protected ?string $codIbge = null;
    protected ?string $cep = null;
    protected ?string $cityId = null;
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

    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function codIbge(string $codIbge): self
    {
        $this->codIbge = $codIbge;
        return $this;
    }

    public function cep(string $cep): self
    {
        $this->cep = $cep;
        return $this;
    }

    public function cityId(string $cityId): self
    {
        $this->cityId = $cityId;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getCodIbge(): ?string
    {
        return $this->codIbge;
    }

    public function getCep(): ?string
    {
        return $this->cep;
    }

    public function getCityId(): ?string
    {
        return $this->cityId;
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
            ['keys' => ['id'], 'callback' => fn ($v) => $entity->id((string) $v)],
            ['keys' => ['name'], 'callback' => fn ($v) => $entity->name((string) $v)],
            ['keys' => ['codIbge'], 'callback' => fn ($v) => $entity->codIbge((string) $v)],
            ['keys' => ['cep'], 'callback' => fn ($v) => $entity->cep((string) $v)],
            ['keys' => ['cidade_id', 'cityId'], 'callback' => fn ($v) => $entity->cityId((string) $v)],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn ($v) => $entity->tenantId((string) $v)],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn ($v) => $entity->userUpdateId((string) $v)],
            ['keys' => ['active'], 'callback' => fn ($v) => $entity->active((string) $v)],
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
            'id' => (string) ($this->id ?? ''),
            'name' => (string) ($this->name ?? ''),
            'codIbge' => (string) ($this->codIbge ?? ''),
            'cep' => (string) ($this->cep ?? ''),
            'cityId' => (string) ($this->cityId ?? ''),
            'tenantId' => (string) ($this->tenantId ?? ''),
            'userUpdateId' => (string) ($this->userUpdateId ?? ''),
            'active' => (string) ($this->active ?? ''),
        ];

        return array_filter($data, fn ($v) => $v !== '' && $v !== null);
    }
}
