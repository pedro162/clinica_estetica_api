<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanoPagamentoPrazosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plano_pagamento_prazos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('plano_pagamentos_id')->unsigned();
            $table->integer('qtdDias')->unsigned()->default(0);
            $table->foreign('plano_pagamentos_id')->references('id')->on('plano_pagamentos')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('active', ['yes', 'no'])->default('no');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);
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
        Schema::dropIfExists('plano_pagamento_prazos');
    }
}
