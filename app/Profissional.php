<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Especialidade;
use App\EventoAgenda;
use App\Pessoa;
use App\DiasProfExpediente;

class Profissional extends Model
{
	protected $table = "profissionals";
	protected $primaryKey = "id";
	protected $fillable = [
		'pessoa_id',
		'user_id',
		'user_update_id',
		'active',
		'vr_salario',
		'titulo_eleitor',
		'zona_eleitor',
		'naturalidade',
		'name_mae',
		'name_conjuge',
		'nr_serie_cnh',
		'name_banco_salario',
		'nr_agencia_banco_salario',
		'nr_conta_banco_salario',
		'ponto_obrigatorio',
		'estado_civil',
		'grau_instrucao',
		'status',
		'tipo_contrato',
		'filial_id',
		'uf_cnh_id',
		'tenant_id'
	];
	public function especialidade()
	{
		return $this->belongsToMany(Especialidade::class, 'espec_prof', 'profissional_id', 'especialidade_id')
			->withPivot(
				'nr_doc',
				'dt_emiss_doc',
				'dt_vencimento_doc',
				'org_expedidor',
				'especialidade_id',
				'profissional_id',
				'user_id',
				'user_update_id',
				'active'
			);
	}

	public function pessoa()
	{
		return $this->belongsTo(Pessoa::class, 'pessoa_id', 'id');
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
