<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pais extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $fillable = [
        'id',
        'nmPais',
        'cdPais',
        'padrao',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];

    public function estado()
    {
        return $this->hasMany(Estado::class, 'pais_id', 'id');
    }
}
