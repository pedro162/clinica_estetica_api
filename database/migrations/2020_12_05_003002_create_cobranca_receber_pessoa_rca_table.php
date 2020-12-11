<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCobrancaReceberPessoaRcaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cobranca_recebers', function (Blueprint $table) {
            $table->bigInteger('pessoa_rca_id')->unsigned();
            $table->foreign('pessoa_rca_id')->references('id')->on('pessoas')->onUpdate('cascade')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('cobranca_receber_pessoa_rca');
    }
}
