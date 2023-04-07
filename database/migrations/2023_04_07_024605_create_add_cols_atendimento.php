<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddColsAtendimento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('atendimentos', function (Blueprint $table) {
            $table->date('dt_inicio')->nullable()->default(null);
            $table->time('hr_inicio')->nullable()->default(null);
            $table->enum('status',['remarcado', 'finalizado', 'cancelado', 'pendente'])->default('pendente');
            $table->dropForeign('atendimentos_evento_agenda_id_foreign');
            $table->dropColumn('evento_agenda_id');
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
            $table->dropColumn(['dt_inicio', 'hr_inicio', 'status']);
        });
    }
}
