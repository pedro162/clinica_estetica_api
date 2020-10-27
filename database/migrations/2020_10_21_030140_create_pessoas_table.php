<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePessoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_opcional')->nullable();
            $table->string('documento');
            $table->string('documento_complementar')->nullable();
            $table->string('email')->nullable();
            $table->date('nascimento_fundacao')->nullable();
            $table->enum('sexo', ['m', 'f'])->nullable();
            $table->enum('tipo', ['fisica', 'juridica'])->default('fisica');
            
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable();
            $table->foreign('user_update_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('pessoas');
    }
}
