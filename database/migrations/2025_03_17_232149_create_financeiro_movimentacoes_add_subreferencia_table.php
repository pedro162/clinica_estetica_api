<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceiroMovimentacoesAddSubreferenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financeiro_movimentacoes', function (Blueprint $table) {
            $table->bigInteger('sub_referencia_id')->unsigned()->nullable()->default(null)->comment("Foreign key for account receivable item");
            $table->foreign("sub_referencia_id")->references('id')->on('conta_receber_items')->onDelete('cascade')->onUpdate('cascade');
            $table->string('sub_referencia', 255)->nullable()->default(null)->index();
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
            $table->dropForeign('financeiro_movimentacoes_sub_referencia_id_foreign');
            $table->dropIndex('sub_referencia_index');
            $table->dropColumn(['sub_referencia_id', 'sub_referencia']);
        });
    }
}
