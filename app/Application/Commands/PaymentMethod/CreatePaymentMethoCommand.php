<?php

namespace App\Application\Commands\PaymentMethod;

use App\Utilitarios;
use Exception;

class CreatePaymentMethodCommand
{

    protected string $id;
    protected string $name;
    protected string $type;
    protected string $userId;
    protected string $userUpdateId;
    protected string $tenantId;
    protected string $active;
    protected string $branchId;


    public function id(string $id): CreatePaymentMethodCommand
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id ?? null;
    }

    public function tenantId(string $tenantId): CreatePaymentMethodCommand
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function getTenantId(): ?string
    {
        return $this->tenantId ?? null;
    }

    public function name(string $name): CreatePaymentMethodCommand
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    public function type(string $type): CreatePaymentMethodCommand
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type ?? null;
    }

    public function userId(string $userId): CreatePaymentMethodCommand
    {
        $this->userId = $userId;
        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->userId ?? null;
    }

    public function userUpdateId(string $userUpdateId): CreatePaymentMethodCommand
    {
        $this->userUpdateId = $userUpdateId;
        return $this;
    }

    public function getUserUpdateId(): ?string
    {
        return $this->userUpdateId ?? null;
    }

    public function active(string $active): CreatePaymentMethodCommand
    {
        $this->active = $active;
        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active ?? null;
    }

    public static function build(array $data): CreatePaymentMethodCommand
    {
        $entity = (new self)
            ->id((string)($data['id'] ?? 0))
            ->name((string)($data['name'] ?? ''))
            ->type((string)($data['type'] ?? ''))
            ->tenantId((string)($data['tenantId'] ?? $data['tenant_id'] ?? ''))
            ->userId((string)($data['userId'] ?? $data['user_id'] ?? \Auth::User()->id))
            ->userUpdateId((string)($data['userUpdateId'] ?? $data['user_update_id'] ?? \Auth::User()->id))
            ->active((string)($data['active'] ?? 'yes'));

        return $entity;
    }

    public function getDataProperties(): array
    {
        $data = [
            'id' => (string)($this->id ?? ''),
            'name' => (string)($this->name ?? ''),
            'type' => (string)($this->type ?? ''),
            'tenantId' => (string)($this->tenantId ?? ''),
            'userId' => (string)($this->userId ?? ''),
            'userUpdateId' => (string)($this->userUpdateId ?? ''),
            'active' => (string)($this->active ?? ''),
            'branchId' => (string)($this->branchId ?? ''),
        ];

        return array_filter($data, function ($value) {
            return $value !== null && !empty($value);
        });
    }
}
