<?php

namespace App\Application\Commands\Seller;

class CreateSellerCommand
{
    protected ?string $id = null;
    protected ?string $userId = null;
    protected ?string $userUpdateId = null;
    protected ?string $tenantId = null;
    protected ?string $active = null;
    protected ?string $branchId = null;
    protected ?string $personId = null;
    protected ?string $accessAll = null;
    protected ?string $status = null;
    protected ?string $positivityGoal = null;
    protected ?string $marginGoal = null;
    protected ?string $revenueGoal = null;

    public function id(string $id): CreateSellerCommand
    {
        $this->id = $id;
        return $this;
    }

    public function tenantId(string $tenantId): CreateSellerCommand
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function userId(string $userId): CreateSellerCommand
    {
        $this->userId = $userId;
        return $this;
    }

    public function userUpdateId(string $userUpdateId): CreateSellerCommand
    {
        $this->userUpdateId = $userUpdateId;
        return $this;
    }

    public function active(string $active): CreateSellerCommand
    {
        $this->active = $active;
        return $this;
    }

    public function branchId(string $branchId): CreateSellerCommand
    {
        $this->branchId = $branchId;
        return $this;
    }

    public function personId(string $personId): CreateSellerCommand
    {
        $this->personId = $personId;
        return $this;
    }

    public function accessAll(string $accessAll): CreateSellerCommand
    {
        $this->accessAll = $accessAll;
        return $this;
    }

    public function status(string $status): CreateSellerCommand
    {
        $this->status = $status;
        return $this;
    }

    public function positivityGoal(string $value): CreateSellerCommand
    {
        $this->positivityGoal = $value;
        return $this;
    }

    public function marginGoal(string $value): CreateSellerCommand
    {
        $this->marginGoal = $value;
        return $this;
    }

    public function revenueGoal(string $value): CreateSellerCommand
    {
        $this->revenueGoal = $value;
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

    public function getBranchId(): ?string
    {
        return $this->branchId;
    }

    public function getPersonId(): ?string
    {
        return $this->personId;
    }

    public function getAccessAll(): ?string
    {
        return $this->accessAll;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getPositivityGoal(): ?string
    {
        return $this->positivityGoal;
    }

    public function getMarginGoal(): ?string
    {
        return $this->marginGoal;
    }

    public function getRevenueGoal(): ?string
    {
        return $this->revenueGoal;
    }

    public static function build(array $data): CreateSellerCommand
    {
        $entity = new self();

        $mapping = [
            ['keys' => ['id'], 'callback' => fn ($v) => $entity->id((string)$v)],
            ['keys' => ['branchId', 'filial_id'], 'callback' => fn ($v) => $entity->branchId((string)$v)],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn ($v) => $entity->tenantId((string)$v)],
            ['keys' => ['userId', 'user_id'], 'callback' => fn ($v) => $entity->userId((string)$v)],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn ($v) => $entity->userUpdateId((string)$v)],
            ['keys' => ['personId', 'pessoa_id'], 'callback' => fn ($v) => $entity->personId((string)$v)],
            ['keys' => ['accessAll', 'accessAllRcas', 'acessaTodosRcas'], 'callback' => fn ($v) => $entity->accessAll((string)$v)],
            ['keys' => ['status', 'situacao'], 'callback' => fn ($v) => $entity->status((string)$v)],
            ['keys' => ['positivityGoal', 'metaPositivacao'], 'callback' => fn ($v) => $entity->positivityGoal((float)$v)],
            ['keys' => ['marginGoal', 'metaMargem'], 'callback' => fn ($v) => $entity->marginGoal((float)$v)],
            ['keys' => ['revenueGoal', 'metaFaturamento'], 'callback' => fn ($v) => $entity->revenueGoal((float)$v)],
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
            'stateId' => (string)($this->stateId ?? ''),
            'branchId' => (string)($this->branchId ?? ''),
            'personId' => (string)($this->personId ?? ''),
            'accessAllRcas' => (string)($this->accessAll ?? ''),
            'status' => (string)($this->status ?? ''),
            'metaPositivacao' => (string)($this->positivityGoal ?? ''),
            'metaMargem' => (string)($this->marginGoal ?? ''),
            'metaFaturamento' => (string)($this->revenueGoal ?? ''),
            'userId' => (string)($this->userId ?? ''),
            'userUpdateId' => (string)($this->userUpdateId ?? ''),
            'active' => (string)($this->active ?? ''),
        ];

        return array_filter($data, fn ($v) => $v !== '' && $v !== null);
    }
}
