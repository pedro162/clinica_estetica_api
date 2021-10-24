<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContaReceberItemsCaixaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conta_receber_items', function (Blueprint $table) {
            $table->bigInteger('caixa_id')->unsigned()->nullable()->default(null);  
            $table->enum('tpBaixa',['system', 'user'])->default('user');
            //$table->id();
            //$table->timestamps();
        });

        Schema::table('conta_recebers', function (Blueprint $table) {            
            $table->bigInteger('responsavel_id')->unsigned();
            $table->foreign('responsavel_id')->references('id')->on('pessoas')->onDelete('cascade')->onUpdate('cascade');    
            $table->enum('importacao_dados',['yes', 'no'])->default('no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('conta_receber_items');
    }
}
