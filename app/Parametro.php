<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ParametroCampo;

class Parametro extends Model
{
    use SoftDeletes;
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
