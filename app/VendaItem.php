<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Venda;

class VendaItem extends Model
{
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
