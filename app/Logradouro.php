<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logradouro extends Model
{
    protected $fillable = 
    [
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
		'estado'
    ];
}
