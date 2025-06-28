<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class Ipi extends Model
{
    use SoftDeletes, BelongsToTenant;
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
