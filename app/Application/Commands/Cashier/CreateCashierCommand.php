<?php

namespace App\Application\Commands\Cashier;

class CreateCashierCommand
{

    protected string $id;
    protected string $name;
    protected string $code;
    protected string $userId;
    protected string $userUpdateId;
    protected string $tenantId;
    protected string $stateId;
    protected string $active;
    protected string $slug;

    public function id(string $id): CreateCashierCommand
    {
        $this->id = $id;
        return $this;
    }

    public function tenantId(string $tenantId): CreateCashierCommand
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function name(string $name): CreateCashierCommand
    {
        $this->name = $name;
        return $this;
    }

    public function code(string $code): CreateCashierCommand
    {
        $this->code = $code;
        return $this;
    }

    public function userId(string $userId): CreateCashierCommand
    {
        $this->userId = $userId;
        return $this;
    }

    public function userUpdateId(string $userUpdateId): CreateCashierCommand
    {
        $this->userUpdateId = $userUpdateId;
        return $this;
    }

    public function active(string $active): CreateCashierCommand
    {
        $this->active = $active;
        return $this;
    }

    public function stateId(string $stateId): CreateCashierCommand
    {
        $this->stateId = $stateId;
        return $this;
    }

    public function slug(string $slug): CreateCashierCommand
    {
        $this->slug = $slug;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id ?? null;
    }

    public function getTenantId(): ?string
    {
        return $this->tenantId ?? null;
    }

    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    public function getCode(): ?string
    {
        return $this->code ?? null;
    }

    public function getUserId(): ?string
    {
        return $this->userId ?? null;
    }

    public function getUserUpdateId(): ?string
    {
        return $this->userUpdateId ?? null;
    }

    public function getActive(): ?string
    {
        return $this->active ?? null;
    }

    public function getStateId(): ?string
    {
        return $this->stateId ?? null;
    }

    public function getSlug(): ?string
    {
        return $this->slug ?? null;
    }

    public static function build(array $data): CreateCashierCommand
    {
        $entity = (new self)
            ->id((string)($data['id'] ?? 0))
            ->name((string)($data['name'] ?? $data['nmCidade'] ?? ''))
            ->code((string)($data['code'] ?? $data['cdCidade'] ?? ''))
            ->tenantId((string)($data['tenantId'] ?? ''))
            ->stateId((string)($data['estado_id'] ?? $data['estado'] ?? ''))
            ->userId((string)($data['userId'] ?? \Auth::User()->id))
            ->userUpdateId((string)($data['userId'] ?? \Auth::User()->id))
            ->active((string)($data['active'] ?? 'yes'))
            ->slug((string)($data['sigla'] ?? $data['slug'] ?? ''));

        return $entity;
    }

    public function getDataProperties(): array
    {
        return [
            'id' => (string)($this->id ?? ''),
            'name' => (string)($this->name ?? ''),
            'code' => (string)($this->code ?? ''),
            'slug' => (string)($this->slug ?? ''),
            'tenantId' => (string)($this->tenantId ?? ''),
            'stateId' => (string)($this->stateId ?? ''),
            'userId' => (string)($this->userId ?? ''),
            'userUpdateId' => (string)($this->userUpdateId ?? ''),
            'active' => (string)($this->active ?? ''),
        ];
    }
}
