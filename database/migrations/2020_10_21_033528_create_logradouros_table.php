<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogradourosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logradouros', function (Blueprint $table) {
            $table->id();
            $table->string('cep');
            $table->string('cidade');
            $table->string('logradouro');
            $table->string('bairro');
            $table->string('estado');
            $table->string('complemento')->nullable()->default(null);
            $table->string('numero')->nullable()->default(null);
            $table->string('bloco')->nullable()->default(null);
            $table->enum('tipo', ['casa', 'apartamento'])->default('casa');
            $table->enum('importancia', ['principal', 'secundario'])->default('principal');

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
        Schema::dropIfExists('logradouros');
    }
}
