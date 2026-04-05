<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrazoPagamento extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $primaryKey = 'id';
    protected $table = 'prazo_pagamentos';
    protected $fillable =
        [
            'name',
            'qtdMaxParcelas',
            'qtdMinParcelas',
            'qtdDiasIntervaloParcelas',
            'qtdDiasMedios',
            'exibe_balcao',
            'qtd_dias_pri_parcela',
            'user_id',
            'user_update_id',
            'pessoa_autor_id',
            'active',
            'tenant_id'
        ];

    public function formaPagamento()
    {
        return $this->belongsToMany(
            FormaPagamento::class,
            'forma_prazo',
            'prazo_pagamento_id',
            'forma_pagamento_id'
        )->withPivot('pcTaxa', 'vrTaxa', 'bandeira_cartao_id', 'user_id');
    }

    public function adicionarPagamento($formaPgto, $dados)
    {
        return $this->formaPagamento()->attach($formaPgto, $dados);
    }

    public function removerPagamento($formaPgto)
    {
        return $this->formaPagamento()->detach($formaPgto);
    }
}
