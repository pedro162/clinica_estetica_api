<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();

            $table->decimal('vrSalario', 10, 2)->default(0);
            $table->string('tituloEleitor')->nullable();
            $table->string('zonaEleitor')->nullable();
            $table->string('dsNaturalidade')->nullable();
            $table->string('dsMae')->nullable();
            $table->string('nmConjuge')->nullable();
            $table->string('nrCnh')->nullable();
            $table->string('nrSerieCnh')->nullable();
            $table->string('dsUFCnh')->nullable();
            $table->string('dsBancoSalario')->nullable();
            $table->string('nrAgenciaBancoSalario')->nullable();
            $table->string('nrContaBancoSalario')->nullable();
            $table->enum('isPontoObrigatorio', ['yes', 'no'])->default('no');
            $table->enum('dsEstadoCivil', ['solteiro', 'casado', 'unidao_estavel', 'divorsiado', 'viuvo'])->default('solteiro');
            $table->enum('dsGrauInstrucao', ['fundamental', 'medio', 'superior'])->default('fundamental');
            $table->enum('status', ['admitido', 'demitido'])->default('admitido');
            $table->enum('isAprendiz', ['yes', 'no'])->default('no');
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
      `idFuncionario`,
    `nmPessoaLancamento`,
    `idSupervisor`,
    `//idFilial`,
    `//idPessoa`,
    `idCargo`,
    `stFuncionario`,
    `//isAprendiz`,
    `//vrSalario`,
    `vrUnidade`,
    `idQuadro`,
    `tpCtps`,
    `dsCtps`,
    `dtCtps`,
    `dsSerieCtps`,
    `//dsTituloEleitor`,
    `//dsZonaTituloEleitor`,
    `dtAdmissao`,
    `dtDemissao`,
    `//dsNaturalidade`,
    `dsEntradaExpediente`,
    `dsFimExpediente`,
    `dsIntervalo`,
    `dsOptanteFgts`,
    `dtOptanteFgts`,
    `dtRetratacaoFgts`,
    `dsBancoFgts`,
    `dsNacionalidade`,
    `//dsMae`,
    `//dsPai`,
    `//dsEstadoCivil`,
    `//nmConjuge`,
    `//dsGrauInstrucao`,
    `//nrCnh`,
    `//nrSerieCnh`,
    `//dsCategoriaCnh`,
    `dsEstrageiro`,
    `dsCateiraModelo19`,
    `isCasadoBrasileiro`,
    `qtdFilhosBrasileiros`,
    `dtChegadaBrasil`,
    `dsNaturalizado`,
    `dsDecreto`,
    `dtCadastroPis`,
    `nrPis`,
    `dsBancoPis`,
    `dsCodigoBanco`,
    `dsAgenciaBanco`,
    `nrContaCorrente`,
    `dsEnderecoAgenciaBanco`,
    `dsObs`,
    `tpSanguineo`,
    `isAtivo`,
    `idPessoaAutor`,
    `dtCriacao`,
    `dtAtualizacao`,
    `hasAplicativoBaixarCarga`,
    `idNivelLiberacao`,
    `//isPontoObrigatorio`,
    `idSetor`,
    `nrRegistroCnh`,
    `dsUFCnh`,
    `dtPrimeiraEmissaoCnh`,
    `dtVencimentoCnh`,
    `dsNomeContato1`,
    `dsParentescoContato1`,
    `dsEnderecoContato1`,
    `nrTelefoneContato1`,
    `dsNomeContato2`,
    `dsParentescoContato2`,
    `dsEnderecoContato2`,
    `nrTelefoneContato2`,
    `dsNomeContato3`,
    `dsParentescoContato3`,
    `dsEnderecoContato3`,
    `nrTelefoneContato3`,
    `dtEmissaoCnh`,
    `vrGratificacoes`,
    `vrFaltaGratificacao`,
    `Funcionarios_nrMatricula`,
    `tpAlmoco`,
    `isAlmoco`,
    `hasLimiteDiario`,
    `qtdLimiteDiario`,
    `qtdLimiteDiarioLanche`,
    `hrEntrada`,
    `hrSaida`,
    `hasControlePosse`,
    `qtdHorasPosse`,
    `hasLimitadorVisualizacao`,
    `tpLocalPagamentoPreferencial`,
    `nrRamalLocal`,
    `qtdDependentesSalarioFamilia`,
    `qtdDependentesImpostoDeRenda`,
    `Funcionarios_dsArquivo`,
    `diaDescanso`,
    `hasValeTransporte`,
    `validaRomaneio`,
    `vrIncentivo`,
    `hasHoraExtra`,
    `vrAdiantamento`,
    `isAvulso`,
    `hasRegiao`,
    `dsUfCtps`,
    `dsBancoSalario`,
    `//nrAgenciaBancoSalario`,
    `//nrContaBancoSalario`,
    `//tpContaSalario`,
    `dtCadastroPonto`,
    `Ponto_Escalas_Perfis_id`,
    `vrMaximoDescontoFinanceiro`,
    `idPessoaAlteracao`,
    `isCarga`,
    `hasIncentivo`,
    `hasCaixaObrigatorioFaturamento`,
    `Configuracoes_Impressoras_id`,
    `nrRotinaTelaInicial`,
    `doBaixaCreditoCliente`,
    `isFuncionario`
    
    */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funcionarios');
    }
}
