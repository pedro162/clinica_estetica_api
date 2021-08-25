<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdemServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordem_servicos', function (Blueprint $table) {
            $table->id();

            $table->decimal('vrTotal', 10, 2)->default(0);
            $table->enum('status',['aberto', 'cancelado', 'aguardando', 'concluido'])->default('aguardando');
            $table->string('observacao')->nullable();

            $table->string('dsArquivo')->nullable();
            $table->bigInteger('pessoa_id')->unsigned();
            $table->foreign('pessoa_id')->references('id')->on('pessoas')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('pessoa_rca_id')->unsigned();
            $table->foreign('pessoa_rca_id')->references('id')->on('pessoas')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('filial_id')->unsigned();
            $table->foreign('filial_id')->references('id')->on('filials')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);            
            $table->enum('active',['yes', 'no'])->default('no');
            $table->softDeletes();
            
            $table->timestamps();
        });
    }

    /*
    `//OrdensDeServicos_id`,
    `isAtivo`,
    `idPessoaAutor`,
    `//idPessoaRca`,
    `dtCriacao`,
    `dtAlteracao`,
    `//Pessoas_idPessoa`,
    `//dsArquivo`,
    `OrdensDeServicos_nmPessoaSolicitante`,
    `OrdensDeServicos_dtAprovacao`,
    `Pessoas_idPessoa__aprovacao`,
    `OrdensDeServicos_dtFinalizacao`,
    `Pessoas_idPessoa__finalizacao`,
    `OrdensDeServicos_status`,
    `//OrdensDeServicos_vrTotal`,
    `OrdensDeServicos_idReferencia`,
    `OrdensDeServicos_tpReferencia`,
    `OrdensDeServicos_dsObservacoes`,
    `Pessoas_idPessoa__cancelamento`,
    `OrdensDeServicos_dtCancelamento`,
    `tpCaixaBaixa`,
    `//Configuracoes_Filiais_idFilial`
    */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordem_servicos');
    }
}
