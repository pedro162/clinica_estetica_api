<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Pessoa;

class Telefone extends Model
{
	protected $fillable =
	[
		'numero',
		'tipo',
		'whatsapp',
		'pessoa_id',
		'user_id',
		'user_update_id',
		'importancia',
		'active',
		'tenant_id'
	];


	public function pessoa()
	{
		return $this->hasMany(Pessoa::class, 'pessoa_id');
	}
}
