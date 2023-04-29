<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddDropColAtendimentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('atendimentos', function (Blueprint $table) {
            $table->dropForeign('atendimentos_convenio_id_foreign');
            $table->dropColumn(['convenio_id']);
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
            $table->bigInteger('convenio_id')->unsigned()->nullable()->default(null);
            $table->foreign('convenio_id')->references('id')->on('convenios')->onUpdate('cascade')->onDelete('cascade');
        });
    }
}
