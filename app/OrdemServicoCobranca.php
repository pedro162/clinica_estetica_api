<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \App\Filial;
use \App\FormaPagamento;
use \App\PlanoPagamento;
use \App\OperadorFinanceiro;

class OrdemServicoCobranca extends Model
{
    use SoftDeletes;
    protected $table="ordem_servico_cobrancas";
    protected $primaryKey="id";
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
	];

    public function formaPgto(){
        return $this->belongsTo(FormaPagamento::class, 'forma_pagamento_id', 'id');
    }

    public function planoPgto(){
        return $this->belongsTo(PlanoPagamento::class, 'plano_pagamento_id', 'id');
    }

    public function operadorFinanceiro(){
        return $this->belongsTo(OperadorFinanceiro::class, 'operador_financeiro_id', 'id');
    }
}
