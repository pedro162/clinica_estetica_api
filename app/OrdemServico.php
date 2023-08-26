<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\CobrancaReceber;
use \App\ServicoItem;
use \App\Pessoa;
use \App\Rca;
use \App\Filial;
use \App\OrdemServicoCobranca;
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
        'pct_desconto',
		'is_faturado',
		'td_faturamento',
		'td_cancelamento',
		'td_conclusao',
		'pess_fat_id',
		'pess_cancel_id',
		'pess_concl_id',
		'profissional_id',
		'mt_calcel_id',
	];

	public function getTable(){
		return $this->table;
	}
	
	public function cobrancaReceber()
	{
		return $this->belongsToMany(CobrancaReceber::class);
	}

	public function item()
	{
		return $this->hasMany(ServicoItem::class, 'ordem_servico_id', 'id');
	}

	public function cobranca()
	{
		return $this->hasMany(OrdemServicoCobranca::class, 'ordem_servico_id', 'id');
	}

	public function pessoa(){
		return $this->belongsTo(Pessoa::class, 'pessoa_id', 'id');
	}

	public function rca(){
		return $this->belongsTo(Rca::class, 'pessoa_rca_id', 'id');
	}

	public function filial(){
		return $this->belongsTo(Filial::class, 'filial_id', 'id');
	}
}
