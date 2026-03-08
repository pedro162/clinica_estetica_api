<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Caixa extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $table = 'caixas';
    protected $primaryKey = 'id';
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
        'filial_id',
        'tenant_id'
    ];
}
