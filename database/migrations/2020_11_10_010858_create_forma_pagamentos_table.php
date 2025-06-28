(<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateFormaPagamentosTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() //ok
        {
            Schema::create('forma_pagamentos', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('cdCobrancaTipo');
                $table->enum('hasComissao', ['yes', 'no'])->default('no');
                $table->enum('tpPagamento', ['a vista', 'a prazo', 'cartao'])->default('a vista');
                $table->enum('hasDesdobramento', ['yes', 'no'])->default('yes');
                $table->enum('hasLimiteDeCredito', ['yes', 'no'])->default('no');
                $table->enum('hasAcertoBalcao', ['yes', 'no'])->default('no');
                $table->enum('hasAcertoCaixa', ['yes', 'no'])->default('no');
                $table->enum('hasEntrada', ['yes', 'no'])->default('no');
                $table->enum('tipo', ['cartao_credito', 'cartao_debito', 'boleto', 'dinheiro'])->default('dinheiro');
                $table->enum('hasOperadorFinanceiro', ['yes', 'no'])->default('no');
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
            Schema::dropIfExists('forma_pagamentos');
        }
    }
