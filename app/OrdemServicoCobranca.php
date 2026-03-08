<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdemServicoCobranca extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $table = 'ordem_servico_cobrancas';
    protected $primaryKey = 'id';
    protected $fillable = [

        'ordem_servico_id',
        'forma_pagamento_id',
        'operador_financeiro_id',
        'plano_pagamento_id',
        'filial_id',
        'nr_doc',
        'vencimento_manual',
        'dt_vencimento_manual',
        'vr_cobranca',
        'vr_acrescimo',
        'vr_final',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];

    public function formaPgto()
    {
        return $this->belongsTo(FormaPagamento::class, 'forma_pagamento_id', 'id');
    }

    public function planoPgto()
    {
        return $this->belongsTo(PlanoPagamento::class, 'plano_pagamento_id', 'id');
    }

    public function operadorFinanceiro()
    {
        return $this->belongsTo(OperadorFinanceiro::class, 'operador_financeiro_id', 'id');
    }
}
