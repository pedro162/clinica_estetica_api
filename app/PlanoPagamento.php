<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\PlanoPagamentoPrazos;

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
}
