<?php

declare(strict_types=1);

namespace App\Domain\WorkOrderCancelingMotive\Entities;

use App\Domain\BaseEntity\Entities\BaseEntity;
use App\Domain\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\WorkOrderCancelingMotive\ValueObjects\WorkOrderCancelingMotiveDescription;
use App\Domain\WorkOrderCancelingMotive\ValueObjects\WorkOrderCancelingMotiveId;
use App\Domain\WorkOrderCancelingMotive\ValueObjects\WorkOrderCancelingMotivePersonId;
use App\MotivoCancelamentoOrdemServico as CancelingMotiveModel;

class WorkOrderCancelingMotive extends BaseEntity
{
    protected ?WorkOrderCancelingMotiveId $id = null;
    protected ?WorkOrderCancelingMotiveDescription $motive = null;
    protected ?WorkOrderCancelingMotivePersonId $personId = null;

    public function id(WorkOrderCancelingMotiveId $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?WorkOrderCancelingMotiveId
    {
        return $this->id ?? null;
    }

    public function motive(WorkOrderCancelingMotiveDescription $motive): self
    {
        $this->motive = $motive;

        return $this;
    }

    public function getMotive(): ?WorkOrderCancelingMotiveDescription
    {
        return $this->motive ?? null;
    }

    public function personId(WorkOrderCancelingMotivePersonId $personId): self
    {
        $this->personId = $personId;

        return $this;
    }

    public function getPersonId(): ?WorkOrderCancelingMotivePersonId
    {
        return $this->personId ?? null;
    }

    public static function buildEntity(array $data): self
    {
        $entity = new self();

        $mapping = [
            ['keys' => ['id'], 'callback' => function ($value) use ($entity): void {
                $entity->id(new WorkOrderCancelingMotiveId((string) $value));
            }],
            ['keys' => ['motivo', 'motive'], 'callback' => function ($value) use ($entity): void {
                $entity->motive(new WorkOrderCancelingMotiveDescription((string) $value));
            }],
            ['keys' => ['pessoa_id', 'person_id'], 'callback' => function ($value) use ($entity): void {
                $entity->personId(new WorkOrderCancelingMotivePersonId((string) $value));
            }],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => function ($value) use ($entity): void {
                $entity->tenantId(new BaseEntityTenantId((string) $value));
            }],
            ['keys' => ['userId', 'user_id'], 'callback' => function ($value) use ($entity): void {
                $entity->userId(new BaseEntityUserId((string) $value));
            }],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => function ($value) use ($entity): void {
                $entity->userUpdateId(new BaseEntityUserId((string) $value));
            }],
            ['keys' => ['active'], 'callback' => function ($value) use ($entity): void {
                $entity->active((string) $value);
            }],
        ];

        foreach ($mapping as $map) {
            foreach ($map['keys'] as $key) {
                if (array_key_exists($key, $data) && $data[$key] !== null) {
                    $map['callback']($data[$key]);
                    break;
                }
            }
        }

        return $entity;
    }

    public function build(): CancelingMotiveModel
    {
        $data = [
            'id' => $this->id ? (string) $this->id : null,
            'motivo' => $this->motive ? (string) $this->motive : null,
            'pessoa_id' => $this->personId ? (string) $this->personId : null,
            'tenant_id' => isset($this->tenantId) ? (string) $this->tenantId : null,
            'user_id' => isset($this->userId) ? (string) $this->userId : null,
            'user_update_id' => isset($this->userUpdateId) ? (string) $this->userUpdateId : null,
            'active' => $this->active ?? null,
        ];

        $data = array_filter($data, static function ($value): bool {
            return $value !== null;
        });

        return new CancelingMotiveModel($data);
    }
}
