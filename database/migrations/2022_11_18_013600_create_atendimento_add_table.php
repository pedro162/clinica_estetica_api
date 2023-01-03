<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtendimentoAddTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('atendimentos', function (Blueprint $table) {
            $table->date('dt_fim')->nullable()->default(null);
            $table->time('hr_fim')->nullable()->default(null);
            $table->string("name_atendido")->nullable(true)->default(null);
            $table->enum('tipo',['servico', 'avaliacao', 'consulta', 'retorno'])->default('consulta');
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
