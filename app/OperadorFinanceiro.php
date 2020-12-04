<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperadorFinanceiro extends Model
{
    protected $fillable = [
    	'vrTarifa',
		'vrDesconto',
		'vrPorcentagemDesconto',
		'nrRemessaAtual',
		'nrNossoNumero',
		'qtdDiasProtesto',
		'isAssumeDuplicata',
		'tpLocalAtualizacaoBoleto',
		'isPadrao',
		'isLiberado',
		'pessoa_id',
		'filial_id',
		'user_id',
		'user_update_id',
		'active'
    ];
}
