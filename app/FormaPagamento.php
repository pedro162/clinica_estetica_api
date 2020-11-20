<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
		'active'
    ];
}
