<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
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
		'active'
    ];
}
