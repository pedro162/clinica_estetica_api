<?php

namespace App;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use \App\Venda;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendaItem extends Model
{
    use SoftDeletes, BelongsToTenant;

    protected $fillable = [
        'venda_id',
        'idReferencia',
        'tpReferencia',
        'qtdItem',
        'qtdEmbalagemItem',
        'vrItemBruto',
        'vrTabela',
        'vrDescontoItem',
        'vrDescontoAvulso',
        'vrPcntDescontoItem',
        'vrItemBrutoInicio',
        'vrItem',
        'vrUnitarioItem',
        'vrTotalItem',
        'vrTotalItemBruto',
        'vrDescontoAvulsoUnitario',
        'vrMargem',
        'vrMargemCMV',
        'vrMargemBruta',
        'vrPISCOFINSEntrada',
        'vrPISCOFINSSaida',
        'vrComissao',
        'vrDescontoEmbalagemInicial',
        'vrDescontoTotal',
        'vrAcrescimos',
        'qtdItemDevolucao',
        'qtdDevolucaoAvariado',
        'statusDesconto',
        'dsObservacoes',
        'user_id',
        'tenant_id'

    ];

    public function venda()
    {
        return $this->hasOne(Venda::class);
    }
}
