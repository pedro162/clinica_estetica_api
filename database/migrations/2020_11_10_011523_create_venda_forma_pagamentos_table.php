<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendaFormaPagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()//ok
    {
        Schema::create('venda_forma_pagamentos', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('venda_id')->unsigned();
            $table->foreign('venda_id')->references('id')->on('vendas')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('vrCobranca', 10, 2);

            $table->bigInteger('forma_pagamentos_id')->unsigned();
            $table->foreign('forma_pagamentos_id')->references('id')->on('forma_pagamentos')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('venda_forma_pagamentos');
    }
}
