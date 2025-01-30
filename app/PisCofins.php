<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PisCofins extends Model
{

    protected $fillable = [
        'id',
        'dsPisCofins',
        'tpCalculo',
        'tpRegistro',
        'vrPisCofins',
        'pcPisCofins',
        'user_id',
        'user_update_id',
        'st',
        'active',
        'tenant_id'
    ];

    protected $table = "pis_cofins";
    protected $primaryKey = 'id';
}
