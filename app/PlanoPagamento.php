<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\PlanoPagamentoPrazos;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PlanoPagamento extends Model
{
	protected $fillable = [

		'name',
		'descricao',
		'diasmedios',
		'qtdParcelas',
		'desdobrarDuplicataManual',
		'gerarDuplicataManual',
		'isAtiva',
		'isAberto',
		'user_id',
		'user_update_id',
		'active',
		'qtdMinParcelas',
		'qtd_dias_pri_parcela',
		'qtdDiasIntervaloParcelas',
		'exibe_balcao',
		'tenant_id'
	];

	public function planoPrazo()
	{
		return $this->hasMany(PlanoPagamentoPrazos::class, 'plano_pagamentos_id');
	}

	public function formaPagamento(): BelongsToMany
	{
		return $this->belongsToMany(FormaPagamento::class, 'plano_forma_pgto', 'plano_pagamentos_id', 'forma_pagamentos_id');
	}
}
