<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParametroUser extends Model
{
    use SoftDeletes;
    use BelongsToTenant;
    protected $primaryKey    = 'id';
    protected $table         = 'parametro_users';
    protected $fillable     = [
        'p_value',
        'p_campos_id',
        'tenant_id',
        'p_user_id',
        'active',
        'user_id',
        'user_update_id',
    ];
}
