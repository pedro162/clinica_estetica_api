<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisaos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('descricao');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);            
            $table->enum('active',['yes', 'no'])->default('no');
            $table->timestamps();
        });

        Schema::create('permisao_user', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_permisao_id')->unsigned();
            $table->foreign('user_permisao_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('permisao_id')->unsigned();
            $table->foreign('permisao_id')->references('id')->on('permisaos')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);            
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
        Schema::dropIfExists('permisaos');
    }
}
