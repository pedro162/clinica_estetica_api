<?php

use Illuminate\Database\Seeder;
use \App\CobrancaReceber;
use \App\Venda;
use \App\User;
use \App\Pessoa;
use \App\Filial;

class CobrancaRecebersSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         CobrancaReceber::create([
	    	'idReferencia'=>Venda::first()->id,
			'tpReferencia'=>Venda::class,
			'pessoa_id'=>Pessoa::find(1)->id,
			'nrDuplicata'=>12,
			'dtCobrancaReceber'=>null,
			'dtCompetencia'=>null,
			'dtVencimentoCobrancaReceber'=>null,
			'tpLancamento'=>null,
			'dsHistorico'=>'Venda nº '.Venda::first()->id.' '.date('d-m-Y'),
			'vrBruto'=>Venda::first()->vrBruto,
			'vrDesconto'=>0,
			'vrCobrancaReceber'=>Venda::first()->vrBruto,
			'vrTaxas'=>0,
			'nrCodigoDeBarras'=>null,
			'nrNotaDevolucao'=>null,
			'vrDevolucao'=>0,
			'vrDescontoFinanceiro'=>0,
			'qtdProrrogacao'=>0,
			'statusCobranca'=>'aberto',
			'isEstornado'=>'no',
			'idFuncionarioEstorno'=>1,
			'dsMotivoEstorno'=>null,
			'idDesdobramentoReceber'=>1,
			'dtDesdobramento'=>null,
			'idFuncionarioDesdobramento'=>User::first()->id,
			'idPessoaBaixa'=>User::first()->id,
			'dtCobrancaReceberBaixa'=>null,
			'idReferenciaPrincipal'=>Venda::first()->id,
			'tpReferenciaPrincipal'=>null,
			'nrParcela'=>1,
			'vrJuros'=>0,
			'vrJurosDispensados'=>0,
			'vrJurosProrrogacao'=>0,
			'vrTaxaJuros'=>0,
			'vrMulta'=>0,
			'vrMultaDispensada'=>0,
			'vrAcrescimos'=>0,
			'vrCreditoCliente'=>0,
			'vrPago'=>0,
			'vrIof'=>0,
			'dtCobrancaReceberRecebimento'=>null,
			'nrDocumento'=>null,
			'isEstornavel'=>'yes',
			'dsObservacoesBaixa'=>null,
			'dtSistemaBaixa'=>null,
			'idPessoaCustodia'=>Pessoa::first()->id,
			'idPessoaCustodiaOrigem'=>Pessoa::first()->id,
			'statusCustodia'=>'aguardando',
			'dtCustodia'=>null,
			'dtProtesto'=>null,
			'isDuplicataOriginal'=>'yes',
			'user_id'=>User::first()->id,
			'user_update_id'=>User::first()->id,
			'active'=>'yes',
			'filial_id'=>Filial::first()->id
	    ]);
    }
}
