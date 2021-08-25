<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()//ok
    {
        Schema::create('filials', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pessoa_id')->unsigned();
            $table->foreign('pessoa_id')->references('id')->on('pessoas')->onDelete('cascade')->onUpdate('cascade');
            $table->string('dsAtividade');
            $table->string('dsTextoContrato')->nullable()->default(null);
            $table->string('nrExercicioImplantacaoContabil')->nullable()->default(null);

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);
            
            $table->enum('active',['yes', 'no'])->default('no');
            $table->softDeletes();
            
            $table->timestamps();
        });
    }
    /*
     `idFilial`,
    `idFilialExternal`,
    `//idPessoa`,
    `dsRazaoSocial`,
    `nmApelidoFilial`,
    `dsEndereco`,
    `dsAtividade`,
    `idBairro`,
    `nrTelefone`,
    `dsEmail`,
    `dsContato`,
    `nrCEP`,
    `idFilialGrupo`,
    `nrCNPJ`,
    `nrIM`,
    `nrIE`,
    `dsOrgao`,
    `vrCapital`,
    `dtInicio`,
    `dtFim`,
    `idRegistro`,
    `dtRegistro`,
    `nmContador`,
    `nmRepresentante`,
    `idContador`,
    `tpCNPJ`,
    `idPessoaContato`,
    `isAtivo`,
    `idPessoaAutor`,
    `dtCriacao`,
    `dtAtualizacao`,
    `dsTextoImpressao`,
    `dsTextoContrato`,
    `idRegiao`,
    `FolhaDePagamentos_CNAE_dsCNAE`,
    `vrFAP`,
    `nrExercicioImplantacaoContabil`,
    `isConfiguradaFiscal`,
    `isImplantada`,
    `CRT`,
    `idTabelaDePrecosPadrao`,
    `tpCertificado`,
    `IsSMTP`,
    `SMTPAuth`,
    `SMTPSecure`,
    `SMTPHost`,
    `SMTPPort`,
    `dsEmailContabilidade`,
    `dsEmailFilial`,
    `cdSenhaEmailFilial`,
    `hasServidorEmailProprio`,
    `dsDominioEmail`,
    `hasPerfilSomenteCliente`,
    `dsTemplateEmailPadrao`,
    `Clientes_CondicoesComerciais_id`
    */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filials');
    }
}
