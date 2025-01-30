<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Pessoa;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filial extends Model
{
	use SoftDeletes;

	protected $table = 'filials';
	protected $primaryKey = "id";
	protected $fillable = [
		'pessoa_id',
		'dsAtividade',
		'dsTextoContrato',
		'nrExercicioImplantacaoContabil',
		'user_id',
		'user_update_id',
		'active',
		'tenant_id'
	];

	public function pessoa()
	{
		//return $this->hasOne(Pessoa::class, 'id' , 'pessoa_id');
		return $this->belongsTo(Pessoa::class, 'pessoa_id', 'id');
	}
}
