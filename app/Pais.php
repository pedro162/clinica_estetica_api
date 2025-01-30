<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Estado;

class Pais extends Model
{

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
