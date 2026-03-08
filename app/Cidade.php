<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cidade extends Model
{
    use SoftDeletes;
    use BelongsToTenant;
    protected $table = 'cidades';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nmCidade',
        'sigla',
        'cdCidade',
        'estado_id',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id', 'id');
    }

    public function bairro()
    {
        return $this->hasMany(Bairro::class, 'cidade_id', 'id');
    }
}
