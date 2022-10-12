<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColsTableAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('atendimentos', function (Blueprint $table) {
            //$table->dropForeign('atendimentos_evento_agenda_id_foreign');
            //$table->dropColumn('evento_agenda_id');
            $table->date('dt_marcado')->nullable()->default(null);
            $table->time('hr_marcado')->nullable()->default(null);
            $table->bigInteger('profissional_id')->unsigned();
            $table->foreign('profissional_id')->references('id')->on('profissionals')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('prioridade',['baixa', 'normal', 'media', 'alta', 'urgente'])->default('baixa');
            $table->enum('status',['remarcado', 'finalizado', 'cancelado', 'pendente'])->default('pendente');
        });

        Schema::table('evento_agendas', function (Blueprint $table) {
            
            //$table->dropColumn('profissional_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('atendimentos', function (Blueprint $table) {
            //
        });
    }
}
