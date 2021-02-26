<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\PlanoPagamento;
use \App\OperadorFinanceiro;

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
		'active'
	];
	
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
