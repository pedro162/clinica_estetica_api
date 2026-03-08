<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Icms extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $fillable = [
        'id',
        'nmIcms',
        'pcAliq',
        'pcAliqSt',
        'baseIcms',
        'baseCalcOpPropri',
        'baseIcmsSt',
        'baseStRetido',
        'aliqStRetido',
        'aliqCalcCred',
        'aliqSn',
        'pcAliqPf',
        'pcAliqPj',
        'pcFcp',
        'pcMva',
        'vrReduzBc',
        'vrReduzBcSt',
        'st',
        'csosn',
        'cest',
        'modBcIcms',
        'user_id',
        'estado_id',
        'user_update_id',
        'active',
        'estados_id',
        'tenant_id'

    ];

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'pais_id', 'id');
    }
}
