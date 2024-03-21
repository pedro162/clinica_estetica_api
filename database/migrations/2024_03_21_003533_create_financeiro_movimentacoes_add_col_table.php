<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceiroMovimentacoesAddColTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financeiro_movimentacoes', function (Blueprint $table) {
            
            $table->enum('tp_movimentacao',['positiva', 'negativa'])->default('positiva');
            $table->bigInteger('pess_autor_id')->unsigned()->nullable()->default(null)->comment("Código da pessoa que realizou a movimentação no caixa");
            $table->foreign('pess_autor_id')->references('id')->on('pessoas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financeiro_movimentacoes', function (Blueprint $table) {
            $table->dropForeign('financeiro_movimentacoes_pess_autor_id_foreign');
            $table->dropColumn(['tp_movimentacao', 'pess_autor_id']);
        });
    }
}
