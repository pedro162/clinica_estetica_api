<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\PlanoPagamento;

class PlanoPagamentoPrazos extends Model
{
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
