<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanoPagamento extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $fillable = [
        'id',
        'name',
        'descricao',
        'diasmedios',
        'qtdParcelas',
        'desdobrarDuplicataManual',
        'gerarDuplicataManual',
        'isAtiva',
        'isAberto',
        'user_id',
        'user_update_id',
        'active',
        'qtdMinParcelas',
        'qtd_dias_pri_parcela',
        'qtdDiasIntervaloParcelas',
        'exibe_balcao',
        'tenant_id'
    ];

    public function planoPrazo()
    {
        return $this->hasMany(PlanoPagamentoPrazos::class, 'plano_pagamentos_id');
    }

    public function formaPagamento(): BelongsToMany
    {
        return $this->belongsToMany(FormaPagamento::class, 'plano_forma_pgto', 'plano_pagamentos_id', 'forma_pagamentos_id');
    }
}
