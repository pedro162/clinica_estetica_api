<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\SoftDeletes;

class BandeiraCartao extends Model
{
	use SoftDeletes, BelongsToTenant;
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
