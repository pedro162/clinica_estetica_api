<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ParametroUser;
use App\Traits\BelongsToTenant;

class ParametroCampo extends Model
{
    use SoftDeletes, BelongsToTenant;
    protected $primaryKey    = 'id';
    protected $table         = 'parametro_campos';
    protected $fillable     = [
        'name',
        'key',
        'control_type',
        'options',
        'default_value',
        'props',
        'parametro_id',
        'tenant_id',
        'active',
        'user_id',
        'user_update_id',
    ];


    public function parametroUser()
    {
        return $this->hasMany(ParametroUser::class, 'p_campos_id');
    }
}
