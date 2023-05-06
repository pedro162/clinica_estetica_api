<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servico extends Model
{
	use SoftDeletes;
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
		'active'

    ];
}
