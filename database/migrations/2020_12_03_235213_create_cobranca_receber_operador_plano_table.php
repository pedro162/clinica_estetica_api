<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCobrancaReceberOperadorPlanoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cobranca_recebers', function (Blueprint $table) {
            $table->bigInteger('pl_pgto_id')->unsigned();
            $table->foreign('pl_pgto_id')->references('id')->on('plano_pagamentos')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('op_finan_id')->unsigned();
            $table->foreign('op_finan_id')->references('id')->on('operador_financeiros')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('cobranca_receber_operador_plano');
    }
}
