<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Logradouro extends Model
{
    use SoftDeletes;
    use BelongsToTenant;
    protected $fillable =
        [
            'id',
            'cep',
            'cidade',
            'logradouro',
            'complemento',
            'numero',
            'bloco',
            'tipo',
            'importancia',
            'user_id',
            'user_update_id',
            'active',
            'bairro',
            'estado',
            'tenant_id'
        ];

    public function estado_logradouro()
    {
        return $this->belongsTo(Estado::class, 'estado', 'id');
    }
}
