(<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormaPagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()//ok
    {
        Schema::create('forma_pagamentos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cdCobrancaTipo');
            $table->enum('hasComissao', ['yes', 'no'])->default('no');
            $table->enum('tpPagamento', ['a vista', 'a prazo', 'cartao'])->default('a vista');
            $table->enum('hasDesdobramento', ['yes', 'no'])->default('yes');
            $table->enum('hasLimiteDeCredito', ['yes', 'no'])->default('no');
            $table->enum('hasAcertoBalcao', ['yes', 'no'])->default('no');
            $table->enum('hasAcertoCaixa', ['yes', 'no'])->default('no');
            $table->enum('hasEntrada', ['yes', 'no'])->default('no');
            $table->enum('tipo', ['cartao_credito', 'cartao_debito', 'boleto', 'dinheiro'])->default('dinheiro');
            $table->enum('hasOperadorFinanceiro', ['yes', 'no'])->default('no');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);
            
            $table->enum('active',['yes', 'no'])->default('no');
            $table->softDeletes();
            
            $table->timestamps();
        });
    }

    /*
    `idCobrancaTipo`,
    `//cdCobrancaTipo`,
    `nmCobrancaTipo`,
    `//hasComissao`,
    `idMoeda`,
    `vrTaxaJuros`,
    `qtdDiasLiberacaoDeCredito`,
    `qtdDiasBloqueioAutomatico`,
    `qtdDiasPrazoMaximo`,
    `qtdPrazoMaximoVenda`,
    `dsLetraCobranca`,
    `tpFormaPagamentoECF`,
    `qtdDiasDeCarencia`,
    `idClienteCartao`,
    `idPessoa`,
    `idCobrancaTipoDesconto`,
    `idPlanoDeContasSubconta`,
    `qtdPrazo`,
    `vrTaxaAdm`,
    `tpOperacao`,
    `//tpPagamento`,
    `idOperadora`,
    `hasExibeDevolucaoDeCliente`,
    `hasNotaPromissoria`,
    `hasBaixaCaixaBanco`,
    `hasBoletoBancario`,
    `hasExibeNoAcertoDeCaixa`,
    `hasValidaLimCreditoECF`,
    `hasPermiteSelecaoClienteECF`,
    `hasUtilizarTaxa`,
    `hasBloqueioAutomatico`,
    `hasAlteraNoDesdobramento`,
    `hasExibirNoFaturamento`,
    `hasCobrancaBroker`,
    `hasAutenticacaoMecanicaAcertoDeCarga`,
    `hasBaixaNoContasAReceber`,
    `hasEnviarParaFV`,
    `hasCobrancaDeCustodia`,
    `hasDepositoBancario`,
    `hasFluxoDeCaixa`,
    `hasCartaoDeCredito`,
    `hasExportarAutosservico`,
    `hasPermiteContraValeAutosservico`,
    `hasPermiteBaixaManual`,
    `hasCobrancaEmTransito`,
    `hasCheque`,
    `hasLogisticaTerceirizada`,
    `qtdDiasFluxo`,
    `colFluxo`,
    `nivelVenda`,
    `idFilial`,
    `vrMinimoVenda`,
    `nrMaxParcelas`,
    `cdProtesto`,
    `qtdDiasProtesto`,
    `dsObservacaoNF`,
    `isCartaoDeCredito`,
    `isDinheiro`,
    `isAtivo`,
    `idPessoaAutor`,
    `dtCriacao`,
    `dtAtualizacao`,
    `isAberto`,
    `vrTaxaBoleto`,
    `tpCobrancaBoleto`,
    `//hasDesdobramento`,
    `idReferencia`,
    `tpReferencia`,
    `//hasLimiteDeCredito`,
    `//hasAcertoCaixa`,
    `hasNotaFiscal`,
    `hasControleCustodia`,
    `hasPedidoVenda`,
    `isDevolucao`,
    `//hasAcertoBalcao`,
    `isVale`,
    `//hasEntrada`,
    `hasOperadorFinanceiro`,
    `hasQtdParcelasLiberado`,
    `hasContrato`,
    `hasReciboBaixa`,
    `hasCobrancaJuros`,
    `vrMaximoDesconto`,
    `vrMaximoPcntDesconto`,
    `hasTravaDesdobramentoAcerto`,
    `hasDebitarCreditoDeCliente`,
    `nmClassificacao`,
    `hasConsumidorFinal`,
    `hasBloqueioDesconto`,
    `hasPagamentoEntrega`,
    `isExibirNFe`,
    `vrPcntAcrescimos`,
    `cdReferenciaFiscal`,
    `Fiscal_NotaFiscal_tpPagamento`,
    `hasProrrogacaoPrazo`,
    `qtdDiasMaximoProrrogacaoPrazo`,
    `hasManterDiaPrimeiraParcela`,
    `isEntradaRenegociacao`,
    `isRenegociacao`,
    `idPlanoDeContasSubconta__juros`,
    `nmClassificacaoVenda`,
    `hasValidaRenda`,
    `hasValidaComprovanteEndereco`,
    `hasValidaParcela`,
    `hasCreditoClientePrevenda`,
    `isCreditoCliente`,
    `dsAtalho`,
    `cdAtalho`,
    `Financeiro_PlanosDePagamentos_idPadrao`,
    `Financeiro_OperadoresFinanceiros_idPadrao`
    */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forma_pagamentos');
    }
}
