<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanoPagamentoPrazos extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $fillable = [
        'qtdDias',
        'plano_pagamentos_id',
        'active',
        'user_id',
        'user_update_id',
        'tenant_id'
    ];

    public function planoPagamento()
    {
        return $this->hasOne(PlanoPagamento::class);
    }
}
