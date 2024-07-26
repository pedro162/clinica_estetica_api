<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EventoAgendasAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evento_agendas', function (Blueprint $table) {

            $table->string('descricao')->nullable()->default(null);
            $table->string('periodo')->nullable()->default(null);
            $table->date('dt_inicio')->nullable()->default(null);
            $table->date('dt_fim')->nullable()->default(null);
            $table->time('hr_inicio')->nullable()->default(null);
            $table->time('hr_fim')->nullable()->default(null);
            $table->bigInteger('profissional_id')->unsigned()->nullable()->default(null);
            $table->foreign('profissional_id')->references('id')->on('profissionals')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('categoria_evento_id')->unsigned()->nullable()->default(null);
            $table->foreign('categoria_evento_id')->references('id')->on('categoria_eventos')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('recorrente', ['yes', 'no'])->default('no');
            $table->enum('nivel', ['baixo', 'medio', 'auto', 'urgente'])->default('baixo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evento_agendas', function ($table) {
            $table->dropColumn('descricao');
            $table->dropColumn('periodo');
            $table->dropColumn('dt_inicio');
            $table->dropColumn('dt_fim');
            $table->dropColumn('hr_inicio');
            $table->dropColumn('hr_fim');
            $table->dropColumn('profissional_id');
            $table->dropColumn('categoria_evento_id');
            $table->dropColumn('recorrente');
            $table->dropColumn('nivel');
        });
    }
}
