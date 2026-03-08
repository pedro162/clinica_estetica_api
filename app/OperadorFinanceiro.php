<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class OperadorFinanceiro extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $fillable = [
        'id',
        'vrTarifa',
        'vrDesconto',
        'vrPorcentagemDesconto',
        'nrRemessaAtual',
        'nrNossoNumero',
        'qtdDiasProtesto',
        'isAssumeDuplicata',
        'tpLocalAtualizacaoBoleto',
        'isPadrao',
        'isLiberado',
        'pessoa_id',
        'filial_id',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];

    protected $casts = [
        'vrTarifa'               => 'float',
        'vrDesconto'             => 'float',
        'vrPorcentagemDesconto'  => 'float',
        'nrRemessaAtual'         => 'integer',
        'nrNossoNumero'          => 'integer',
        'qtdDiasProtesto'        => 'integer',
        'isAssumeDuplicata'      => 'string',
        'tpLocalAtualizacaoBoleto' => 'string',
        'isPadrao'               => 'string',
        'isLiberado'             => 'string',
        'active'                 => 'string',
        'pessoa_id'              => 'integer',
        'filial_id'              => 'integer',
        'user_id'                => 'integer',
        'user_update_id'         => 'integer',
        'tenant_id'              => 'integer',
    ];

    /**
     * Get the related person
     *
     * @return HasOne
     */
    public function pessoa(): HasOne
    {
        return $this->hasOne(Pessoa::class, 'id', 'pessoa_id');
    }

    /**
     * Get the related branch
     *
     * @return BelongsTo
     */
    public function filial(): BelongsTo
    {
        return $this->belongsTo(Filial::class, 'filial_id', 'id');
    }

    /**
     * Get
     *
     * @return BelongsToMany
     */
    public function formaPagamento(): BelongsToMany
    {
        return $this->belongsToMany(FormaPagamento::class, 'oper_forma_pgto', 'oper_pagamentos_id', 'forma_pagamentos_id');
    }
}
