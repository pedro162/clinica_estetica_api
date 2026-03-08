<?php

namespace App\Application\Commands\WorkOrder;

class CreateWorkOrderCommand
{
    protected ?string $id = null;
    protected ?string $tenantId = null;
    protected ?string $userId = null;
    protected ?string $userUpdateId = null;
    protected ?string $active = null;

    // Domain fields for work order
    protected ?float $vrTotal = null;
    protected ?string $status = null;
    protected ?string $observacao = null;
    protected ?string $dsArquivo = null;
    protected ?int $pessoaId = null;
    protected ?int $pessoaRcaId = null;
    protected ?int $filialId = null;
    protected ?float $vrFinal = null;
    protected ?float $vrDesconto = null;
    protected ?float $pctAcrescimo = null;
    protected ?float $vrAcrescimo = null;
    protected ?float $pctDesconto = null;
    protected ?string $isFaturado = null;
    protected ?string $tdFaturamento = null;
    protected ?string $tdCancelamento = null;
    protected ?string $tdConclusao = null;
    protected ?int $pessFatId = null;
    protected ?int $pessCancelId = null;
    protected ?int $pessConclId = null;
    protected ?int $profissionalId = null;
    protected ?int $cancelReasonId = null; // maps to mt_calcel_id column
    protected ?string $type = null;
    protected ?string $isOrcamento = null;

    public function id(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function tenantId(string $tenantId): self
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function userId(string $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function userUpdateId(string $userUpdateId): self
    {
        $this->userUpdateId = $userUpdateId;
        return $this;
    }

    public function active(string $active): self
    {
        $this->active = $active;
        return $this;
    }

    public function vrTotal(float $vrTotal): self
    {
        $this->vrTotal = $vrTotal;
        return $this;
    }

    public function status(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function observacao(?string $observacao): self
    {
        $this->observacao = $observacao;
        return $this;
    }

    public function dsArquivo(?string $dsArquivo): self
    {
        $this->dsArquivo = $dsArquivo;
        return $this;
    }

    public function pessoaId(int $pessoaId): self
    {
        $this->pessoaId = $pessoaId;
        return $this;
    }

    public function pessoaRcaId(?int $pessoaRcaId): self
    {
        $this->pessoaRcaId = $pessoaRcaId;
        return $this;
    }

    public function filialId(int $filialId): self
    {
        $this->filialId = $filialId;
        return $this;
    }

    public function vrFinal(?float $vrFinal): self
    {
        $this->vrFinal = $vrFinal;
        return $this;
    }

    public function vrDesconto(?float $vrDesconto): self
    {
        $this->vrDesconto = $vrDesconto;
        return $this;
    }

    public function pctAcrescimo(?float $pctAcrescimo): self
    {
        $this->pctAcrescimo = $pctAcrescimo;
        return $this;
    }

    public function vrAcrescimo(?float $vrAcrescimo): self
    {
        $this->vrAcrescimo = $vrAcrescimo;
        return $this;
    }

    public function pctDesconto(?float $pctDesconto): self
    {
        $this->pctDesconto = $pctDesconto;
        return $this;
    }

    public function isFaturado(string $isFaturado): self
    {
        $this->isFaturado = $isFaturado;
        return $this;
    }

    public function tdFaturamento(?string $tdFaturamento): self
    {
        $this->tdFaturamento = $tdFaturamento;
        return $this;
    }

    public function tdCancelamento(?string $tdCancelamento): self
    {
        $this->tdCancelamento = $tdCancelamento;
        return $this;
    }

    public function tdConclusao(?string $tdConclusao): self
    {
        $this->tdConclusao = $tdConclusao;
        return $this;
    }

    public function pessFatId(?int $pessFatId): self
    {
        $this->pessFatId = $pessFatId;
        return $this;
    }

    public function pessCancelId(?int $pessCancelId): self
    {
        $this->pessCancelId = $pessCancelId;
        return $this;
    }

    public function pessConclId(?int $pessConclId): self
    {
        $this->pessConclId = $pessConclId;
        return $this;
    }

    public function profissionalId(?int $profissionalId): self
    {
        $this->profissionalId = $profissionalId;
        return $this;
    }

    public function cancelReasonId(?int $cancelReasonId): self
    {
        $this->cancelReasonId = $cancelReasonId;
        return $this;
    }

    public function type(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function isOrcamento(string $isOrcamento): self
    {
        $this->isOrcamento = $isOrcamento;
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

    public function getVrTotal(): ?float
    {
        return $this->vrTotal;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getObservacao(): ?string
    {
        return $this->observacao;
    }

    public function getDsArquivo(): ?string
    {
        return $this->dsArquivo;
    }

    public function getPessoaId(): ?int
    {
        return $this->pessoaId;
    }

    public function getPessoaRcaId(): ?int
    {
        return $this->pessoaRcaId;
    }

    public function getFilialId(): ?int
    {
        return $this->filialId;
    }

    public function getVrFinal(): ?float
    {
        return $this->vrFinal;
    }

    public function getVrDesconto(): ?float
    {
        return $this->vrDesconto;
    }

    public function getPctAcrescimo(): ?float
    {
        return $this->pctAcrescimo;
    }

    public function getVrAcrescimo(): ?float
    {
        return $this->vrAcrescimo;
    }

    public function getPctDesconto(): ?float
    {
        return $this->pctDesconto;
    }

    public function getIsFaturado(): ?string
    {
        return $this->isFaturado;
    }

    public function getTdFaturamento(): ?string
    {
        return $this->tdFaturamento;
    }

    public function getTdCancelamento(): ?string
    {
        return $this->tdCancelamento;
    }

    public function getTdConclusao(): ?string
    {
        return $this->tdConclusao;
    }

    public function getPessFatId(): ?int
    {
        return $this->pessFatId;
    }

    public function getPessCancelId(): ?int
    {
        return $this->pessCancelId;
    }

    public function getPessConclId(): ?int
    {
        return $this->pessConclId;
    }

    public function getProfissionalId(): ?int
    {
        return $this->profissionalId;
    }

    public function getCancelReasonId(): ?int
    {
        return $this->cancelReasonId;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getIsOrcamento(): ?string
    {
        return $this->isOrcamento;
    }

    public static function build(array $data): self
    {
        $entity = new self();

        $mapping = [
            ['keys' => ['id'], 'callback' => fn($v) => $entity->id((string) $v)],
            ['keys' => ['tenantId', 'tenant_id'], 'callback' => fn($v) => $entity->tenantId((string) $v)],
            ['keys' => ['userId', 'user_id'], 'callback' => fn($v) => $entity->userId((string) $v)],
            ['keys' => ['userUpdateId', 'user_update_id'], 'callback' => fn($v) => $entity->userUpdateId((string) $v)],
            ['keys' => ['active'], 'callback' => fn($v) => $entity->active((string) $v)],

            // Domain fields
            ['keys' => ['vrTotal', 'vr_total'], 'callback' => fn($v) => $entity->vrTotal((float) $v)],
            ['keys' => ['status'], 'callback' => fn($v) => $entity->status((string) $v)],
            ['keys' => ['observacao'], 'callback' => fn($v) => $entity->observacao((string) $v)],
            ['keys' => ['dsArquivo', 'ds_arquivo'], 'callback' => fn($v) => $entity->dsArquivo((string) $v)],
            ['keys' => ['pessoa_id'], 'callback' => fn($v) => $entity->pessoaId((int) $v)],
            ['keys' => ['pessoa_rca_id'], 'callback' => fn($v) => $entity->pessoaRcaId((int) $v)],
            ['keys' => ['filial_id'], 'callback' => fn($v) => $entity->filialId((int) $v)],
            ['keys' => ['vr_final'], 'callback' => fn($v) => $entity->vrFinal((float) $v)],
            ['keys' => ['vr_desconto'], 'callback' => fn($v) => $entity->vrDesconto((float) $v)],
            ['keys' => ['pct_acrescimo'], 'callback' => fn($v) => $entity->pctAcrescimo((float) $v)],
            ['keys' => ['vr_acrescimo'], 'callback' => fn($v) => $entity->vrAcrescimo((float) $v)],
            ['keys' => ['pct_desconto'], 'callback' => fn($v) => $entity->pctDesconto((float) $v)],
            ['keys' => ['is_faturado'], 'callback' => fn($v) => $entity->isFaturado((string) $v)],
            ['keys' => ['td_faturamento'], 'callback' => fn($v) => $entity->tdFaturamento((string) $v)],
            ['keys' => ['td_cancelamento'], 'callback' => fn($v) => $entity->tdCancelamento((string) $v)],
            ['keys' => ['td_conclusao'], 'callback' => fn($v) => $entity->tdConclusao((string) $v)],
            ['keys' => ['pess_fat_id'], 'callback' => fn($v) => $entity->pessFatId((int) $v)],
            ['keys' => ['pess_cancel_id'], 'callback' => fn($v) => $entity->pessCancelId((int) $v)],
            ['keys' => ['pess_concl_id'], 'callback' => fn($v) => $entity->pessConclId((int) $v)],
            ['keys' => ['profissional_id'], 'callback' => fn($v) => $entity->profissionalId((int) $v)],
            ['keys' => ['mt_calcel_id'], 'callback' => fn($v) => $entity->cancelReasonId((int) $v)],
            ['keys' => ['type'], 'callback' => fn($v) => $entity->type((string) $v)],
            ['keys' => ['is_orcamento'], 'callback' => fn($v) => $entity->isOrcamento((string) $v)],
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

    public function getDataProperties(): array
    {
        $data = [
            'id' => $this->id,
            'tenant_id' => $this->tenantId,
            'user_id' => $this->userId,
            'user_update_id' => $this->userUpdateId,
            'active' => $this->active,
            'vr_total' => $this->vrTotal,
            'status' => $this->status,
            'observacao' => $this->observacao,
            'ds_arquivo' => $this->dsArquivo,
            'pessoa_id' => $this->pessoaId,
            'pessoa_rca_id' => $this->pessoaRcaId,
            'filial_id' => $this->filialId,
            'vr_final' => $this->vrFinal,
            'vr_desconto' => $this->vrDesconto,
            'pct_acrescimo' => $this->pctAcrescimo,
            'vr_acrescimo' => $this->vrAcrescimo,
            'pct_desconto' => $this->pctDesconto,
            'is_faturado' => $this->isFaturado,
            'td_faturamento' => $this->tdFaturamento,
            'td_cancelamento' => $this->tdCancelamento,
            'td_conclusao' => $this->tdConclusao,
            'pess_fat_id' => $this->pessFatId,
            'pess_cancel_id' => $this->pessCancelId,
            'pess_concl_id' => $this->pessConclId,
            'profissional_id' => $this->profissionalId,
            'mt_calcel_id' => $this->cancelReasonId,
            'type' => $this->type,
            'is_orcamento' => $this->isOrcamento,
        ];

        return array_filter($data, fn($v) => $v !== null);
    }
}
