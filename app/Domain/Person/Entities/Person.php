<?php

namespace App\Domain\Person\Entities;

use App\Domain\BaseEntity\Entities\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\Person\ValueObjects\PersonBirthOrFoundation;
use App\Domain\Person\ValueObjects\PersonDocument;
use App\Domain\Person\ValueObjects\PersonEmail;
use App\Domain\Person\ValueObjects\PersonExtraDocument;
use App\Domain\Person\ValueObjects\PersonId;
use App\Domain\Person\ValueObjects\PersonName;
use App\Domain\Person\ValueObjects\PersonOptionalName;
use App\Domain\Person\ValueObjects\PersonSex;
use App\Domain\Person\ValueObjects\PersonType;
use App\Pessoa;

class Person extends BaseEntity
{
    protected PersonId $id;
    protected PersonName $name;
    protected PersonOptionalName $optionalName;
    protected PersonDocument $document;
    protected PersonExtraDocument $extraDocument;
    protected PersonEmail $email;
    protected PersonSex $sex;
    protected PersonBirthOrFoundation $birthOrFoundation;
    protected PersonType $type;

    public function setId(PersonId $id): void
    {
        $this->id = $id;
    }

    public function id(PersonId $id): Person
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?PersonId
    {
        return $this->id ?? null;
    }

    public function setType(PersonType $type): void
    {
        $this->type = $type;
    }

    public function type(PersonType $type): Person
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): ?PersonType
    {
        return $this->type ?? null;
    }

    public function setBirthOrFoundation(PersonBirthOrFoundation $birthOrFoundation): void
    {
        $this->birthOrFoundation = $birthOrFoundation;
    }

    public function birthOrFoundation(PersonBirthOrFoundation $birthOrFoundation): Person
    {
        $this->birthOrFoundation = $birthOrFoundation;
        return $this;
    }

    public function getBirthOrFoundation(): ?PersonBirthOrFoundation
    {
        return $this->birthOrFoundation ?? null;
    }

    public function setName(PersonName $name): void
    {
        $this->name = $name;
    }

    public function name(PersonName $name): Person
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?PersonName
    {
        return $this->name ?? null;
    }

    public function setOptionalName(PersonOptionalName $optionalName): void
    {
        $this->optionalName = $optionalName;
    }

    public function getOptionalName(): ?PersonOptionalName
    {
        return $this->optionalName ?? null;
    }

    public function optionalName(PersonOptionalName $optionalName): Person
    {
        $this->optionalName = $optionalName;
        return $this;
    }

    public function setDocument(PersonDocument $document): void
    {
        $this->document = $document;
    }

    public function document(PersonDocument $document): Person
    {
        $this->document = $document;
        return $this;
    }

    public function getDocument(): ?PersonDocument
    {
        return $this->document ?? null;
    }

    public function setExtraDocument(PersonExtraDocument $extraDocument): void
    {
        $this->extraDocument = $extraDocument;
    }

    public function extraDocument(PersonExtraDocument $extraDocument): Person
    {
        $this->extraDocument = $extraDocument;
        return $this;
    }

    public function getExtraDocument(): ?PersonExtraDocument
    {
        return $this->extraDocument ?? null;
    }

    public function setEmail(PersonEmail $email): void
    {
        $this->email = $email;
    }

    public function email(PersonEmail $email): Person
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail(): ?PersonEmail
    {
        return $this->email ?? null;
    }

    public function setSex(PersonSex $sex): void
    {
        $this->sex = $sex;
    }

    public function sex(PersonSex $sex): Person
    {
        $this->sex = $sex;
        return $this;
    }

    public function getSex(): PersonSex
    {
        return $this->sex;
    }

    public static function buildEntity(array $data): Person
    {
        $entity = (new self());
        $mapping = [
            ['keys' => ['id'], 'callback' => fn ($value) => $entity->id(new PersonId($value))],
            ['keys' => ['name'], 'callback' => fn ($value) => $entity->name(new PersonName((string)$value))],
            ['keys' => ['name_opcional', 'optionalName'], 'callback' => fn ($value) => $entity->optionalName(new PersonOptionalName((string)$value))],
            ['keys' => ['documento', 'document'], 'callback' => fn ($value) => $entity->document(new PersonDocument((string)$value))],
            ['keys' => ['documento_complementar', 'extraDocument'], 'callback' => fn ($value) => $entity->extraDocument(new PersonExtraDocument((string)$value))],
            ['keys' => ['nascimento_fundacao', 'birthOrFoundation'], 'callback' => fn ($value) => $entity->birthOrFoundation(new PersonBirthOrFoundation((string)$value))],
            ['keys' => ['email'], 'callback' => fn ($value) => $entity->email(new PersonEmail((string)$value))],
            ['keys' => ['sex', 'sexo'], 'callback' => fn ($value) => $entity->sex(new PersonSex((string)$value))],
            ['keys' => ['type'], 'callback' => fn ($value) => $entity->type(new PersonType((string)$value))],
            ['keys' => ['active'], 'callback' => fn ($value) => $entity->active((string)$value)],
            ['keys' => ['userId', 'user_id'], 'callback' => fn ($value) => $entity->userId(new BaseEntityUserId((string)$value))],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn ($value) => $entity->userUpdateId(new BaseEntityUserId((string)$value))],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn ($value) => $entity->tenantId(new BaseEntityTenantId((string)$value))],
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

    public function build(): Pessoa
    {
        $data = [
            'id' => isset($this->id) ? (string)$this->id : null,
            'name' => isset($this->name) ? (string)$this->name : null,
            'name_opcional' => isset($this->optionalName) ? (string)$this->optionalName : null,
            'documento' => isset($this->document) ? (string)$this->document : null,
            'documento_complementar' => isset($this->extraDocument) ? (string)$this->extraDocument : null,
            'email' => isset($this->email) ? (string)$this->email : null,
            'nascimento_fundacao' => isset($this->birthOrFoundation) ? (string)$this->birthOrFoundation : null,
            'sexo' => isset($this->sex) ? (string) $this->sex : null,
            'tipo' => isset($this->type) ? (string)$this->type : null,
            'tenant_id' => isset($this->tenantId) ? (string)$this->tenantId : null,
            'active' => isset($this->active) ? (string)$this->active : null,
            'user_id' => isset($this->userId) ? (string)$this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string)$this->userUpdateId : null,
        ];

        $data = array_filter($data, function ($value) {
            return $value !== null;
        });

        return new Pessoa($data);
    }
}
