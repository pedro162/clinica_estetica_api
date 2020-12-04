<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperadorFinanceirosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operador_financeiros', function (Blueprint $table) {
            $table->id();
            $table->decimal('vrTarifa', 10, 2);
            $table->decimal('vrDesconto', 10, 2);
            $table->decimal('vrPorcentagemDesconto', 10, 2)->default(0);
            $table->integer('nrRemessaAtual')->unsigned()->default(0);
            $table->integer('nrNossoNumero')->unsigned()->default(0);
            $table->integer('qtdDiasProtesto')->unsigned()->default(0);
            $table->enum('isAssumeDuplicata', ['yes', 'no'])->default('no');
            $table->enum('tpLocalAtualizacaoBoleto', ['empresa', 'banco'])->default('empresa');
            $table->enum('isPadrao', ['yes', 'no'])->default('no');
            $table->enum('isLiberado', ['yes', 'no'])->default('no');

            $table->bigInteger('pessoa_id')->unsigned();
            $table->foreign('pessoa_id')->references('id')->on('pessoas')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('filial_id')->unsigned();
            $table->foreign('filial_id')->references('id')->on('filials')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);            
            $table->enum('active',['yes', 'no'])->default('no');
            $table->timestamps();
        });
    }


    /*
    `Financeiro_OperadoresFinanceiros_id`,
    `isAtivo`,
    `idPessoaAutor`,
    `dtCriacao`,
    `dtAlteracao`,
    `Financeiro_OperadoresFinanceiros_nome`,
    `Financeiro_OperadoresFinanceiros_apelido`,
    `Financeiro_OperadoresFinanceiros_nomeRemessa`,
    `Pessoas_idPessoa`,
    `Configuracoes_Filiais_idFilial`,
    `Financeiro_OperadoresFinanceiros_vrTarifa`,
    `Financeiro_OperadoresFinanceiros_vrPcntDesconto`,
    `Financeiro_Caixas_idCaixa`,
    `Financeiro_PlanoDeContas_Subcontas_idPlanoDeContasSubconta`,
    `Financeiro_Cobrancas_Tipos_idCobrancaTipo`,
    `nrConvenio`,
    `nrRemessaAtual`,
    `nrCarteira`,
    `cdCarteira`,
    `cdCedente`,
    `nrNossoNumero`,
    `qtdDiasProtesto`,
    `dsDiasProtesto`,
    `isAssumeDuplicata`,
    `isDescontoEmbutido`,
    `isPadrao`,
    `tpLocalAtualizacaoBoleto`,
    `vrParcelaMaxima`,
    `isLiberado`,
    `nrAgencia`,
    `nrConta`,
    `nrDigitoConta`,
    `nrCodigoEmpresa`,
    `Fiscal_NotaFiscal_tBand`,
    `Configuracoes_Filiais_idFilial__forcar`,
    `Financeiro_OperadoresFinanceiros_id__vinculado`
    */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operador_financeiros');
    }
}
