<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaixasAddColTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('caixas', function (Blueprint $table) {
            $table->bigInteger('filial_id')->unsigned()->nullable()->default(null)->comment("Código da filial do caixa");
            $table->foreign('filial_id')->references('id')->on('filials')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('caixas', function (Blueprint $table) {
            $table->dropForeign('caixas_filial_id_foreign');
            $table->dropColumn(['filial_id']);
        });
    }
}
