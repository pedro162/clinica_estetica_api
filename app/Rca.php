<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rca extends Model
{
    protected $fillable =[
        'filial_id',
        'pessoa_id',
        'acessaTodosRcas',
        'situacao',
        'metaPositivacao',
        'metaMargem',
        'metaFaturamento',
        'active',
        'user_id',
        'user_update_id',
    ];
}

