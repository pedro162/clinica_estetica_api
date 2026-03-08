<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ipi extends Model
{
    use SoftDeletes;
    use BelongsToTenant;
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

    protected $table = 'ipis';
}
