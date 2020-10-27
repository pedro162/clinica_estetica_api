<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LogradouroPessoaTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('logradouro_pessoa', function (Blueprint $table) {
            $table->id();            
            $table->bigInteger('pessoa_id')->unsigned();
            $table->foreign('pessoa_id')->references('id')->on('pessoas')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('logradouro_id')->unsigned();
            $table->foreign('logradouro_id')->references('id')->on('logradouros')->onUpdate('cascade')->onDelete('cascade');

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
       Schema::dropIfExists('logradouro_pessoa');
    }
    
}
