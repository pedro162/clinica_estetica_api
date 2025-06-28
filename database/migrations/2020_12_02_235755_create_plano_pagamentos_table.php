<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanoPagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plano_pagamentos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('descricao');
            $table->integer('diasmedios');
            $table->integer('qtdParcelas');
            $table->enum('desdobrarDuplicataManual', ['yes', 'no'])->default('no');
            $table->enum('gerarDuplicataManual', ['yes', 'no'])->default('no');
            $table->enum('isAtiva', ['yes', 'no'])->default('no');
            $table->enum('isAberto', ['yes', 'no'])->default('no');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);

            $table->enum('active', ['yes', 'no'])->default('no');
            $table->softDeletes();

            $table->timestamps();
        });


        Schema::create('plano_forma_pgto', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('plano_pagamentos_id')->unsigned();
            $table->foreign('plano_pagamentos_id')->references('id')->on('plano_pagamentos')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('forma_pagamentos_id')->unsigned();
            $table->foreign('forma_pagamentos_id')->references('id')->on('forma_pagamentos')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);

            $table->enum('active', ['yes', 'no'])->default('no');
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
        Schema::dropIfExists('plano_pagamentos');
    }
}
