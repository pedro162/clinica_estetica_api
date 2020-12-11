<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicoItem extends Model
{
    protected $fillable = [
        'qtd',
        'servico_id',
        'vrTotal',
        'vrItem',
        'user_id',
        'user_update_id',
        'active',
        'ordem_servico_id',

    ];
}
