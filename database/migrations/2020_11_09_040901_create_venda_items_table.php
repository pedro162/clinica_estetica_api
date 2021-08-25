<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendaItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venda_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('venda_id')->unsigned();
            $table->foreign('venda_id')->references('id')->on('vendas')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idReferencia');
            $table->string('tpReferencia');
            $table->integer('qtdItem')->default(0);
            $table->integer('qtdEmbalagemItem')->default(0);
            $table->decimal('vrItemBruto', 10, 2)->default(0);
            $table->decimal('vrTabela', 10, 2)->default(0);
            $table->decimal('vrDescontoItem', 10, 2)->default(0);
            $table->decimal('vrDescontoAvulso', 10, 2)->default(0);
            $table->decimal('vrPcntDescontoItem', 10, 2)->default(0);
            $table->decimal('vrItemBrutoInicio', 10, 2)->default(0);
            $table->decimal('vrItem', 10, 2)->default(0);
            $table->decimal('vrUnitarioItem', 10, 2)->default(0);
            $table->decimal('vrTotalItem', 10, 2)->default(0);
            $table->decimal('vrTotalItemBruto', 10, 2)->default(0);
            $table->decimal('vrDescontoAvulsoUnitario', 10, 2)->default(0);
            $table->decimal('vrMargem', 10, 2)->default(0);
            $table->decimal('vrMargemCMV', 10, 2)->default(0);
            $table->decimal('vrMargemBruta', 10, 2)->default(0);
            $table->decimal('vrPISCOFINSEntrada', 10, 2)->default(0);
            $table->decimal('vrPISCOFINSSaida', 10, 2)->default(0);
            $table->decimal('vrComissao', 10, 2)->default(0);
            $table->decimal('vrDescontoEmbalagemInicial', 10, 2)->default(0);
            $table->decimal('vrDescontoTotal', 10, 2)->default(0);
            $table->decimal('vrAcrescimos', 10, 2)->default(0);
            $table->integer('qtdItemDevolucao')->default(0);
            $table->integer('qtdDevolucaoAvariado')->default(0);
            $table->enum('statusDesconto', ['liberado', 'aguardando', 'recusado', 'bloqueado'])->default('bloqueado');
            $table->string('dsObservacoes')->nullable();


            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('user_update_id')->unsigned()->nullable()->default(null);
            $table->enum('active',['yes', 'no'])->default('no');
            $table->softDeletes();
            
            $table->timestamps();
        });
    }

    /*
    `idProdutoVenda`,
    `//idVenda`,
    `idProduto`,
    `idProdutoAcabado`,
    `//qtdProduto`,
    `qtdProdutoAcabado`,
    `//qtdEmbalagemProduto`,
    `vrCustoProduto`,
    `vrFrete`,
    `//vrProdutoBruto`,
    `//vrTabela`,
    `//vrDescontoProduto`,
    `//vrPcntDescontoProduto`,
    `//vrProdutoBrutoInicio`,
    `//vrProduto`,
    `//vrUnitarioProduto`,
    `//vrTotalProduto`,
    `//vrTotalProdutoBruto`,
    `vrTotalProdutoBrutoServico`,
    `Clientes_CondicoesComerciais_id`,
    `Clientes_CondicoesComerciais_tipo`,
    `isAtivo`,
    `idPessoaAutor`,
    `dtCriacao`,
    `dtAtualizacao`,
    `idFilial`,
    `vrBruto`,
    `vrDesconto`,
    `//vrDescontoAvulso`,
    `//vrDescontoAvulsoUnitario`,
    `vrCMV`,
    `vrCMVFiscal`,
    `vrCustoBruto`,
    `vrCustoLiquido`,
    `vrPrecoLiquido`,
    `//vrMargem`,
    `//vrMargemCMV`,
    `//vrMargemBruta`,
    `vrPcntMargem`,
    `//vrPISCOFINSEntrada`,
    `//vrPISCOFINSSaida`,
    `//vrICMSEntrada`,
    `//vrICMSSaida`,
    `//vrComissao`,
    `Produtos_Embalagens_id`,
    `vrDespesasFinanceiras`,
    `vrPcntDespesasFinanceiras`,
    `vrDespesasFinanceirasUnitario`,
    `//qtdProdutoDevolucao`,
    `qtdPontos`,
    `vrPesoPontuacao`,
    `qtdSaldoProdutos`,
    `//vrDescontoEmbalagemInicial`,
    `//vrAcrescimos`,
    `//statusDesconto`,
    `//dsObservacoes`,
    `nrItemOrdemDeCompra`,
    `Produtos_Series_id`,
    `idClasse`,
    `isClasse`,
    `vrTotalAcrescimosUnit`,
    `vrTotalAcrescimos`,
    `xPed`,
    `nItemPed`,
    `vrAcrescimosPrice`,
    `qtdDevolucaoAvariado`,
    `dsAmbiente`,
    `dsItem`,
    `vrUnitarioServico`,
    `idVendaFilha`,
    `//vrDescontoTotal`
    */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venda_items');
    }
}
