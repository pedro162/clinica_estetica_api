<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Especialidade;
use App\EventoAgenda;
use App\DiasProfExpediente;

class Profissional extends Model
{
    protected $table="profissionals";
    protected $primaryKey="id";
    protected $fillable =[
        'pessoa_id',
        'user_id',
        'user_update_id',
        'active',
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
		'user_id',
		'user_update_id',
		'active'
    ];
    public function especialidade()
    {
    	return $this->belongsToMany(Especialidade::class, 'espec_prof', 'profissional_id', 'especialidade_id')
    	->withPivot('nr_doc', 'dt_emiss_doc', 'dt_vencimento_doc','org_expedidor','especialidade_id','profissional_id',
    		'user_id','user_update_id','active');
    }

    public function adicionarEspecialidade($especialidade, $dados)
	{
		return $this->especialidade()->attach($especialidade, $dados);
	}

	public function removeEspecialidade($especialidade)
	{
		return $this->especialidade()->detach($especialidade);
	}

	public function eventoAgenda()
    {
    	return $this->hasMany(EventoAgenda::class, 'profissional_id', 'id');
    }

    public function diasExpediente()
    {
        return $this->hasMany(DiasProfExpediente::class, 'profissional_id', 'id');
    }
}
