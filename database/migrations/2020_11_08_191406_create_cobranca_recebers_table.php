<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCobrancaRecebersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cobranca_recebers', function (Blueprint $table) {
            $table->id();
             $table->bigInteger('pessoa_id')->unsigned();
            $table->foreign('pessoa_id')->references('id')->on('pessoas')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idReferencia')->unsigned();
            $table->string('tpReferencia');
            $table->string('nrDuplicata')->nullable()->default(null);
            $table->date('dtCobrancaReceber')->nullable()->default(null);
            $table->date('dtCompetencia')->nullable()->default(null);
            $table->date('dtVencimentoCobrancaReceber')->nullable()->default(null);
            $table->string('tpLancamento')->nullable()->default(null);
            $table->string('dsHistorico')->nullable()->default(null);
            $table->decimal('vrBruto', 10, 2);
            $table->decimal('vrDesconto', 10, 2)->default(0);
            $table->decimal('vrCobrancaReceber', 10, 2);
            $table->decimal('vrTaxas', 10, 2)->default(0);
            $table->string('nrCodigoDeBarras')->nullable()->default(null);
            $table->string('nrNotaDevolucao')->nullable()->default(null);
            $table->decimal('vrDevolucao', 10, 2)->default(0);
            $table->decimal('vrDescontoFinanceiro', 10, 2)->default(0);
            $table->integer('qtdProrrogacao')->default(0);
            $table->enum('statusCobranca', ['aberto', 'baixado'])->default('aberto');
            $table->enum('isEstornado', ['yes', 'no'])->default('no');
            $table->bigInteger('idFuncionarioEstorno')->unsigned()->default(null);
            $table->string('dsMotivoEstorno')->nullable()->default(null);
            $table->integer('idDesdobramentoReceber')->unsigned()->nullable()->default(null);
            $table->date('dtDesdobramento')->nullable()->default(null);
             $table->bigInteger('idFuncionarioDesdobramento')->unsigned()->default(null);
            $table->bigInteger('idPessoaBaixa')->unsigned()->default(null);
            $table->date('dtCobrancaReceberBaixa')->nullable()->default(null);
            $table->integer('idReferenciaPrincipal')->nullable()->default(null);
            $table->string('tpReferenciaPrincipal')->nullable()->default(null);
            $table->integer('nrParcela')->default(1);
            $table->decimal('vrJuros',10, 2)->default(0);
            $table->decimal('vrJurosDispensados',10, 2)->default(0);
            $table->decimal('vrJurosProrrogacao',10, 2)->default(0);
            $table->decimal('vrTaxaJuros',10, 2)->default(0);
            $table->decimal('vrMulta',10, 2)->default(0);
            $table->decimal('vrMultaDispensada',10, 2)->default(0);
            $table->decimal('vrAcrescimos',10, 2)->default(0);
            $table->decimal('vrCreditoCliente',10, 2)->default(0);
            $table->decimal('vrPago',10, 2)->default(0);
            $table->decimal('vrIof',10, 2)->default(0);
            $table->date('dtCobrancaReceberRecebimento')->nullable()->default(null);
            $table->string('nrDocumento')->nullable()->default(null);
            $table->enum('isEstornavel', ['yes', 'no'])->default('no');
            $table->string('dsObservacoesBaixa')->nullable()->default(null);
            $table->date('dtSistemaBaixa')->nullable()->default(null);
            $table->bigInteger('idPessoaCustodia')->unsigned()->default(null);
            $table->bigInteger('idPessoaCustodiaOrigem')->unsigned()->default(null);
            $table->enum('statusCustodia',['confirmado', 'aguardando']);
            $table->date('dtCustodia')->nullable()->default(null);
            $table->date('dtProtesto')->nullable()->default(null);
            $table->enum('isDuplicataOriginal',['yes', 'no']);
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);         
            $table->enum('active',['yes', 'no'])->default('no');
            $table->enum('statusTransito',['expedido', 'transito', 'custodiado', 'guardado'])->default('guardado');
            $table->timestamps();
        });
    }

    /*

    `idCobrancaReceber`,
    `//nrDuplicata`,
    `idCobrancaReceberExternal`,
    `idCobrancaReceberExternalNoPrimary`,
    `//dtCobrancaReceber`,
    `tpReferencia`,
    `//idReferencia`,
    `idFilial`,
    `idPlanoDeContasSubconta`,
    `//dtCompetencia`,
    `//tpLancamento`,
    `idHistorico`,
    `//dsHistorico`,
    `tpParceiro`,
    `idPessoa`,
    `//dtVencimentoCobrancaReceber`,
    `//vrBruto`,
    `vrPcntDesconto`,
    `//vrDesconto`,
    `//vrCobrancaReceber`,
    `//vrTaxas`,
    `//nrCodigoDeBarras`,
    `//nrNotaDevolucao`,
    `//vrDevolucao`,
    `//vrDescontoFinanceiro`,
    `//qtdProrrogacao`,
    `idNotaFiscal`,
    `dtEmissaoNF`,
    `dsLocalizacaoNF`,
    `idFuncionario`,
    `//nmChequeBanco`,
    `//nrChequeAgencia`,
    `//nrChequeConta`,
    `//nrCheque`,
    `//statusCobranca`,
    `idCobrancaTipo`,
    `cdCobrancaTipo`,
    `idCaixaBaixa`,
    `idMoedaBaixa`,
    `//isEstornado`,
    `idFuncionarioEstorno`,
    `//dsMotivoEstorno`,
    `//idDesdobramentoReceber`,
    `//dtDesdobramento`,
    `//idFuncionarioDesdobramento`,
    `//hasBaixaAutomatica`,
    `//idPessoaBaixa`,
    `isAtivo`,
    `idPessoaAutor`,
    `dtCriacao`,
    `dtAtualizacao`,
    `//dtCobrancaReceberBaixa`,
    `idPessoaRca`,
    `idVendaExternal`,
    `tpOrigem`,
    `dtFechamento`,
    `statusFechamentoCarga`,
    `statusTransito`,
    `idCargaExternal`,
    `isTransitoria`,
    `isAcertada`,
    `//idReferenciaPrincipal`,
    `//tpReferenciaPrincipal`,
    `//nrParcela`,
    `//vrJuros`,
    `//vrJurosDispensados`,
    `//vrJurosProrrogacao`,
    `//vrTaxaJuros`,
    `//vrMulta`,
    `//vrMultaDispensada`,
    `//vrAcrescimos`,
    `//vrCreditoCliente`,
    `//dtCobrancaReceberRecebimento`,
    `Transportadora_Jornadas_id`,
    `idCobrancaReceber_estorno`,
    `//vrPago`,
    `isAlteradoManual`,
    `nrNotaFiscal`,
    `//nrDocumento`,
    `Financeiro_PlanosDePagamentos_id`,
    `Financeiro_OperadoresFinanceiros_id`,
    `Financeiro_OperadoresFinanceiros_Bandeiras_id`,
    `idPlanoDeContasSubconta_taxas`,
    `//isEstornavel`,
    `Financeiro_Cobrancas_Receber_Cheques_nrBanco`,
    `Financeiro_Cobrancas_Receber_Cheques_nrAgencia`,
    `Financeiro_Cobrancas_Receber_Cheques_nrConta`,
    `Financeiro_Cobrancas_Receber_Cheques_numero`,
    `Financeiro_Cobrancas_Receber_Cheques_dtVencimento`,
    `Financeiro_Cobrancas_Receber_Cheques_valor`,
    `Financeiro_Cobrancas_Receber_Cheques_vrJuros`,
    `Financeiro_Cobrancas_Receber_Cheques_vrIOF`,
    `Financeiro_Cobrancas_Receber_Cheques_vrTarifa`,
    `Financeiro_Cobrancas_Receber_Cheques_status`,
    `isTerceiro`,
    `nmTerceiro`,
    `//idPessoaCustodia`,
    `//idPessoaCustodiaOrigem`,
    `//statusCustodia`,
    `//dtCustodia`,
    `statusDuplicata`,
    `//dtProtesto`,
    `dtDevedores`,
    `dtRemoveNegativacao`,
    `statusNegativacao`,
    `idPessoaProtesto`,
    `idPessoaDevedor`,
    `dsArquivoProtesto`,
    `dsArquivo`,
    `nrDoc`,
    `dsArquivoNeg`,
    `dsArquivoRemoveNeg`,
    `dsObservacoesBaixa`,
    `dtSistemaBaixa`,
    `hasEstornoDesconto`,
    `idCaixaDesconto`,
    `isValorRecuperado`,
    `isVerificado`,
    `dtVerificacao`,
    `idPessoaVerificacao`,
    `dsJustificativaDesdobramento`,
    `isCobranca`,
    `vrTotalJurosBaixa`,
    `vrTotalDescontosBaixa`,
    `vrDescontosAutorizados`,
    `idCaixaRetirada`,
    `qtdParcelas`,
    `idVenda`,
    `isDuplicataOriginal`,
    `isFundoPerdido`,
    `Financeiro_Caixas_Fechamentos_id`
    */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cobranca_recebers');
    }
}
