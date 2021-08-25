<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servico_items', function (Blueprint $table) {
            $table->id();
            $table->integer('qtd');
            $table->bigInteger('servico_id')->unsigned();
            $table->foreign('servico_id')->references('id')->on('servicos')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('vrTotal', 10, 2);
            $table->decimal('vrItem', 10, 2);

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);            
            $table->enum('active',['yes', 'no'])->default('no');
            $table->softDeletes();
            $table->timestamps();
        });
    }
    
    /**
     *  `OrdensDeServicos_Servicos_id`,
        `isAtivo`,
        `idPessoaAutor`,
        `dtCriacao`,
        `dtAlteracao`,
        `OrdensDeServicos_Secoes_id`,
        `Servicos_id`,
        `OrdensDeServicos_Servicos_Descricao`,
        `OrdensDeServicos_Servicos_dsUnidade`,
        `OrdensDeServicos_Servicos_quantidade`,
        `OrdensDeServicos_Servicos_vrUnitario`,
        `OrdensDeServicos_Servicos_vrTotal`
     */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servico_items');
    }
}
