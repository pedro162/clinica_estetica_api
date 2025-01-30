<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\PlanoPagamento;
use \App\OperadorFinanceiro;
use \App\TipoPagamento;
use \App\PrazoPagamento;
use \App\Conta;

class FormaPagamento extends Model
{
	protected $fillable = [
		'name',
		'cdCobrancaTipo',
		'hasComissao',
		'tpPagamento',
		'hasDesdobramento',
		'hasLimiteDeCredito',
		'hasAcertoBalcao',
		'hasAcertoCaixa',
		'hasEntrada',
		'user_id',
		'user_update_id',
		'hasOperadorFinanceiro',
		'tipo',
		'active',
		'tenant_id'
	];

	public function tipo_pagamento()
	{
		return $this->belongsTo(TipoPagamento::class, 'tipo_pagamento_id', 'id');
	}

	/* public function conta()
	{
		return $this->belongsTo(Conta::class, 'conta_id', 'id');
	} */

	public function prazoPagamento()
	{
		return $this->belongsToMany(PrazoPagamento::class, 'forma_prazo', 'forma_pagamento_id', 'prazo_pagamento_id')->withPivot('forma_prazo.pcTaxa', 'forma_prazo.vrTaxa', 'forma_prazo.bandeira_cartao_id', 'forma_prazo.user_id', "forma_prazo.active");
	}

	public function planoPagamento()
	{
		return $this->belongsToMany(PlanoPagamento::class, 'plano_forma_pgto', 'forma_pagamentos_id', 'plano_pagamentos_id');
		//return $this->belongsToMany(Grupo::class, 'grupo_pessoa', 'pessoa_id', 'groupo_id');
	}

	public function adicionarPlanoPagamento($plano, $dados)
	{
		return $this->planoPagamento()->attach($plano, $dados);
	}

	public function removePlanoPagamento($plano)
	{
		return $this->planoPagamento()->detach($plano);
	}

	public function operadorFinanceiro()
	{
		return $this->belongsToMany(OperadorFinanceiro::class, 'oper_forma_pgto', 'forma_pagamentos_id', 'oper_pagamentos_id');
	}


	public function adicionarOperador($operador, $dados)
	{
		return $this->operadorFinanceiro()->attach($operador, $dados);
	}

	public function removeOperador($operador)
	{
		return $this->operadorFinanceiro()->detach($operador);
	}
}
