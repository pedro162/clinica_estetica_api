<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoPagamento extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $primaryKey = 'id';
    protected $table = 'tipo_pagamentos';
    protected $fillable =
        [
            'name',
            'type',
            'standard',
            'user_id',
            'user_update_id',
            'pessoa_autor_id',
            'active',
            'tenant_id'
        ];
}
