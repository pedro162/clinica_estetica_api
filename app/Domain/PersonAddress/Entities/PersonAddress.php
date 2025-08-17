<?php

namespace App\Domain\PersonAddress\Entities;

use App\Domain\BaseEntity\Entities\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\PersonAddress\ValueObjects\PersonAddressState;
use App\Domain\PersonAddress\ValueObjects\PersonAddressNeighborHood;
use App\Domain\PersonAddress\ValueObjects\PersonAddressNumber;
use App\Domain\PersonAddress\ValueObjects\PersonAddressId;
use App\Domain\PersonAddress\ValueObjects\PersonAddressStreet;
use App\Domain\PersonAddress\ValueObjects\PersonAddressCity;
use App\Domain\PersonAddress\ValueObjects\PersonAddressComplement;
use App\Domain\PersonAddress\ValueObjects\PersonAddressType;
use App\Domain\PersonAddress\ValueObjects\PersonAddressBlock;
use App\Domain\PersonAddress\ValueObjects\PersonAddressImportance;
use App\Domain\PersonAddress\ValueObjects\PersonAddressPostalCode;
use App\Logradouro;

class PersonAddress extends BaseEntity
{
    protected PersonAddressId $id;
    protected PersonAddressStreet $street;
    protected PersonAddressCity $city;
    protected PersonAddressNumber $number;
    protected PersonAddressNeighborHood $neighborhood;
    protected PersonAddressComplement $complement;
    protected PersonAddressState $state;
    protected PersonAddressType $type;
    protected PersonAddressBlock $block;
    protected PersonAddressImportance $importance;
    protected PersonAddressPostalCode $postalCode;

    public function id(PersonAddressId $id): PersonAddress
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?PersonAddressId
    {
        return $this->id ?? null;
    }

    public function type(PersonAddressType $type): PersonAddress
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): ?PersonAddressType
    {
        return $this->type ?? null;
    }

    public function state(PersonAddressState $state): PersonAddress
    {
        $this->state = $state;
        return $this;
    }

    public function getState(): ?PersonAddressState
    {
        return $this->state ?? null;
    }

    public function street(PersonAddressStreet $street): PersonAddress
    {
        $this->street = $street;
        return $this;
    }

    public function getStreet(): ?PersonAddressStreet
    {
        return $this->street ?? null;
    }

    public function getCity(): ?PersonAddressCity
    {
        return $this->city ?? null;
    }

    public function city(PersonAddressCity $city): PersonAddress
    {
        $this->city = $city;
        return $this;
    }

    public function number(PersonAddressNumber $number): PersonAddress
    {
        $this->number = $number;
        return $this;
    }

    public function getNumber(): ?PersonAddressNumber
    {
        return $this->number ?? null;
    }

    public function neighborhood(PersonAddressNeighborHood $neighborhood): PersonAddress
    {
        $this->neighborhood = $neighborhood;
        return $this;
    }

    public function getNeighborhood(): ?PersonAddressNeighborHood
    {
        return $this->neighborhood ?? null;
    }

    public function block(PersonAddressBlock $block): PersonAddress
    {
        $this->block = $block;
        return $this;
    }

    public function getBlock(): ?PersonAddressBlock
    {
        return $this->block ?? null;
    }


    public function postalCode(PersonAddressPostalCode $postalCode): PersonAddress
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function getPostalCode(): ?PersonAddressPostalCode
    {
        return $this->postalCode ?? null;
    }

    public function importance(PersonAddressImportance $importance): PersonAddress
    {
        $this->importance = $importance;
        return $this;
    }

    public function getImportance(): ?PersonAddressImportance
    {
        return $this->importance ?? null;
    }

    public function complement(PersonAddressComplement $complement): PersonAddress
    {
        $this->complement = $complement;
        return $this;
    }

    public function getComplement(): PersonAddressComplement
    {
        return $this->complement;
    }

    public static function buildEntity(array $data): PersonAddress
    {
        $entity = (new self());
        $mapping = [
            ['keys' => ['id'], 'callback' => fn($value) => $entity->id(new PersonAddressId($value))],
            ['keys' => ['logradouro', 'street'], 'callback' => fn($value) => $entity->street(new PersonAddressStreet((string)$value))],
            ['keys' => ['cep', 'postalCode'], 'callback' => fn($value) => $entity->postalCode(new PersonAddressPostalCode((string)$value))],
            ['keys' => ['bloco', 'block'], 'callback' => fn($value) => $entity->block(new PersonAddressBlock((string)$value))],
            ['keys' => ['cidade', 'city'], 'callback' => fn($value) => $entity->city(new PersonAddressCity((string)$value))],
            ['keys' => ['numero', 'number'], 'callback' => fn($value) => $entity->number(new PersonAddressNumber((string)$value))],
            ['keys' => ['estado', 'state'], 'callback' => fn($value) => $entity->state(new PersonAddressState((string)$value))],
            ['keys' => ['bairro', 'neighborhood'], 'callback' => fn($value) => $entity->neighborhood(new PersonAddressNeighborHood((string)$value))],
            ['keys' => ['complemento', 'complement'], 'callback' => fn($value) => $entity->complement(new PersonAddressComplement((string)$value))],
            ['keys' => ['tipo', 'type'], 'callback' => fn($value) => $entity->type(new PersonAddressType((string)$value))],
            ['keys' => ['active'], 'callback' => fn($value) => $entity->active((string)$value)],
            ['keys' => ['userId', 'user_id'], 'callback' => fn($value) => $entity->userId(new BaseEntityUserId((string)$value))],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn($value) => $entity->userUpdateId(new BaseEntityUserId((string)$value))],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn($value) => $entity->tenantId(new BaseEntityTenantId((string)$value))],
            ['keys' => ['importancia', 'importance'], 'callback' => fn($value) => $entity->importance(new PersonAddressImportance((string)$value))],
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

    public function build(): Logradouro
    {
        $data = [
            'id' => isset($this->id) ? (string)$this->id : null,
            'logradouro' => isset($this->street) ? (string)$this->street : null,
            'cidade' => isset($this->city) ? (string)$this->city : null,
            'cep' => isset($this->postalCode) ? (string)$this->postalCode : null,
            'bairro' => isset($this->neighborhood) ? (string)$this->neighborhood : null,
            'estado' => isset($this->state) ? (string)$this->state : null,
            'complemento' => isset($this->complement) ? (string) $this->complement : null,
            'numero' => isset($this->number) ? (string) $this->number : null,
            'bloco' => isset($this->block) ? (string) $this->block : null,
            'importancia' => isset($this->importance) ? (string) $this->importance : null,
            'tipo' => isset($this->type) ? (string)$this->type : null,
            'tenant_id' => isset($this->tenantId) ? (string)$this->tenantId : null,
            'active' => isset($this->active) ? (string)$this->active : null,
            'user_id' => isset($this->userId) ? (string)$this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string)$this->userUpdateId : null,
        ];

        $data = array_filter($data, function ($value) {
            return $value !== null;
        });

        return new Logradouro($data);
    }
}
