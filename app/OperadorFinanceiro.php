<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Pessoa;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class OperadorFinanceiro extends Model
{
	use SoftDeletes, BelongsToTenant;

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
		'active',
		'tenant_id'
	];


	public function pessoa()
	{
		return $this->hasOne(Pessoa::class, 'id', 'pessoa_id');
	}
}
