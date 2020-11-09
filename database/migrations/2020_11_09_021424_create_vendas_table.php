<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pessoa_id')->unsigned();
            $table->foreign('pessoa_id')->references('id')->on('pessoas')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('item_id')->unsigned();
            $table->string('tpReferencia');
            $table->integer('qtdIntes')->unsigned();
            $table->decimal('vrBruto', 10, 2);
            $table->decimal('vrDesconto', 10, 2)->default(0);
            $table->decimal('vrDescontoAvulsos', 10, 2)->default(0);
            $table->string('tpDescontoAvulso')->nullable();
            $table->decimal('vrVenda', 10, 2)->default(0);
            $table->decimal('vrFrete', 10, 2)->default(0);
            $table->string('nmPessoaContato')->nullable();
            $table->string('dsObservacao')->nullable();
            $table->enum('statusVenda',['ativa', 'orcamento', 'cancelada', 'cortada', 'aguardando','prevenda', 'cupom', 'pendente', 'mondatada', 'entrege', 'carregada', 'expedida', 'finalizada'])->default('aguardando');
            $table->enum('statusFaturamento',['aberto', 'faturado'])->default('aberto');
            $table->string('dsCancelamento')->nullable();
            $table->date('dtFaturamento')->nullable();
            $table->date('dtEntrega')->nullable();
            $table->enum('tpEntrega',['cif', 'fob', 'dap', 'exw', 'ddp'])->default('cif');
            $table->enum('isEntregue',['yes', 'no'])->default('no');
            $table->enum('isEntregaProgramada',['yes', 'no'])->default('no');
            $table->enum('impresso',['yes', 'no'])->default('no');
            $table->enum('tpContato',['presencial', 'telefone', 'email'])->default('presencial');
            $table->enum('freteLiberado',['yes', 'no'])->default('no');
            $table->enum('reservaEstoque',['yes', 'no'])->default('no');
            $table->integer('qtdImpressoes')->default(0);
            $table->date('tpTurnoEntrega')->nullable();
            $table->date('dtLiberacaoEntrega')->nullable();
            $table->date('dtEmissao')->nullable();
            $table->date('dtRealizacaoEntrega')->nullable();
            $table->date('dtSolicitacaoCancelamento')->nullable();
            $table->date('dtAutorizacaoCancelamento')->nullable();

            $table->enum('isSolicitacaoCancelamento',['yes', 'no'])->default('no');
            $table->enum('autorizadoCancelamento',['yes', 'no'])->default('no');
            $table->bigInteger('idPessoaSolicitacaoCancelamento')->unsigned();
            $table->foreign('idPessoaSolicitacaoCancelamento')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->bigInteger('idPessoaAutorizacaoCancelamento')->unsigned();
            $table->foreign('idPessoaAutorizacaoCancelamento')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade')->nullable();            
            $table->bigInteger('idVendaPai')->unsigned();
            $table->foreign('idVendaPai')->references('id')->on('vendas')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->enum('hasCreditoVinculado',['yes', 'no'])->default('no');
            $table->enum('isDesdobrada',['yes', 'no'])->default('no');
            $table->enum('hasDispensaFrete',['yes', 'no'])->default('no');
            $table->date('dtDispensaFrete')->nullable();
            $table->bigInteger('idPessoaDispensaFrete')->unsigned();
            $table->foreign('idPessoaDispensaFrete')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->date('dtEstornoComissao')->nullable();
            $table->string('dsMotivoEstornoComissao')->nullable();
            $table->enum('hasComissaoEstornada',['yes', 'no'])->default('no');
            $table->enum('hasPreSeparacao',['yes', 'no'])->default('no');
            $table->bigInteger('idPessoaEstornoComissao')->unsigned();
            $table->foreign('idPessoaEstornoComissao')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->decimal('vrPesoBruto', 10, 2)->default(0);
            $table->bigInteger('idPessoaLiberacaoDesconto')->unsigned();
            $table->foreign('idPessoaLiberacaoDesconto')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->bigInteger('idEnderecoCobranca')->unsigned();
            $table->foreign('idEnderecoCobranca')->references('id')->on('logradouros')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('idEnderecoEntrega')->unsigned();
            $table->foreign('idEnderecoEntrega')->references('id')->on('logradouros')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable();
            $table->foreign('user_update_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            
            $table->enum('active',['yes', 'no'])->default('no');
            $table->timestamps();
        });
    }

    /*
     `idVenda`,
    `idVendaExternal`,
    `idTransvendaExternal`,
    `idFilial`,
    `//idPessoa`,
    `//nmPessoaContato`,
    `//idEnderecoCobranca`,
    `//idEnderecoEntrega`,
    `idPessoaRca`,
    `idPessoaRcaBKP`,
    `dtVenda`,
    `//vrBruto`,
    `vrPcntDesconto`,
    `//vrDesconto`,
    `//vrDescontoAvulsos`,
    `//tpDescontoAvulso`,
    `//vrVenda`,
    `vrAdiantamentos`,
    `//vrFrete`,
    `//dsObservacao`,
    `idCFOP`,
    `//tpEntrega`,
    `isAtivo`,
    `idPessoaAutor`,
    `qtdProdutos`,
    `nrOrdemDeCompra`,
    `dtCriacao`,
    `dtAtualizacao`,
    `//statusFaturamento`,
    `//dtFaturamento`,
    `nmPessoaRCA`,
    `idFaturamento`,
    `//dsCancelamento`,
    `idPessoaCancelamento`,
    `//dtCancelamento`,
    `//dtEntrega`,
    `//tpTurnoEntrega`,
    `//statusVenda`,
    `//dtLiberacaoEntrega`,
    `isImportacaoCompleta`,
    `//isEntregue`,
    `//isMontada`,
    `//isCarregada`,
    `//isExpedida`,
    `tpEntregaCIF`,
    `isAnalisado`,
    `tpAnalise`,
    `idPessoaAnalise`,
    `dtAnalise`,
    `//isEntregaProgramada`,
    `//statusImpressao`,
    `//dtEmissao`,
    `statusVendedor`,
    `idPessoaVendedor`,
    `dtLiberacaoVendedor`,
    `idCobrancaTipo`,
    `cdCobrancaTipo`,
    `tpPagamento`,
    `idCarga`,
    `dsPlanoPagamento`,
    `//qtdImpressoes`,
    `statusVerificacao`,
    `//tpContato`,
    `//statusLiberacaoFrete`,
    `isFreteAlterado`,
    `dtProtocolo`,
    `idPessoaProtocolo`,
    `isProtocolado`,
    `Financeiro_PlanosDePagamentos_id`,
    `//isFinalizada`,
    `//idPessoaLiberacaoDesconto`,
    `isOrcamento`,
    `dtOrcamento`,
    `statusOrcamento`,
    `idMotivoRejeicao`,
    `tpTabelaDePrecos`,
    `hasEstoqueReservado`,
    `hasReservado`,
    `tpLocalPagamento`,
    `nrDuplicata`,
    `isCancelada`,
    `tpCancelamento`,
    `idMotivoDevolucao`,
    `dsArquivoDevolucao`,
    `//idPessoaSolicitacaoCancelamento`,
    `//isSolicitacaoCancelamento`,
    `//dtSolicitacaoCancelamento`,
    `//isAutorizacaoCancelamento`,
    `//idPessoaAutorizacaoCancelamento`,
    `//dtAutorizacaoCancelamento`,
    `vrFaixaCompras`,
    `//dtRealizacaoEntrega`,
    `quantParcelas`,
    `//hasComissaoEstornada`,
    `//idPessoaEstornoComissao`,
    `//dtEstornoComissao`,
    `//dsMotivoEstornoComissao`,
    `qtdMontado`,
    `//vrPesoBruto`,
    `OBS`,
    `tpNFVenda`,
    `idNotaFiscal`,
    `idNotaFiscalEntregaFutura`,
    `nrNotaFiscal`,
    `idNotaFiscalDevolucao`,
    `dsArquivo`,
    `tpCorDistancia`,
    `tpCorPresencial`,
    `dsLatitudeLongitude`,
    `dsArquivo1`,
    `dsArquivo2`,
    `dsArquivo3`,
    `vrPcntMargem`,
    `tpColorMargem`,
    `vrAcrescimos`,
    `vrEntrada`,
    `vrTotalEntrada`,
    `//hasDispensaFrete`,
    `//idPessoaDispensaFrete`,
    `//dtDispensaFrete`,
    `dtFaturamentoRetroativo`,
    `vrSaldoVerbas`,
    `vrMargemDisponivel`,
    `vrFreteManual`,
    `pid`,
    `qVol`,
    `esp`,
    `nVol`,
    `NF_TRANSP_idPessoa`,
    `NF_TRANSP_idVeiculo`,
    `NF_vrPesoLiquido`,
    `NF_TRANSP_modFrete`,
    `NF_TRANSP_placa`,
    `NF_TRANSP_placa_uf`,
    `//hasPreSeparacao`,
    `idDesdobramentoReceber`,
    `Funcionarios_Rca_Grupos_id`,
    `nrCPFNota`,
    `idVendaPai`,
    `isDesdobrada`,
    `hasCreditoVinculado`,
    `idPessoaParceiro`,
    `tpEntregaProprio`,
    `nrTelefoneWhatsapp`,
    `tpVenda`,
    `dsObservacaoInterna`,
    `statusProducao`
    */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendas');
    }
}
