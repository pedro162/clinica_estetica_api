<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caixa extends Model
{
	protected $table = "caixas";
    protected $primaryKey="id";
    protected $fillable = [
        'id',
        'name',
        'type',
        'vrMin',
        'vrMax',
        'status_abertura',
        'status_bloqueio',
        'aceita_transferencia',
        'user_id',
        'user_update_id',
        'active',
        'vrSaldo',
        'tpSaldo',
        'filial_id'
    ];
    
}
