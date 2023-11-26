<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceiroMovimentacoe extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id';
    protected $table = 'financeiro_movimentacoes';
    
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


