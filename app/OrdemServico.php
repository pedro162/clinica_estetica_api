<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\CobrancaReceber;
use \App\Venda;

class OrdemServico extends Model
{
    protected $fillable = [
    	'vrTotal',
		'status',
		'observacao',
		'dsArquivo',
		'pessoa_id',
		'pessoa_rca_id',
		'filial_id',
		'user_id',
		'user_update_id',
		'active',
	];
	
	public function cobrancaReceber()
	{
		return $this->belongsToMany(CobrancaReceber::class);
	}

	public function venda()
	{
		return $this->belongsToMany(Venda::class);
	}
}
