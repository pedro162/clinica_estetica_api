<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
