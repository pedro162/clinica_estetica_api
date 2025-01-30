<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BandeiraCartao extends Model
{
	//
	protected $primaryKey = "id";
	protected $table = "bandeira_cartaos";
	protected $fillable =
	[
		'id',
		'name',
		'standard',
		'user_id',
		'user_update_id',
		'pessoa_autor_id',
		'active',
		'tenant_id'
	];
}
