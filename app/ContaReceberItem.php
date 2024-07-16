<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ContaReceber;
use App\FinanceiroMovimentacoe;

class ContaReceberItem extends Model
{
    protected $primaryKey = "id";

    protected $table = "conta_receber_items";

    protected $fillable = [
    	'id',
    	'documento',
		'dtPagamento',
		'dtBaixa',
		'descricao',
		'ds_estorno',
		'vrBruto',
		'vrLiquido',
		'vrDevolvido',
		'vrPago',
		'vrTaxa',
		'vrDesconto',
		'vrJuros',
		'status',
		'forma_pagamentos_id',
		'plano_pagamento_id',
		'operador_financeiro_id',
		'user_id',
		'user_update_id',
		'conta_receber_id',
		'pessoa_estorno_id',
		'pessoa_baixa_id',
		'pessoa_devolucao_id',
		'active',
		'caixa_id',
		'tpBaixa',
		'rashBaixa',
    ];

    public function contaReceber()
    {
    	return $this->belongsTo(ContaReceber::class,'conta_receber_id', 'id');
    }

  	public function movimentacao(){
  		return $this->hasMany(FinanceiroMovimentacoe::class, 'referencia_id', 'id')->where('referencia', 'conta_receber_items');
  	}
}
