<?php

namespace App\Application\Commands\AccountReceivableItem;

use App\Utilitarios;

class CreateAccountReceivableItemCommand
{

    protected string $id;
    protected string $description;
    protected string $userId;
    protected string $userUpdateId;
    protected string $tenantId;
    protected string $active;
    protected string $branchId;


    public function id(string $id): CreateAccountReceivableItemCommand
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id ?? null;
    }

    public function tenantId(string $tenantId): CreateAccountReceivableItemCommand
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function getTenantId(): ?string
    {
        return $this->tenantId ?? null;
    }

    public function description(string $description): CreateAccountReceivableItemCommand
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description ?? null;
    }

    public function userId(string $userId): CreateAccountReceivableItemCommand
    {
        $this->userId = $userId;
        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->userId ?? null;
    }

    public function userUpdateId(string $userUpdateId): CreateAccountReceivableItemCommand
    {
        $this->userUpdateId = $userUpdateId;
        return $this;
    }

    public function getUserUpdateId(): ?string
    {
        return $this->userUpdateId ?? null;
    }

    public function active(string $active): CreateAccountReceivableItemCommand
    {
        $this->active = $active;
        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active ?? null;
    }

    public function branchId(string $branchId): CreateAccountReceivableItemCommand
    {
        $this->branchId = $branchId;
        return $this;
    }

    public function getBranchId(): ?string
    {
        return $this->branchId ?? null;
    }

    public static function build(array $data): CreateAccountReceivableItemCommand
    {
        $minValue = Utilitarios::removeMaskMoney($data['vrMin'] ?? $data['minValue'] ?? 0);
        $maxValue = Utilitarios::removeMaskMoney($data['vrMax'] ?? $data['maxValue'] ?? 0);
        $balance = Utilitarios::removeMaskMoney($data['balance'] ?? $data['vrSaldo'] ?? 0);

        $entity = (new self)
            ->id((string)($data['id'] ?? 0))
            ->description((string)($data['description'] ?? ''))
            ->tenantId((string)($data['tenantId'] ?? ''))
            ->userId((string)($data['userId'] ?? \Auth::User()->id))
            ->userUpdateId((string)($data['userId'] ?? \Auth::User()->id))
            ->active((string)($data['active'] ?? 'yes'))
            ->branchId((string)($data['filial_id'] ?? $data['branchId'] ?? ''));

        return $entity;
    }

    public function getDataProperties(): array
    {
        return [
            'id' => (string)($this->id ?? ''),
            'description' => (string)($this->description ?? ''),
            'tenantId' => (string)($this->tenantId ?? ''),
            'userId' => (string)($this->userId ?? ''),
            'userUpdateId' => (string)($this->userUpdateId ?? ''),
            'active' => (string)($this->active ?? ''),
            'branchId' => (string)($this->branchId ?? ''),
        ];
    }
}
