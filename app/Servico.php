<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    protected $fillable = [
    	'name',
		'descricao',
		'vrServico',
		'unidade',
		'user_id',
		'user_update_id',
		'active'

    ];
}
