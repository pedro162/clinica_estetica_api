<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
		'active'
    ];
}
