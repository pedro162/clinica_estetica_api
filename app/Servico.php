<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servico extends Model
{
	use SoftDeletes, BelongsToTenant, HasFactory;

	protected $primaryKey	= 'id';
	protected $table 		= 'servicos';
	protected $fillable 	= [
		'name',
		'descricao',
		'vrServico',
		'unidade',
		'user_id',
		'user_update_id',
		'type',
		'active',
		'tenant_id'
	];
}
