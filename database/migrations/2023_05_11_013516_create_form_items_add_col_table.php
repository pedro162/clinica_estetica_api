<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormItemsAddColTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formulario_items', function (Blueprint $table) {
            $table->enum('alerta_resposta',['yes', 'no'])->default('yes');
            $table->string("valor_alerta")->nullable()->default(null);
        });

        Schema::table('pessoa_formulario_respostas', function (Blueprint $table) {
            $table->string("valor_alerta")->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('formulario_items', function (Blueprint $table) {
            $table->dropColumn(['alerta_resposta', 'valor_alerta']);
        });

        Schema::table('pessoa_formulario_respostas', function (Blueprint $table) {
            $table->dropColumn(['valor_alerta']);
        });
    }
}
