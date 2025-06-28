<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class Funcionario extends Model
{
	use SoftDeletes, BelongsToTenant;

	protected $fillable = [
		'vrSalario',
		'tituloEleitor',
		'zonaEleitor',
		'dsNaturalidade',
		'dsMae',
		'nmConjuge',
		'nrCnh',
		'nrSerieCnh',
		'dsUFCnh',
		'dsBancoSalario',
		'nrAgenciaBancoSalario',
		'nrContaBancoSalario',
		'isPontoObrigatorio',
		'dsEstadoCivil',
		'dsGrauInstrucao',
		'status',
		'isAprendiz',
		'filial_id',
		'pessoa_id',
		'user_id',
		'user_update_id',
		'active',
		'tenant_id'
	];
}
