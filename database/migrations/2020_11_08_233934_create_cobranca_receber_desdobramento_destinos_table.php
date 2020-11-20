<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCobrancaReceberDesdobramentoDestinosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cobranca_receber_desdobramento_destinos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('c_recebers_id')->unsigned();
            $table->foreign('c_recebers_id')->references('id')->on('cobranca_recebers')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('c_rec_des_id')->unsigned();
            $table->foreign('c_rec_des_id')->references('id')->on('cobranca_receber_desdobramentos')->onDelete('cascade')->onUpdate('cascade');


            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);         
            $table->enum('active',['yes', 'no'])->default('no');
            $table->timestamps();
        });
    }

    /*
    `idDesdobramentosReceberDestino`,
    `idCobrancaReceber`,
    `idDesdobramentoReceber`,
    `isAtivo`,
    `idPessoaAutor`,
    `dtCriacao`,
    `dtAtualizacao`
    */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cobranca_receber_desdobramento_destinos');
    }
}
