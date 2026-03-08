<?php

declare(strict_types=1);

namespace App\Application\Commands\CreditCardBrand;

class CreateCreditCardBrandCommand
{
    protected string $id;
    protected string $name;
    protected string $type;
    protected string $userId;
    protected string $userUpdateId;
    protected string $tenantId;
    protected string $active;
    protected string $personAuthorId;
    protected string $standard;

    public function id(string $id): CreateCreditCardBrandCommand
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id ?? null;
    }

    public function tenantId(string $tenantId): CreateCreditCardBrandCommand
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function getTenantId(): ?string
    {
        return $this->tenantId ?? null;
    }

    public function name(string $name): CreateCreditCardBrandCommand
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    public function userId(string $userId): CreateCreditCardBrandCommand
    {
        $this->userId = $userId;
        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->userId ?? null;
    }

    public function userUpdateId(string $userUpdateId): CreateCreditCardBrandCommand
    {
        $this->userUpdateId = $userUpdateId;
        return $this;
    }

    public function getUserUpdateId(): ?string
    {
        return $this->userUpdateId ?? null;
    }

    public function active(string $active): CreateCreditCardBrandCommand
    {
        $this->active = $active;
        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active ?? null;
    }

    public function personAuthorId(string $personAuthorId): CreateCreditCardBrandCommand
    {
        $this->personAuthorId = $personAuthorId;
        return $this;
    }

    public function getPersonAuthorId(): ?string
    {
        return $this->personAuthorId ?? null;
    }

    public function standard(string $standard): CreateCreditCardBrandCommand
    {
        $this->standard = $standard;
        return $this;
    }

    public function getStandard(): ?string
    {
        return $this->standard ?? null;
    }

    public static function build(array $data): CreateCreditCardBrandCommand
    {
        $entity = (new self());
        $mapping = [
            ['keys' => ['id'], 'callback' => fn ($value) => $entity->id((string)$value)],
            ['keys' => ['name'], 'callback' => fn ($value) => $entity->name((string)$value)],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn ($value) => $entity->tenantId((string)$value)],
            ['keys' => ['active'], 'callback' => fn ($value) => $entity->active((string)$value)],
            ['keys' => ['userId', 'user_id'], 'callback' => fn ($value) => $entity->userId((string)$value)],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn ($value) => $entity->userUpdateId((string)$value)],
            ['keys' => ['standard', 'standard'], 'callback' => fn ($value) => $entity->standard((string)$value)],
            ['keys' => ['personAuthorId', 'pessoa_autor_id'], 'callback' => fn ($value) => $entity->personAuthorId((string)$value)],
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
            'id' => $this->getId() ?? '',
            'name' => $this->getName() ?? '',
            'tenantId' => $this->getTenantId() ?? '',
            'userId' => $this->getUserId() ?? '',
            'userUpdateId' => $this->getUserUpdateId() ?? '',
            'active' => $this->getActive() ?? '',
            'personAuthorId' => $this->getPersonAuthorId() ?? '',
            'standard' => $this->getStandard() ?? '',
        ];

        return array_filter($data, fn ($value) => $value !== null && !empty($value));
    }

    public function toArray(): array
    {
        return $this->getDataProperties();
    }
}
