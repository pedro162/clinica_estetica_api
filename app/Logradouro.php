<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Estado;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class Logradouro extends Model
{
	use SoftDeletes, BelongsToTenant;
	protected $fillable =
	[
		'id',
		'cep',
		'cidade',
		'logradouro',
		'complemento',
		'numero',
		'bloco',
		'tipo',
		'importancia',
		'user_id',
		'user_update_id',
		'active',
		'bairro',
		'estado',
		'tenant_id'
	];

	public function estado_logradouro()
	{
		return $this->belongsTo(Estado::class, 'estado', 'id');
	}
}
