<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddColFilialCobReceber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conta_recebers', function (Blueprint $table) {
            $table->bigInteger('filial_id')->unsigned()->nullable()->default(null);
            $table->foreign('filial_id')->references('id')->on('filials')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('forma_pagamento_id')->unsigned()->nullable()->default(null);
            $table->foreign('forma_pagamento_id')->references('id')->on('forma_pagamentos')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('plano_pagamento_id')->unsigned()->nullable()->default(null);
            $table->foreign('plano_pagamento_id')->references('id')->on('plano_pagamentos')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('operador_financeiro_id')->unsigned()->nullable()->default(null);
            $table->foreign('operador_financeiro_id')->references('id')->on('operador_financeiros')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('status', ['aberto', 'pago', 'pago_parcial', 'devolvido'])->default('aberto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conta_recebers', function (Blueprint $table) {
            //
            $table->dropForeign('conta_recebers_filial_id_foreign');
            $table->dropForeign('conta_recebers_forma_pagamento_id_foreign');
            $table->dropForeign('conta_recebers_plano_pagamento_id_foreign');
            $table->dropForeign('conta_recebers_operador_financeiro_id_foreign');

            $table->dropColumn([
                'filial_id', 'forma_pagamento_id',
                'plano_pagamento_id', 'operador_financeiro_id',
                'status'

            ]);
        });
    }
}
