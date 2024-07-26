<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddColsAtendimento02 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('atendimentos', function (Blueprint $table) {
            $table->enum('prioridade', ['baixa', 'normal', 'media', 'alta', 'urgente'])->default('baixa');
            $table->bigInteger('filial_id')->unsigned()->nullable()->default(null);
            $table->foreign('filial_id')->references('id')->on('filials')->onUpdate('cascade')->onDelete('cascade');
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
            $table->dropForeign('atendimentos_filial_id_foreign');
            $table->dropColumn(['prioridade', 'filial_id']);
        });
    }
}
