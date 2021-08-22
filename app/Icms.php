<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Icms extends Model
{
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

    ];


}
