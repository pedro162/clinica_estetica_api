<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Pessoa;

class Filial extends Model
{
    protected $fillable = [
    	'pessoa_id',
		'dsAtividade',
		'dsTextoContrato',
		'nrExercicioImplantacaoContabil',
		'user_id',
		'user_update_id',
		'active'
	];
	
	public function pessoa()
	{
		return $this->hasOne(Pessoa::class, 'id' , 'pessoa_id');
	}
}
