<?php

namespace App\Domain\Seller\Entities;

use App\Domain\BaseEntity\Entities\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\Seller\ValueObjects\SellerAccessAllRcas;
use App\Domain\Seller\ValueObjects\SellerBranchId;
use App\Domain\Seller\ValueObjects\SellerGoalFaturamento;
use App\Domain\Seller\ValueObjects\SellerGoalMargem;
use App\Domain\Seller\ValueObjects\SellerGoalPositivacao;
use App\Domain\Seller\ValueObjects\SellerId;
use App\Domain\Seller\ValueObjects\SellerPersonId;
use App\Domain\Seller\ValueObjects\SellerStatus;
use App\Rca;

class Seller extends BaseEntity
{
    protected SellerId $id;
    protected SellerBranchId $branchId;
    protected ?SellerPersonId $personId = null;
    protected ?SellerAccessAllRcas $accessAll = null;
    protected ?SellerStatus $status = null;
    protected ?SellerGoalPositivacao $positivityGoal = null;
    protected ?SellerGoalMargem $marginGoal = null;
    protected ?SellerGoalFaturamento $revenueGoal = null;

    public function id(SellerId $id): Seller
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?SellerId
    {
        return $this->id ?? null;
    }

    public function branchId(SellerBranchId $branchId): Seller
    {
        $this->branchId = $branchId;
        return $this;
    }

    public function getBranchId(): ?SellerBranchId
    {
        return $this->branchId ?? null;
    }

    public function tenantId(BaseEntityTenantId $tenantId): Seller
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function getTenantId(): ?BaseEntityTenantId
    {
        return $this->tenantId ?? null;
    }

    public function userId(BaseEntityUserId $userId): Seller
    {
        $this->userId = $userId;
        return $this;
    }

    public function getUserId(): ?BaseEntityUserId
    {
        return $this->userId ?? null;
    }

    public function userUpdateId(BaseEntityUserId $userUpdateId): Seller
    {
        $this->userUpdateId = $userUpdateId;
        return $this;
    }

    public function getUserUpdateId(): ?BaseEntityUserId
    {
        return $this->userUpdateId ?? null;
    }

    public function personId(SellerPersonId $personId): Seller
    {
        $this->personId = $personId;
        return $this;
    }

    public function getPersonId(): ?SellerPersonId
    {
        return $this->personId ?? null;
    }

    public function accessAll(SellerAccessAllRcas $accessAll): Seller
    {
        $this->accessAll = $accessAll;
        return $this;
    }

    public function getAccessAll(): ?SellerAccessAllRcas
    {
        return $this->accessAll ?? null;
    }

    public function status(SellerStatus $status): Seller
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): ?SellerStatus
    {
        return $this->status ?? null;
    }

    public function positivityGoal(SellerGoalPositivacao $goal): Seller
    {
        $this->positivityGoal = $goal;
        return $this;
    }

    public function getPositivityGoal(): ?SellerGoalPositivacao
    {
        return $this->positivityGoal ?? null;
    }

    public function marginGoal(SellerGoalMargem $goal): Seller
    {
        $this->marginGoal = $goal;
        return $this;
    }

    public function getMarginGoal(): ?SellerGoalMargem
    {
        return $this->marginGoal ?? null;
    }

    public function revenueGoal(SellerGoalFaturamento $goal): Seller
    {
        $this->revenueGoal = $goal;
        return $this;
    }

    public function getRevenueGoal(): ?SellerGoalFaturamento
    {
        return $this->revenueGoal ?? null;
    }

    public function active(string $active): Seller
    {
        $this->active = $active;
        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active ?? null;
    }

    public static function buildEntity(array $data): Seller
    {
        $entity = new self();

        $mapping = [
            ['keys' => ['id'], 'callback' => fn ($v) => $entity->id(new SellerId($v))],
            ['keys' => ['branchId', 'filial_id'], 'callback' => fn ($v) => $entity->branchId(new SellerBranchId((string)$v))],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn ($v) => $entity->tenantId(new BaseEntityTenantId((string)$v))],
            ['keys' => ['userId', 'user_id'], 'callback' => fn ($v) => $entity->userId(new BaseEntityUserId((string)$v))],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn ($v) => $entity->userUpdateId(new BaseEntityUserId((string)$v))],
            ['keys' => ['personId', 'pessoa_id'], 'callback' => fn ($v) => $entity->personId(new SellerPersonId((string)$v))],
            ['keys' => ['accessAll', 'accessAllRcas', 'acessaTodosRcas'], 'callback' => fn ($v) => $entity->accessAll(new SellerAccessAllRcas((string)$v))],
            ['keys' => ['status', 'situacao'], 'callback' => fn ($v) => $entity->status(new SellerStatus((string)$v))],
            ['keys' => ['positivityGoal', 'metaPositivacao'], 'callback' => fn ($v) => $entity->positivityGoal(new SellerGoalPositivacao((float)$v))],
            ['keys' => ['marginGoal', 'metaMargem'], 'callback' => fn ($v) => $entity->marginGoal(new SellerGoalMargem((float)$v))],
            ['keys' => ['revenueGoal', 'metaFaturamento'], 'callback' => fn ($v) => $entity->revenueGoal(new SellerGoalFaturamento((float)$v))],
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

    public function build(): Rca
    {
        $data = [
            'filial_id' => isset($this->branchId) ? (string)$this->branchId : null,
            'pessoa_id' => isset($this->personId) ? (string)$this->personId : null,
            'acessaTodosRcas' => isset($this->accessAll) ? (string)$this->accessAll : null,
            'situacao' => isset($this->status) ? (string)$this->status : null,
            'metaPositivacao' => isset($this->positivityGoal) ? (string)$this->positivityGoal : null,
            'metaMargem' => isset($this->marginGoal) ? (string)$this->marginGoal : null,
            'metaFaturamento' => isset($this->revenueGoal) ? (string)$this->revenueGoal : null,
            'active' => isset($this->active) ? (string)$this->active : null,
            'user_id' => isset($this->userId) ? (string)$this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string)$this->userUpdateId : null,
            'tenant_id' => isset($this->tenantId) ? (string)$this->tenantId : null,
        ];

        $data = array_filter($data, fn ($v) => $v !== null);

        return new Rca($data);
    }
}
