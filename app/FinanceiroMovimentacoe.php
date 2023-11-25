<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinanceiroMovimentacoe extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'referencia_id',
        'referencia',
        'historico',
        'caixa_id',
        'caixa_id',
        'vr_saldo_anterior',
        'vr_movimentacao',
        'vr_saldo',
        'conciliado',
        'estornado',
        'hash_operacao',
        'user_id',
        'user_id',
        'user_update_id',
        'active',

    ];
}


