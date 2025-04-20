<?php

namespace App\Application\Commands\PaymentPlan;

use App\Utilitarios;
use Exception;

class CreatePaymentPlanCommand
{

    protected string $id;
    protected string $name;
    protected string $userId;
    protected string $userUpdateId;
    protected string $tenantId;
    protected string $active;
    protected string $description;
    protected string $averageDays;
    protected string $installmentQuantity;
    protected string $manualInvoiceSplit;
    protected string $generateInvoiceManually;
    protected string $isActive;
    protected string $isOpen;
    protected string $minInstallments;
    protected string $firstInstallmentDays;
    protected string $installmentIntervalDays;
    protected string $showAtCounter;
    protected string $branchId;

    public function id(string $id): self
    {
        $this->id = $id;
        return $this;
    }
    public function getId(): ?string
    {
        return $this->id ?? null;
    }

    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }
    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    public function description(string $description): self
    {
        $this->description = $description;
        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description ?? null;
    }

    public function averageDays(string $averageDays): self
    {
        $this->averageDays = $averageDays;
        return $this;
    }
    public function getAverageDays(): ?string
    {
        return $this->averageDays ?? null;
    }

    public function installmentQuantity(string $installmentQuantity): self
    {
        $this->installmentQuantity = $installmentQuantity;
        return $this;
    }
    public function getInstallmentQuantity(): ?string
    {
        return $this->installmentQuantity ?? null;
    }

    public function manualInvoiceSplit(string $manualInvoiceSplit): self
    {
        $this->manualInvoiceSplit = $manualInvoiceSplit;
        return $this;
    }
    public function getManualInvoiceSplit(): ?string
    {
        return $this->manualInvoiceSplit ?? null;
    }

    public function generateInvoiceManually(string $generateInvoiceManually): self
    {
        $this->generateInvoiceManually = $generateInvoiceManually;
        return $this;
    }
    public function getGenerateInvoiceManually(): ?string
    {
        return $this->generateInvoiceManually ?? null;
    }

    public function isActive(string $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }
    public function getIsActive(): ?string
    {
        return $this->isActive ?? null;
    }

    public function isOpen(string $isOpen): self
    {
        $this->isOpen = $isOpen;
        return $this;
    }
    public function getIsOpen(): ?string
    {
        return $this->isOpen ?? null;
    }

    public function minInstallments(string $minInstallments): self
    {
        $this->minInstallments = $minInstallments;
        return $this;
    }
    public function getMinInstallments(): ?string
    {
        return $this->minInstallments ?? null;
    }

    public function firstInstallmentDays(string $firstInstallmentDays): self
    {
        $this->firstInstallmentDays = $firstInstallmentDays;
        return $this;
    }
    public function getFirstInstallmentDays(): ?string
    {
        return $this->firstInstallmentDays ?? null;
    }

    public function installmentIntervalDays(string $installmentIntervalDays): self
    {
        $this->installmentIntervalDays = $installmentIntervalDays;
        return $this;
    }
    public function getInstallmentIntervalDays(): ?string
    {
        return $this->installmentIntervalDays ?? null;
    }

    public function showAtCounter(string $showAtCounter): self
    {
        $this->showAtCounter = $showAtCounter;
        return $this;
    }
    public function getShowAtCounter(): ?string
    {
        return $this->showAtCounter ?? null;
    }

    public function userId(string $userId): self
    {
        $this->userId = $userId;
        return $this;
    }
    public function getUserId(): ?string
    {
        return $this->userId ?? null;
    }

    public function userUpdateId(string $userUpdateId): self
    {
        $this->userUpdateId = $userUpdateId;
        return $this;
    }
    public function getUserUpdateId(): ?string
    {
        return $this->userUpdateId ?? null;
    }

    public function tenantId(string $tenantId): self
    {
        $this->tenantId = $tenantId;
        return $this;
    }
    public function getTenantId(): ?string
    {
        return $this->tenantId ?? null;
    }

    public function active(string $active): self
    {
        $this->active = $active;
        return $this;
    }
    public function getActive(): ?string
    {
        return $this->active ?? null;
    }

    public function branchId(string $branchId): self
    {
        $this->branchId = $branchId;
        return $this;
    }
    public function getBranchId(): ?string
    {
        return $this->branchId ?? null;
    }

    public static function build(array $data): self
    {
        $entity = new self();
        $mapping = [
            ['keys' => ['id'], 'callback' => fn($v) => $entity->id($v)],
            ['keys' => ['name'], 'callback' => fn($v) => $entity->name($v)],
            ['keys' => ['description', 'descricao'], 'callback' => fn($v) => $entity->description($v)],
            ['keys' => ['averageDays', 'diasmedios'], 'callback' => fn($v) => $entity->averageDays($v)],
            ['keys' => ['installmentQuantity', 'qtdParcelas'], 'callback' => fn($v) => $entity->installmentQuantity($v)],
            ['keys' => ['manualInvoiceSplit', 'desdobrarDuplicataManual'], 'callback' => fn($v) => $entity->manualInvoiceSplit($v)],
            ['keys' => ['generateInvoiceManually', 'gerarDuplicataManual'], 'callback' => fn($v) => $entity->generateInvoiceManually($v)],
            ['keys' => ['isActive', 'isAtiva'], 'callback' => fn($v) => $entity->isActive($v)],
            ['keys' => ['isOpen', 'isAberto'], 'callback' => fn($v) => $entity->isOpen($v)],
            ['keys' => ['minInstallments', 'qtdMinParcelas'], 'callback' => fn($v) => $entity->minInstallments($v)],
            ['keys' => ['firstInstallmentDays', 'qtd_dias_pri_parcela'], 'callback' => fn($v) => $entity->firstInstallmentDays($v)],
            ['keys' => ['installmentIntervalDays', 'qtdDiasIntervaloParcelas'], 'callback' => fn($v) => $entity->installmentIntervalDays($v)],
            ['keys' => ['showAtCounter', 'exibe_balcao'], 'callback' => fn($v) => $entity->showAtCounter($v)],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn($v) => $entity->tenantId($v)],
            ['keys' => ['userId', 'user_id'], 'callback' => fn($v) => $entity->userId($v)],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn($v) => $entity->userUpdateId($v)],
            ['keys' => ['active'], 'callback' => fn($v) => $entity->active($v)],
            ['keys' => ['branchId', 'filial_id'], 'callback' => fn($v) => $entity->branchId($v)],
        ];

        foreach ($mapping as $map) {
            foreach ($map['keys'] as $key) {
                if (isset($data[$key])) {
                    $map['callback']((string) $data[$key]);
                    break;
                }
            }
        }

        return $entity;
    }

    public function getDataProperties(): array
    {
        $data = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'averageDays' => $this->getAverageDays(),
            'installmentQuantity' => $this->getInstallmentQuantity(),
            'manualInvoiceSplit' => $this->getManualInvoiceSplit(),
            'generateInvoiceManually' => $this->getGenerateInvoiceManually(),
            'isActive' => $this->getIsActive(),
            'isOpen' => $this->getIsOpen(),
            'minInstallments' => $this->getMinInstallments(),
            'firstInstallmentDays' => $this->getFirstInstallmentDays(),
            'installmentIntervalDays' => $this->getInstallmentIntervalDays(),
            'showAtCounter' => $this->getShowAtCounter(),
            'tenantId' => $this->getTenantId(),
            'userId' => $this->getUserId(),
            'userUpdateId' => $this->getUserUpdateId(),
            'active' => $this->getActive(),
        ];

        return array_filter($data, fn($value) => $value !== null && $value !== '');
    }
}
