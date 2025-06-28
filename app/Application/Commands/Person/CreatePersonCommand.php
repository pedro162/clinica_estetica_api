<?php

namespace App\Application\Commands\Person;

use App\Application\Commands\BasePersonCommand;

class CreatePersonCommand extends BasePersonCommand
{
    public function personId(string $personId): CreatePersonCommand
    {
        $this->personId = $personId;
        return $this;
    }

    public function personName(string $personName): CreatePersonCommand
    {
        $this->personName = $personName;
        return $this;
    }

    public function personDocument(string $personDocument): CreatePersonCommand
    {
        $this->personDocument = $personDocument;
        return $this;
    }

    public function personOptionalName(string $personOptionalName): CreatePersonCommand
    {
        $this->personOptionalName = $personOptionalName;
        return $this;
    }

    public function personExtraDocument(string $personExtraDocument): CreatePersonCommand
    {
        $this->personExtraDocument = $personExtraDocument;
        return $this;
    }

    public function personSex(string $personSex): CreatePersonCommand
    {
        $this->personSex = $personSex;
        return $this;
    }

    public function personEmail(string $personEmail): CreatePersonCommand
    {
        $this->personEmail = $personEmail;
        return $this;
    }

    public function personBirthOrFoundation(string $personBirthOrFoundation): CreatePersonCommand
    {
        $this->personBirthOrFoundation = $personBirthOrFoundation;
        return $this;
    }

    public function personType(string $personType): CreatePersonCommand
    {
        $this->personType = $personType;
        return $this;
    }

    public function personUserId(string $personUserId): CreatePersonCommand
    {
        $this->personUserId = $personUserId;
        return $this;
    }

    public function personUserUpdateId(string $personUserUpdateId): CreatePersonCommand
    {
        $this->personUserUpdateId = $personUserUpdateId;
        return $this;
    }

    public function personTenantId(string $personTenantId): CreatePersonCommand
    {
        $this->personTenantId = $personTenantId;
        return $this;
    }

    public function personActive(string $personActive): CreatePersonCommand
    {
        $this->personActive = $personActive;
        return $this;
    }

    public static function build(array $data): CreatePersonCommand
    {
        $entity = (new self());
        $mapping = [
            ['keys' => ['id'], 'callback' => fn($value) => $entity->personId($value)],
            ['keys' => ['name'], 'callback' => fn($value) => $entity->personName((string)$value)],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn($value) => $entity->personTenantId((string)$value)],
            ['keys' => ['active'], 'callback' => fn($value) => $entity->personActive((string)$value)],
            ['keys' => ['userId', 'user_id'], 'callback' => fn($value) => $entity->personUserId((string)$value)],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn($value) => $entity->personUserUpdateId((string)$value)],
            ['keys' => ['type', 'tipo'], 'callback' => fn($value) => $entity->personType((string)$value)],
            ['keys' => ['documento', 'document'], 'callback' => fn($value) => $entity->personDocument((string)$value)],
            ['keys' => ['documento_complementar', 'extraDocument'], 'callback' => fn($value) => $entity->personExtraDocument((string)$value)],
            ['keys' => ['nascimento_fundacao', 'birthOrFoundation'], 'callback' => fn($value) => $entity->personBirthOrFoundation((string)$value)],
            ['keys' => ['email'], 'callback' => fn($value) => $entity->personEmail((string)$value)],
            ['keys' => ['name_opcional', 'optionalName'], 'callback' => fn($value) => $entity->personOptionalName((string)$value)],
            ['keys' => ['sexo', 'sex'], 'callback' => fn($value) => $entity->personSex((string)$value)],
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
            'id' => $this->personId ?? '',
            'name' => $this->personName ?? '',
            'optionalName' => $this->personOptionalName ?? '',
            'type' => $this->personType ?? '',
            'tenantId' => $this->personTenantId ?? '',
            'userId' => $this->personUserId ?? '',
            'userUpdateId' => $this->personUserUpdateId ?? '',
            'active' => $this->personActive ?? '',
            'document' => $this->personDocument ?? '',
            'extraDocument' => $this->personExtraDocument ?? '',
            'birthOrFoundation' => $this->personBirthOrFoundation ?? '',
            'email' => $this->personEmail ?? '',
            'sex' => $this->personSex ?? '',
        ];

        return  array_filter($data, fn($value) => $value !== null && trim($value) != '');
    }
}
