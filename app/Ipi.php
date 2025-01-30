<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ipi extends Model
{
    protected $fillable = [

        'dsIpi',
        'cst',
        'cdExTipi',
        'tpCalculo',
        'pcIpi',
        'vrIpi',
        'bcIpi',
        'somaBcIcms',
        'somaBcIcmsSt',
        'dsClassEnquadra',
        'cdEnquadra',
        'cnpjProdutor',
        'cdCeloControle',
        'user_id',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'

    ];

    protected $table = "ipis";
}
