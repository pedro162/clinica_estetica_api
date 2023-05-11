<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePessoaFormulariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoa_formularios', function (Blueprint $table) {
            $table->id();
            $table->string("observacao")->nullable()->default(null);
            $table->string("caminho_ficha")->nullable()->default(null);
            $table->bigInteger('pessoa_id')->unsigned();
            $table->foreign('pessoa_id')->references('id')->on('pessoas')->onUpdate('cascade')->onDelete('cascade');
            
            $table->bigInteger('profissional_id')->unsigned();
            $table->foreign('profissional_id')->references('id')->on('profissionals')->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('formulario_id')->unsigned();
            $table->foreign('formulario_id')->references('id')->on('formularios')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);  
            $table->enum('active',['yes', 'no'])->default('yes');
            $table->enum('status',['aberto', 'finalizado', 'cancelado'])->default('aberto');
            $table->enum('sigiloso',['yes', 'no'])->default('no');

            $table->dateTime('dt_abertura')->nullable()->default(null);
            $table->dateTime('dt_finalizacao')->nullable()->default(null);
            $table->dateTime('dt_cancelamento')->nullable()->default(null);
            
            $table->bigInteger('pess_abert_id')->unsigned()->nullable()->default(null);
            $table->foreign('pess_abert_id')->references('id')->on('pessoas')->onUpdate('cascade')->onDelete('cascade');
            
            $table->bigInteger('pess_cancel_id')->unsigned()->nullable()->default(null);
            $table->foreign('pess_cancel_id')->references('id')->on('pessoas')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('pess_finali_id')->unsigned()->nullable()->default(null);
            $table->foreign('pess_finali_id')->references('id')->on('pessoas')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('pessoa_formularios');
    }
}
