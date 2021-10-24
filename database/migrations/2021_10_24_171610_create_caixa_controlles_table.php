<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaixaControllesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caixa_controlles', function (Blueprint $table) {
            $table->id();
            $table->date('dtAbertura')->nullable()->default(null);
            $table->date('dtFechamento')->nullable()->default(null);
            $table->date('dtBloqueio')->nullable()->default(null);
            $table->date('dtDesbloqueio')->nullable()->default(null);
            $table->bigInteger('pessoa_id')->unsigned();
            $table->foreign('pessoa_id')->references('id')->on('pessoas')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('pessoa_close_id')->unsigned()->nullable()->default(null);
            $table->bigInteger('pessoa_bloqueio_id')->unsigned()->nullable()->default(null);
            $table->bigInteger('pessoa_desbloqueio_id')->unsigned()->nullable()->default(null);
            $table->bigInteger('caixa_id')->unsigned();
            $table->foreign('caixa_id')->references('id')->on('caixas')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);  
            $table->enum('active',['yes', 'no'])->default('no');
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
        Schema::dropIfExists('caixa_controlles');
    }
}
