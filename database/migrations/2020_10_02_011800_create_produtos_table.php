<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('marca_id')->unsigned();
            $table->foreign('marca_id')->references('id')->on('marcas')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('user_update_id')->unsigned()->nullable();
            $table->foreign('user_update_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('stock')->unsigned()->default(0);
            $table->integer('prazo_garantia')->unsigned()->default(0);
            $table->string('name');
            $table->string('description');
            $table->decimal('price', 10, 2);
            $table->enum('active',['yes', 'no'])->default('no');
            $table->enum('spotlight',['yes', 'no'])->default('no');
            $table->string('image');
            $table->bigInteger('sold_amout')->unsigned()->default(0);
            $table->string('cdEAN')->nullable();
            $table->enum('produto_final', ['yes', 'no'])->default('no');
            $table->date('prazo_venda')->nullable();
            $table->enum('revenda', ['yes', 'no'])->default('no');
            $table->enum('fora_de_linha', ['yes', 'no'])->default('no');
            $table->enum('importado', ['yes', 'no'])->default('no');
            $table->enum('imune_tributacao', ['yes', 'no'])->default('no');
            $table->enum('venda_fracionada', ['yes', 'no'])->default('no');
            $table->enum('controle_validade', ['yes', 'no'])->default('no');
            $table->enum('has_venda', ['yes', 'no'])->default('no');
            $table->enum('has_venda_direta', ['yes', 'no'])->default('no');
            $table->dateTime('dt_exclusao', 0)->nullable();
            $table->date('dt_validade')->nullable();
            $table->decimal('valor_ultima_compra', 10, 2)->default(0);
            $table->decimal('valor_compra_futura', 10, 2)->default(0);
            $table->decimal('valor_desconto', 10, 2)->default(0);
            $table->decimal('pct_despesas_nf', 10, 2)->default(0);
            $table->decimal('pct_frete', 10, 2)->default(0);
            $table->decimal('pct_ipi', 10, 2)->default(0);
            $table->decimal('pct_icms', 10, 2)->default(0);
            $table->decimal('pct_pis', 10, 2)->default(0);
            $table->decimal('pct_confins', 10, 2)->default(0);
            $table->decimal('volume', 10, 2)->default(0);
            $table->decimal('peso_liquido', 10, 2)->default(0);
            $table->decimal('peso_bruto', 10, 2)->default(0);
            $table->decimal('desconto_liberado', 10, 2)->default(0);

            $table->timestamps();
        });
        /*----------------PRODUTO ----------------------

            //idProduto`, `idProdutoAcabado`, //`idCategoria`, `idSubcategoria`, `cdEAN`, //`idMarca`, //`idFuncionarioCadastrado`, //`idFuncionarioUltimaAlteracao`, `idProdutoPrincipal`, //`idProdutoMaster`, `idPessoaFornecedor`, `idDepartamento`, `idSecao`, //`nmProduto`, //`dsProduto`, `nrDV`, `tpEmbalagem`, `dsLinha`, //`dtPrazoVenda`, `cdUnidadeMasterCompra`, `qtdEmbalagemCompra`, `cdUnidadeVenda`, `idUnidade`, `qtdEmbalagemVenda`, `cdUnidadeCarregamento`, //`isRevenda`, `nrFatorConversaoTributavel`, //`isForadeLinha`, //`isImportado`, `nmNaturezaProduto`, `dtUltimaAlteracaoComercial`, `dtCadastro`, //`dtExclusão`, `dtUltimaAlteração`, //`dsArquivoFoto`, //`isAtivo`, `hasSupervisao`, `qtdReposicaoEstoque`, //`vrUltimaCompra`, //`vrCompraFutura`, `pctDeconto1`, `pctDeconto2`, `pctDeconto3`, `pctDeconto4`, `pctDeconto5`, `pctDeconto6`, `pctDeconto7`, `pctDeconto8`, `pctDeconto9`, `pctDeconto10`, `vrTotalDesconto`, `pctFreteCIF`, //`pctOutrasDespesasNF`, //`pctFreteFOB`, `pctBonificMercadoria`, `pctBonificDinheiro`, `pctBonificOutras`, `isLicencaImportacao`, `pctSuframaRepasse`, //`pctIPI`, `vrPauta`, `pctIVA`, `pctAliquotaExterna`, `pctAliquotaInterna`, //`pctICMS`, `pctICMSRed`, `pctICMSAntecipado`, `pctSTGuia`, `nrPisCofinsRetido`, //`pctPis`, //`pctCofins`, `nrNCMExcecao`, `nrNCM`, `nrCEST`, `dsExcecao`, `isProdutoMiudeza`, `isConferirProdutosCheckout`, `isUtilizaClassificacaoArroz`, `tpCalculoDescarga`, `isPesoVariavel`, `tpEstoque`, `isUsaWMS`, //`vrPesoLiquido`, //`vrPesoBruto`, `vrVolume`, `vrMultiplo`, `vrMultiploCompra`, `nrQtdMetros`, `vrPesoMaster`, `vrPesoIntermediario`, `vrLastro`, `vrAltura`, `qtdTotalPalete`, `tpAlturaPalete`, `nmNormaFornecedor`, `nmModulo`, `dsRua`, `nrPredio`, `nrApartamento`, `isControleLote`, `isValidadePorLote`, `dtInicio`, `nrLoteProx`, `nmLotePrefixo`, `nrLote`, `isControladoIbama`, `hasCampanha`, `isConciliaImportacao`, `isControlaEquipamento`, `isEnviaParaVendas`, `idFilial`, //`isImuneTributacao`, `dsObservacao`, `dsPassaLivre`, `nrPrazoEntrega`, `nrPrazoMedioVenda`, `vrPrecoFixo`, `isRestricaoTransporte`, `tpComissao`, `isUsaFreteEspecial`, `pctVendedorInterno`, `pctVendedorExterno`, `pctRepresentante`, `nmClasseProduto`, `nmClasseVenda`, `isVerificaVenda`, //`isAceitaVendaFracionada`, `nrMultiplo`, `isControlaNumeroSerie`, //`nrPrazoGarantia`, `hasCestaBasica`, `isEnviaMyFrota`, `tpMercadoria`, `idFormatoPapel`, `idUnidadeMediaNF`, `nrFatorConversaoKg`, `nrGramatura`, `undProduto`, `vrUnitario`, `dsUnidadeFiscal`, `dsEmbalagemFiscal`, `qtdMultiplaVenda`, `dsUnidadeFornecedor`, `dsEmbalagemFornecedor`, `qtdEmbalagem`, `qtdConversaoVenda`, `vrMargemVariacaoEntrada`, `pctArrendondamentoCompras`, `idArmazem`, `idPessoaAutor`, `dtCriacao`, `dtAtualizacao`, `hasEtiquetagem`, `idReferencia`, `tpReferencia`, `qtdItensCaixa`, `isAceitaTabelaReferencia`, `hasSugestaoCompra`, `dsUnidadeConversaoSubcategoria`, `qtdConversaoSubcategoria`, `tpSugestaoDeCompras`, `qtdProdutoMinimoFilial`, `vrPesoPontuacao`, `hasEstoque`, `hasVendaDireta`, `dsReferencias`, `dsMarcaTemporario`, `dsPrincipioAtivo`, `cdGGREM`, `nrRegistro`, `isComercializado2016`, `dsClasseTerapeutica`, `tpProduto`, `pf0`, `pf12`, `pf17`, `pf17ALC`, `pf17_5`, `pf17_5ALC`, `pf18`, `pf18ALC`, `pf20`, `pmc0`, `pmc12`, `pmc17`, `pmc17ALC`, `pmc17_5`, `pmc17_5ALC`, `pmc18`, `pmc18ALC`, `pmc20`, `hasRestricaoHospitalar`, `hasCAP`, `hasCONFAZ87`, `dsAnaliseRecursal`, `dsConssecaoCredito`, `dsTarja`, `vrCustoEstimado`, `nFCI`, //`hasVenda`, `hasNumeroSerie`, `idProdutoExterno`, `status`, `vrDescontoLiberado`, `ICMS_orig`, `hasBloqueioEstoqueEntrada`, `hasBloqueioEstoqueDevolucao`, `hasBalanca`, //`hasControleValidade`, `qtdDiasValidade`, `idConfiguracaoEtiquetaLavagem`, `idConfiguracaoEtiquetaAlvejamento`, `idConfiguracaoEtiquetaSecagem`, `idConfiguracaoEtiquetaPassadoria`, `idConfiguracaoEtiquetaLimpeza`

            ------------------- PRODUTO EMBALAGEM -------------------
            `Produtos_Embalagens_id`, `Produtos_Subcategorias_Unidades_id`, `Produtos_idProduto`, `Produtos_Embalagens_descricao`, `idUnidade`, `idPessoaFornecedor`, `Produtos_Embalagens_qtdProduto`, `Produtos_Embalagens_isPadrao`, `Produtos_Embalagens_multiplo`, `Produtos_Embalagens_tipo`, `Produtos_Embalagens_Operacao`, `Produtos_Embalagens_EAN`, `isAtivo`, `idPessoaAutor`, `dtCriacao`, `dtAlteracao`
        */

        Schema::create('categoria_produto', function(Blueprint $table){
            $table->id();
            $table->bigInteger('produto_id')->unsigned();
            $table->bigInteger('categoria_id')->unsigned();
            $table->enum('active', ['yes', 'no'])->default('yes');
            $table->enum('tipo', ['principal', 'secundaria'])->default('principal');

            
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });

        Schema::create('ingrediente_produto', function(Blueprint $table){
            $table->id();
            $table->bigInteger('produto_id')->unsigned();
            $table->bigInteger('ingrediente_id')->unsigned();

            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ingrediente_id')->references('id')->on('ingredientes')->onDelete('cascade')->onUpdate('cascade');

            
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('user_update_id')->unsigned()->nullable();
            $table->foreign('user_update_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('active',['yes', 'no'])->default('no');
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
        Schema::dropIfExists('produtos');
    }
}
