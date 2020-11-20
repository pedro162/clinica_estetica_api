<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Pessoa;

class CobrancaReceber extends Model
{
    protected $fillable = [
    	'idReferencia',
		'tpReferencia',
		'pessoa_id',
		'nrDuplicata',
		'dtCobrancaReceber',
		'dtCompetencia',
		'dtVencimentoCobrancaReceber',
		'tpLancamento',
		'dsHistorico',
		'vrBruto',
		'vrDesconto',
		'vrCobrancaReceber',
		'vrTaxas',
		'nrCodigoDeBarras',
		'nrNotaDevolucao',
		'vrDevolucao',
		'vrDescontoFinanceiro',
		'qtdProrrogacao',
		'statusCobranca',
		'isEstornado',
		'idFuncionarioEstorno',
		'dsMotivoEstorno',
		'idDesdobramentoReceber',
		'dtDesdobramento',
		'idFuncionarioDesdobramento',
		'idPessoaBaixa',
		'dtCobrancaReceberBaixa',
		'idReferenciaPrincipal',
		'tpReferenciaPrincipal',
		'nrParcela',
		'vrJuros',
		'vrJurosDispensados',
		'vrJurosProrrogacao',
		'vrTaxaJuros',
		'vrMulta',
		'vrMultaDispensada',
		'vrAcrescimos',
		'vrCreditoCliente',
		'vrPago',
		'vrIof',
		'dtCobrancaReceberRecebimento',
		'nrDocumento',
		'isEstornavel',
		'dsObservacoesBaixa',
		'dtSistemaBaixa',
		'idPessoaCustodia',
		'idPessoaCustodiaOrigem',
		'cascade',
		'statusCustodia',
		'dtCustodia',
		'dtProtesto',
		'isDuplicataOriginal',
		'user_id',
		'user_update_id',
		'active'
    ];


    public function pessoa()
    {
    	return $this->hasOne(Pessoa::class, 'id', 'pessoa_id');
    }
}
