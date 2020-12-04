<?php

use Illuminate\Database\Seeder;
use \App\Venda;
use \App\Pessoa;
use \App\User;
use \App\Logradouro;
use \App\Filial;
class VendassSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Venda::create(
        	[
				'pessoa_id'=>Pessoa::first()->id,
				'qtdIntes'=>2,
				'vrBruto'=>200,
				'vrDesconto'=>0,
				'vrDescontoAvulsos'=>0,
				'tpDescontoAvulso'=>'',
				'vrVenda'=>200,
				'vrFrete'=>0,
				'nmPessoaContato'=>Pessoa::first()->name,
				'dsObservacao'=>'Ligar antes',
				'statusVenda'=>'expedida',
				'statusFaturamento'=>'faturado',
				'dsCancelamento'=>null,
				'dtFaturamento'=>null,
				'dtEntrega'=>null,
				'tpEntrega'=>'cif',
				'isEntregue'=>'no',
				'isEntregaProgramada'=>'no',
				'impresso'=>'no',
				'tpContato'=>'presencial',
				'freteLiberado'=>'no',
				'reservaEstoque'=>'no',
				'qtdImpressoes'=>1,
				'tpTurnoEntrega'=>null,
				'dtLiberacaoEntrega'=>null,
				'dtEmissao'=>null,
				'dtRealizacaoEntrega'=>null,
				'dtSolicitacaoCancelamento'=>null,
				'dtAutorizacaoCancelamento'=>null,
				'isSolicitacaoCancelamento'=>'no',
				'autorizadoCancelamento'=>'no',
				'idPessoaSolicitacaoCancelamento'=>1,
				'idPessoaAutorizacaoCancelamento'=>1,
				'idVendaPai'=>1,
				'hasCreditoVinculado'=>'no',
				'isDesdobrada'=>'no',
				'hasDispensaFrete'=>'no',
				'dtDispensaFrete'=>null,
				'idPessoaDispensaFrete'=>1,
				'dtEstornoComissao'=>null,
				'dsMotivoEstornoComissao'=>null,
				'hasComissaoEstornada'=>'no',
				'hasPreSeparacao'=>'no',
				'idPessoaEstornoComissao'=>1,
				'vrPesoBruto'=>50,
				'idPessoaLiberacaoDesconto'=>1,
				'idEnderecoCobranca'=>Pessoa::find(1)->logradouro->where('importancia', '=', 'principal')->first()->id,
				'idEnderecoEntrega'=>Pessoa::find(1)->logradouro->where('importancia', '=', 'principal')->first()->id,
				'user_id'=>User::first()->id,
				'active'=>'yes',
				'filial_id'=>Filial::first()->id
		    ]
        );
    }
}
