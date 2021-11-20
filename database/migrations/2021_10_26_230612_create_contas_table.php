<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contas', function (Blueprint $table) {
            $table->id();
            $table->string('name');            
            $table->bigInteger('pessoa_id')->unsigned();//A pessoa que representa essa conta
            $table->foreign('pessoa_id')->references('id')->on('pessoas')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('conta_categorias_id')->unsigned();
            $table->foreign('conta_categorias_id')->references('id')->on('conta_categorias')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);  
            $table->enum('typo',['receber', 'pagar','outros'])->default('receber');
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
        Schema::dropIfExists('contas');
    }
}
