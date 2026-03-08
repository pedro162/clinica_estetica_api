<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parametro extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

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
