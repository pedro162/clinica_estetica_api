<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PisCofins extends Model
{
    use SoftDeletes, BelongsToTenant;

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
