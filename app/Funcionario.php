<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Funcionario extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

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
