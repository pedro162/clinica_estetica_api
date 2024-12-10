<?php

namespace App\Application\Commands\AccountReceivable;

use App\Utilitarios;

class CreateAccountReceivableCommand
{

    protected string $id;
    protected string $description;
    protected string $userId;
    protected string $userUpdateId;
    protected string $tenantId;
    protected string $active;
    protected string $branchId;


    public function id(string $id): CreateAccountReceivableCommand
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id ?? null;
    }

    public function tenantId(string $tenantId): CreateAccountReceivableCommand
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function getTenantId(): ?string
    {
        return $this->tenantId ?? null;
    }

    public function description(string $description): CreateAccountReceivableCommand
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description ?? null;
    }

    public function userId(string $userId): CreateAccountReceivableCommand
    {
        $this->userId = $userId;
        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->userId ?? null;
    }

    public function userUpdateId(string $userUpdateId): CreateAccountReceivableCommand
    {
        $this->userUpdateId = $userUpdateId;
        return $this;
    }

    public function getUserUpdateId(): ?string
    {
        return $this->userUpdateId ?? null;
    }

    public function active(string $active): CreateAccountReceivableCommand
    {
        $this->active = $active;
        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active ?? null;
    }

    public function branchId(string $branchId): CreateAccountReceivableCommand
    {
        $this->branchId = $branchId;
        return $this;
    }

    public function getBranchId(): ?string
    {
        return $this->branchId ?? null;
    }

    public static function build(array $data): CreateAccountReceivableCommand
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
