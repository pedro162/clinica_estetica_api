<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceiroMovimentacoe extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $primaryKey = 'id';
    protected $table = 'financeiro_movimentacoes';

    protected $fillable = [
        'id',
        'referencia_id',
        'referencia',
        'sub_referencia_id',
        'sub_referencia',
        'historico',
        'caixa_id',
        'vr_saldo_anterior',
        'vr_movimentacao',
        'vr_saldo',
        'conciliado',
        'estornado',
        'hash_operacao',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];

    public function contaReceber()
    {
        return $this->belongsTo(ContaReceberItem::class, 'referencia_id', 'id')
            ->where('referencia', 'conta_receber_items');
    }

    public function caixa()
    {
        return $this->belongsTo(Caixa::class, 'caixa_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
