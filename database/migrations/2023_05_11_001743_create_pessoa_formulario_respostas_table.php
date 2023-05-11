<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePessoaFormularioRespostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoa_formulario_respostas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pess_form_id')->unsigned();
            $table->foreign('pess_form_id')->references('id')->on('pessoa_formularios')->onUpdate('cascade')->onDelete('cascade');
           
            $table->string("pergunta")->nullable()->default(null);
            $table->string("resposta")->nullable()->default(null);
            $table->string("observacao")->nullable()->default(null);
            $table->text("nr_linha")->nullable()->default(null);
            $table->text("nr_coluna")->nullable()->default(null);
            $table->enum('alerta_resposta',['yes', 'no'])->default('yes');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);  
            $table->enum('active',['yes', 'no'])->default('yes');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pessoa_formulario_respostas');
    }
}
