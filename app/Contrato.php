<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\ContaReceber;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contrato extends Model
{
    use SoftDeletes, BelongsToTenant;
    protected $fillable = [

        'tpVencimento',
        'isLiberaCatraca',
        'dtVencimento',
        'vrAdesao',
        'vrContrato',
        'filial_id',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];


    public function cobrancaReceber()
    {
        return $this->hasMany(ContaReceber::class);
    }
}
