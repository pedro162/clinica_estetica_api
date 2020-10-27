<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Grupo;
use App\Logradouro;
use App\Telefone;

class Pessoa extends Model
{
	protected $fillable = 
	[
		'name',
		'name_opcional',
		'documento',
		'documento_complementar',
		'email',
		'nascimento_fundacao',
		'sexo',
		'tipo',
		'user_id',
		'user_update_id',
		'active'
	];

	public function grupo()
	{
		return $this->belongsToMany(Grupo::class, 'grupo_pessoa', 'pessoa_id', 'groupo_id');
	}

	public function logradouro()
	{
		return $this->belongsToMany(Logradouro::class);
	}

	public function adicionarGrupo($grupo, $dados)
	{
		return $this->grupo()->attach($grupo, $dados);
	}

	public function removerGrupo($grupo)
	{
		return $this->grupo()->detach($grupo);
	}

	public function adicionarLogradouro($logradouro, $dados)
	{
		return $this->logradouro()->attach($logradouro, $dados);
	}

	public function removerLogradouro($logradouro)
	{
		return $this->logradouro()->detach($logradouro);
	}

	public function telefone()
	{
		return $this->hasMany(Telefone::class, 'pessoa_id');
	}
}
