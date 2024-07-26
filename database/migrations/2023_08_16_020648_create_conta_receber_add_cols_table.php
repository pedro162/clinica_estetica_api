<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContaReceberAddColsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conta_receber_items', function (Blueprint $table) {
            //$table->bigInteger('filial_id')->unsigned();
            //$table->foreign('filial_id')->references('id')->on('filials')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('plano_pagamento_id')->unsigned()->nullable()->default(null);
            $table->foreign('plano_pagamento_id')->references('id')->on('plano_pagamentos')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('operador_financeiro_id')->unsigned()->nullable()->default(null);
            $table->foreign('operador_financeiro_id')->references('id')->on('operador_financeiros')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('conta_receber_cartaos', function (Blueprint $table) {
            //$table->bigInteger('filial_id')->unsigned();
            //$table->foreign('filial_id')->references('id')->on('filials')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('cont_receb_item_id')->unsigned()->nullable()->default(null);
            $table->foreign('cont_receb_item_id')->references('id')->on('conta_receber_items')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conta_receber_items', function (Blueprint $table) {

            $table->dropForeign('conta_receber_items_plano_pagamento_id_foreign');
            $table->dropForeign('conta_receber_items_operador_financeiro_id_foreign');
            $table->dropColumn([
                'plano_pagamento_id', 'operador_financeiro_id',
            ]);
        });

        Schema::table('conta_receber_cartaos', function (Blueprint $table) {

            $table->dropForeign('conta_receber_cartaos_cont_receb_item_id_foreign');
            $table->dropColumn([
                'cont_receb_item_id'
            ]);
        });
    }
}
