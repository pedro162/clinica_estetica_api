<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->enum('tpVencimento', ['semana', 'mes'])->default('mes');
            $table->enum('isLiberaCatraca', ['yes', 'no'])->default('yes');
            $table->date('dtVencimento');
            $table->decimal('vrAdesao', 10, 2)->default(0);
            $table->decimal('vrContrato', 10, 2)->default(0);
            $table->bigInteger('filial_id')->unsigned();
            $table->foreign('filial_id')->references('id')->on('filials')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);            
            $table->enum('status',['aberto', 'concluido'])->default('aberto');
            $table->enum('active',['yes', 'no'])->default('no');
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
        Schema::dropIfExists('contratos');
    }
}
