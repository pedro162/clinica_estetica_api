<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Estado;

class Logradouro extends Model
{
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
		'estado'
    ];

	public function estado_logradouro()
    {
        return $this->belongsTo(Estado::class, 'estado', 'id');
    }
}
