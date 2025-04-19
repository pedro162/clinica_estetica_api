<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class Grupo extends Model
{
	use SoftDeletes, BelongsToTenant;
	protected $fillable =
	[
		'name',
		'descricao',
		'user_id',
		'user_update_id',
		'active',
		'tenant_id'
	];
}
