<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdemServicoCobrancasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordem_servico_cobrancas', function (Blueprint $table) {
            $table->id();       
            $table->bigInteger('ordem_servico_id')->unsigned();
            $table->foreign('ordem_servico_id')->references('id')->on('ordem_servicos')->onUpdate('cascade')->onDelete('cascade');     
            $table->bigInteger('forma_pagamento_id')->unsigned();
            $table->foreign('forma_pagamento_id')->references('id')->on('forma_pagamentos')->onUpdate('cascade')->onDelete('cascade');     
            $table->bigInteger('operador_financeiro_id')->unsigned();
            $table->foreign('operador_financeiro_id')->references('id')->on('operador_financeiros')->onUpdate('cascade')->onDelete('cascade');     
            $table->bigInteger('plano_pagamento_id')->unsigned();
            $table->foreign('plano_pagamento_id')->references('id')->on('plano_pagamentos')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('filial_id')->unsigned();
            $table->foreign('filial_id')->references('id')->on('filials')->onUpdate('cascade')->onDelete('cascade');    
            $table->string('nr_doc')->nullable()->default(null);
            $table->enum('vencimento_manual',['yes', 'no'])->default('no');
            $table->date('dt_vencimento_manual')->nullable()->default(null);
            $table->decimal('vr_cobranca', 60,6)->nullable()->default(null);
            $table->decimal('vr_acrescimo', 60,6)->nullable()->default(null);
            $table->decimal('vr_final', 60,6)->nullable()->default(null);
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);  
            $table->enum('active',['yes', 'no'])->default('yes');
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
        Schema::dropIfExists('ordem_servico_cobrancas');
    }
}
