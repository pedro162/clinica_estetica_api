<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePessoaFormularioAddColumns01Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pessoa_formularios', function (Blueprint $table) {
            $table->bigInteger('filial_id')->unsigned()->default(0);
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
        Schema::table('pessoa_formularios', function (Blueprint $table) {
            $table->dropForeign('pessoa_formularios_filial_id_foreign');

            $table->dropColumn([
                'filial_id',

            ]);
        });
    }
}
