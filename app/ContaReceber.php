<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ContaReceberItem;
use App\Pessoa;
use App\FormaPagamento;
use App\PlanoPagamento;
use App\OperadorFinanceiro;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContaReceber extends Model
{
	use SoftDeletes, BelongsToTenant;
	protected $primaryKey = "id";

	protected $table = "conta_recebers";

	protected $fillable = [
		'id',
		'referencia_id',
		'referencia',
		'pessoa_id',
		'descricao',
		'documento',
		'dtVencimentoOriginal',
		'dtVencimento',
		'vrBruto',
		'vrLiquido',
		'vrDevolvido',
		'vrPago',
		'vrTaxa',
		'vrDesconto',
		'vrJuros',
		'user_id',
		'user_update_id',
		'active',
		'responsavel_id',
		'importacao_dados',
		'filial_id',
		'forma_pagamento_id',
		'plano_pagamento_id',
		'operador_financeiro_id',
		'status',
		'tenant_id'
	];

	public function contaReceberItem()
	{
		return $this->hasMany(ContaReceberItem::class, 'conta_receber_id', 'id');
	}

	public function pessoa()
	{
		return $this->belongsTo(Pessoa::class, 'pessoa_id', 'id');
	}

	public function filial()
	{
		return $this->belongsTo(Filial::class, 'filial_id', 'id');
	}

	public function formaPagamento()
	{
		return $this->belongsTo(FormaPagamento::class, 'forma_pagamento_id', 'id');
	}

	public function planoPagamento()
	{
		return $this->belongsTo(PlanoPagamento::class, 'plano_pagamento_id', 'id');
	}

	public function operadorFinanceiro()
	{
		return $this->belongsTo(OperadorFinanceiro::class, 'operador_financeiro_id', 'id');
	}
}
