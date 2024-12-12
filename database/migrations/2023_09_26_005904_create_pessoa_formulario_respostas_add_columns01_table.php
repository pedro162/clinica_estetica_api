<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePessoaFormularioRespostasAddColumns01Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pessoa_formulario_respostas', function (Blueprint $table) {
            $table->bigInteger('form_item_id')->unsigned()->nullable()->default(null);
            $table->foreign('form_item_id')->references('id')->on('formulario_items')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pessoa_formulario_respostas', function (Blueprint $table) {
            $table->dropForeign('pessoa_formulario_respostas_form_item_id_foreign');
            $table->dropColumn([
                'form_item_id'
            ]);
        });
    }
}
