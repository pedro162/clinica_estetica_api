<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ParametroCampo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class Parametro extends Model
{
    use SoftDeletes, BelongsToTenant;

    protected $primaryKey    = 'id';
    protected $table         = 'parametros';
    protected $fillable     = [
        'name',
        'type',
        'tenant_id',
        'active',
        'user_id',
        'user_update_id',
    ];

    public function parametroCampo()
    {
        return $this->hasMany(ParametroCampo::class, 'parametro_id');
    }
}
