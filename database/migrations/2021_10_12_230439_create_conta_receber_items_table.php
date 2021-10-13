<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContaReceberItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conta_receber_items', function (Blueprint $table) {
            $table->id();
            
            $table->string('documento')->nullable()->default(null);
            $table->date('dtPagamento')->nullable()->default(null);
            $table->date('dtBaixa')->nullable()->default(null);
            $table->string('descricao')->nullable()->default(null);
            $table->string('ds_estorno')->nullable()->default(null);
            $table->decimal('vrBruto', 10, 3)->default(0);
            $table->decimal('vrLiquido', 10, 3)->default(0);
            $table->decimal('vrDevolvido', 10, 3)->default(0);
            $table->decimal('vrPago', 10, 3)->default(0);
            $table->decimal('vrTaxa', 10, 3)->default(0);
            $table->decimal('vrDesconto', 10, 3)->default(0);
            $table->decimal('vrJuros', 10, 3)->default(0);
            $table->enum('status', ['pago', 'devolvido', 'estornado']);
            $table->bigInteger('forma_pagamentos_id')->unsigned();
            $table->foreign('forma_pagamentos_id')->references('id')->on('forma_pagamentos')->onUpdate('cascade')->onDelete('cascade');
            
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
        Schema::dropIfExists('conta_receber_items');
    }
}
