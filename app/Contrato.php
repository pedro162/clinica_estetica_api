<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\CobrancaReceber;

class Contrato extends Model
{
    protected $fillable = [

        'tpVencimento',
        'isLiberaCatraca',
        'dtVencimento',
        'vrAdesao',
        'vrContrato', 
        'filial_id',
        'user_id',
        'user_update_id',       
        'active'
    ];


    public function cobrancaReceber()
    {
        return $this->hasMany(CobrancaReceber::class);
    }
}
