<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\VendaItem;

class Venda extends Model
{
	protected $fillable  = [
		'pessoa_id',
		'qtdIntes',
		'vrBruto',
		'vrDesconto',
		'vrDescontoAvulsos',
		'tpDescontoAvulso',
		'vrVenda',
		'vrFrete',
		'nmPessoaContato',
		'dsObservacao',
		'statusVenda',
		'statusFaturamento',
		'dsCancelamento',
		'dtFaturamento',
		'dtEntrega',
		'tpEntrega',
		'isEntregue',
		'isEntregaProgramada',
		'impresso',
		'tpContato',
		'freteLiberado',
		'reservaEstoque',
		'qtdImpressoes',
		'tpTurnoEntrega',
		'dtLiberacaoEntrega',
		'dtEmissao',
		'dtRealizacaoEntrega',
		'dtSolicitacaoCancelamento',
		'dtAutorizacaoCancelamento',
		'isSolicitacaoCancelamento',
		'autorizadoCancelamento',
		'idPessoaSolicitacaoCancelamento',
		'idPessoaAutorizacaoCancelamento',
		'idVendaPai',
		'hasCreditoVinculado',
		'isDesdobrada',
		'hasDispensaFrete',
		'dtDispensaFrete',
		'idPessoaDispensaFrete',
		'dtEstornoComissao',
		'dsMotivoEstornoComissao',
		'hasComissaoEstornada',
		'hasPreSeparacao',
		'idPessoaEstornoComissao',
		'vrPesoBruto',
		'idPessoaLiberacaoDesconto',
		'idEnderecoCobranca',
		'idEnderecoEntrega',
		'user_id',
		'user_update_id',
		'active',
		'tenant_id'
	];


	public function vendaItem()
	{
		return $this->hasMany(VendaItem::class);
	}
}
