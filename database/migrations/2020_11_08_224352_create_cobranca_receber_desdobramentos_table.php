<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCobrancaReceberDesdobramentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cobranca_receber_desdobramentos', function (Blueprint $table) {
            $table->id();
            $table->decimal('vrDesdobramento', 10, 2);
            $table->integer('qtdParcelas')->default(1);
            $table->decimal('vrJuros', 10,2)->default(0);
            $table->decimal('vrMultas', 10,2)->default(0);
            $table->decimal('vrJurosProrrogacao', 10,2)->default(0);
            $table->decimal('vrAliquotaJuros', 10,2)->default(0);
            $table->integer('qtdDias')->default(0);
            $table->decimal('vrInicialDesdobramento', 10, 2)->default(0);
            $table->decimal('vrFinalDesdobramento', 10, 2)->default(0);
            $table->decimal('vrDiferencaDesdobramento', 10, 2)->default(0);
            $table->decimal('vrAcrescimos', 10, 2)->default(0);
            $table->decimal('vrDescontos', 10, 2)->default(0);
            $table->decimal('vrJurosDispensados', 10, 2)->default(0);
            $table->decimal('vrMultaDispensada', 10, 2)->default(0);
            $table->decimal('vrEntrada', 10, 2)->default(0);
            $table->integer('idReferencia');
            $table->string('tpReferencia');
            $table->enum('isRenegociacao', ['yes', 'no'])->default('no');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('user_update_id')->unsigned()->nullable();
            $table->foreign('user_update_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            
            $table->enum('active',['yes', 'no'])->default('no');
            $table->timestamps();
        });
    }

    /*
    `idDesdobramentoReceber`,
    `dtDesdobramentoReceber`,
    `idFuncionario`,
    `tpParceiro`,
    `idPessoa`,
    `idFilial`,
    `//vrDesdobramento`,
    `//qtdParcelas`,
    `//vrJuros`,
    `//vrMultas`,
    `//vrJurosProrrogacao`,
    `//vrAliquotaJuros`,
    `//qtdDias`,
    `//vrInicialDesdobramento`,
    `//vrFinalDesdobramento`,
    `//vrDiferencaDesdobramento`,
    `//vrAcrescimos`,
    `isAtivo`,
    `idPessoaAutor`,
    `dtCriacao`,
    `dtAtualizacao`,
    `vrDescontos`,
    `//idReferencia`,
    `//tpReferencia`,
    `//vrJurosDispensados`,
    `//vrMultaDispensada`,
    `//vrEntrada`,
    `idVenda`,
    `tpRecibo`,
    `//isRenegociacao`
    */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cobranca_receber_desdobramentos');
    }
}
