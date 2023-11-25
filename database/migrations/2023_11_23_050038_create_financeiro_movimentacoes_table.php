<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceiroMovimentacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financeiro_movimentacoes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('referencia_id')->unsigned()->nullable()->default(null);
            $table->string('referencia')->nullable()->default(null);
            $table->string('historico');
            $table->bigInteger('caixa_id')->unsigned();
            $table->foreign('caixa_id')->references('id')->on('caixas')->onUpdate('cascade')->onDelete('cascade');  
            $table->decimal('vr_saldo_anterior', 60,6)->nullable()->default(null);
            $table->decimal('vr_movimentacao', 60,6)->nullable()->default(null);
            $table->decimal('vr_saldo', 60,6)->nullable()->default(null);
            $table->enum('conciliado',['yes', 'no'])->default('no');
            $table->enum('estornado',['yes', 'no'])->default('no');
            $table->string('hash_operacao')->nullable()->default(null);
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
        Schema::dropIfExists('financeiro_movimentacoes');
    }
}
