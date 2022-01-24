<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProfissionalAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('profissionals', function (Blueprint $table) {  
            $table->decimal('vr_salario', 10, 2)->default(0);
            $table->string('titulo_eleitor')->nullable()->default(null);
            $table->string('zona_eleitor')->nullable()->default(null);
            $table->string('naturalidade')->nullable()->default(null);
            $table->string('name_mae')->nullable()->default(null);
            $table->string('name_conjuge')->nullable()->default(null);
            $table->string('nr_serie_cnh')->nullable()->default(null);
            $table->string('name_banco_salario')->nullable()->default(null);
            $table->string('nr_agencia_banco_salario')->nullable()->default(null);
            $table->string('nr_conta_banco_salario')->nullable()->default(null);
            $table->enum('ponto_obrigatorio', ['yes', 'no'])->default('no');
            $table->enum('estado_civil', ['solteiro', 'casado', 'unidao_estavel', 'divorsiado', 'viuvo'])->default('solteiro');
            $table->enum('grau_instrucao', ['fundamental', 'medio', 'superior'])->default('fundamental');
            $table->enum('status', ['admitido', 'demitido'])->default('admitido');
            $table->enum('tipo_contrato', ['aprendiz', 'efetivo', 'pj'])->default('efetivo');
            $table->bigInteger('filial_id')->unsigned();
            $table->foreign('filial_id')->references('id')->on('filials')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('uf_cnh_id')->unsigned()->nullable()->default(null);
            $table->foreign('uf_cnh_id')->references('id')->on('estadoss')->onUpdate('cascade')->onDelete('cascade');
        });
            
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profissionals', function($table) {
            $table->dropColumn('vr_salario');
            $table->dropColumn('titulo_eleitor');
            $table->dropColumn('zona_eleitor');
            $table->dropColumn('naturalidade');
            $table->dropColumn('name_mae');
            $table->dropColumn('name_conjuge');
            $table->dropColumn('nr_serie_cnh');
            $table->dropColumn('name_banco_salario');
            $table->dropColumn('nr_agencia_banco_salario');
            $table->dropColumn('nr_conta_banco_salario');
            $table->dropColumn('ponto_obrigatorio');
            $table->dropColumn('estado_civil');
            $table->dropColumn('grau_instrucao');
            $table->dropColumn('status');
            $table->dropColumn('tipo_contrato');
            $table->dropColumn('filial_id');
            $table->dropColumn('uf_cnh_id');
       });
    }
}
