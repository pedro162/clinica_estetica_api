<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $fillable = 
    [
    	'name',
		'descricao',
		'user_id',
		'user_update_id',
		'active'
    ];
}
