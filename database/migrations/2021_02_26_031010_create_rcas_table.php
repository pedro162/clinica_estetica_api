<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRcasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rcas', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('filial_id')->unsigned();
            $table->foreign('filial_id')->references('id')->on('filials')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('pessoa_id')->unsigned();
            $table->foreign('pessoa_id')->references('id')->on('pessoas')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('situacao', ['ativo', 'inativo'])->default('ativo');
            $table->enum('acessaTodosRcas', ['yes', 'no'])->default('no');
           
            $table->decimal('metaPositivacao', 65, 2);
            $table->decimal('metaMargem', 65, 2);
            $table->decimal('metaFaturamento', 65, 2);
            $table->enum('active', ['yes', 'no'])->default('no');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);  
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
        Schema::dropIfExists('rcas');
    }
}
