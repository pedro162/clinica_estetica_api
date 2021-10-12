<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cidade;

class Bairro extends Model
{
    protected $fillable =[
	 	'user_id',
        'user_update_id',
        'name',
        'codIbge',
        'cep',
        'cidade_id',
        'active',
    ];

    public function cidade()
    {
    	return $this->belongsTo(Cidade::class, 'cidade_id', 'id');
    }
}
