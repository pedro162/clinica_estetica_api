<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddColPrazoPlanoPgto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plano_pagamentos', function (Blueprint $table) {
            $table->integer('qtdMinParcelas')->unsigned()->default(1);
            $table->integer('qtd_dias_pri_parcela')->unsigned()->default(0);
            $table->integer('qtdDiasIntervaloParcelas')->unsigned()->default(1); 
            $table->enum('exibe_balcao',['yes', 'no'])->default('no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plano_pagamentos', function (Blueprint $table) {
            //$table->dropColumn(['vrItemBruto', 'qtd_devolucao']);
            $table->dropColumn(['qtd_dias_pri_parcela','qtdDiasIntervaloParcelas', 'qtdMinParcelas']);
        });
    }
}
