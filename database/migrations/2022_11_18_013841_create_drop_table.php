<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDropTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::table('categoria_eventos', function (Blueprint $table) {
                // Removendo a chave estrangeira de 'user_id'
                //$table->dropForeign(['user_id']);
            });

            Schema::dropIfExists('categoria_eventos');
        } catch (\Illuminate\Database\QueryException $e) {
            //
        }

        try {
            Schema::table('evento_agendas', function (Blueprint $table) {
                // Removendo chaves estrangeiras individualmente
                $table->dropForeign(['user_id']);
                $table->dropForeign(['profissional_id']);
                $table->dropForeign(['categoria_evento_id']);
            });

            Schema::dropIfExists('evento_agendas');
        } catch (\Illuminate\Database\QueryException $e) {
            //
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evento_agendas', function (Blueprint $table) {
            //
        });
    }
}
