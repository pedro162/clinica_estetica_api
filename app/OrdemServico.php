<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\CobrancaReceber;
use \App\Servico;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdemServico extends Model
{
	use SoftDeletes;
    protected $table="ordem_servicos";
    protected $primaryKey="id";
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
		'vr_final',
		'vr_desconto',
		'pct_acrescimo',
		'vr_acrescimo',
        'pct_desconto'
	];
	
	public function cobrancaReceber()
	{
		return $this->belongsToMany(CobrancaReceber::class);
	}

	public function servico()
	{
		return $this->hasMany(Servico::class, 'ordem_servico_id', 'id');
	}
}
