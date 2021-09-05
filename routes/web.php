<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',['as' =>'site.home', 'uses'=>'Site\SiteController@index']);
Route::get('/prato/index',['as' =>'prato.index', 'uses'=>'Site\PratoController@index']);

Route::get('/admin/login', ['as'=>'admin.login', function(){
	return view('admin.login.index');
}])->middleware('tenant');
Route::post('/admin/login', ['as' => 'admin.login', 'uses' => 'UsuarioController@login'])->middleware('tenant');;

Route::group(['middleware' => ['tenant','auth']], function(){

	Route::get('/produto/index/{id_assistente?}', ['as'=>'produto.index', 'uses'=>'Admin\ProdutoController@index']);
	Route::post('/produto/index/post', ['as'=>'produto.index.post', 'uses'=>'Admin\ProdutoController@index']);
	Route::get('/produto/create/{id_assistente?}', ['as'=>'produto.create', 'uses'=>'Admin\ProdutoController@create']);
	Route::post('/produto/create/{id_assistente?}', ['as'=>'produto.create', 'uses'=>'Admin\ProdutoController@create']);
	Route::post('/produto/store/{id_assistente?}', ['as'=>'produto.store', 'uses'=>'Admin\ProdutoController@store']);
	Route::get('/produto/edit/{id}/{id_assistente?}', ['as'=>'produto.edit', 'uses'=>'Admin\ProdutoController@edit']);
	Route::post('/produto/edit/{id}/{id_assistente?}', ['as'=>'produto.edit', 'uses'=>'Admin\ProdutoController@edit']);
	Route::put('/produto/update/{id}/{id_assistente?}', ['as'=>'produto.update', 'uses'=>'Admin\ProdutoController@update']);
	Route::get('/produto/show/{id}/{id_assistente?}', ['as'=>'produto.show', 'uses'=>'Admin\ProdutoController@show']);
	Route::post('/produto/show/{id}/{id_assistente?}', ['as'=>'produto.show', 'uses'=>'Admin\ProdutoController@show']);
	Route::get('/produto/info/{id}/{id_assistente?}', ['as'=>'produto.info', 'uses'=>'Admin\ProdutoController@info']);
	Route::post('/produto/info/{id}/{id_assistente?}', ['as'=>'produto.info', 'uses'=>'Admin\ProdutoController@info']);
	Route::get('/produto/head/{id_assistente?}', ['as'=>'produto.head', 'uses'=>'Admin\ProdutoController@head']);
	Route::get('/produto/destroy/{id}/{id_assistente?}', ['as'=>'produto.destroy', 'uses'=>'Admin\ProdutoController@destroy']);
	Route::get('/produto/adiconar/ingrediente/{id}/{id_assistente?}', ['as'=>'produto.adicionar.ingrediente', 'uses'=>'Admin\ProdutoController@adicionarIngrediente']);
	Route::post('/produto/ingrediente/salvar/{id}/{id_assistente?}', ['as'=>'produto.ingrediente.salvar', 'uses'=>'Admin\ProdutoController@ingredienteSalvar']);
	Route::post('/produto/index/json/{id_assistente?}', ['as'=>'produto.index.json', 'uses'=>'Admin\ProdutoController@indexJson']);


	Route::get('/marca/index/{id_assistente?}', ['as'=>'marca.index', 'uses'=>'Admin\MarcaController@index']);
	Route::post('/marca/index/{id_assistente?}', ['as'=>'marca.index', 'uses'=>'Admin\MarcaController@index']);
	Route::get('/marca/create/{id_assistente?}', ['as'=>'marca.create', 'uses'=>'Admin\MarcaController@create']);
	Route::post('/marca/create/{id_assistente?}', ['as'=>'marca.create', 'uses'=>'Admin\MarcaController@create']);
	Route::post('/marca/store', ['as'=>'marca.store', 'uses'=>'Admin\MarcaController@store']);
	Route::get('/marca/edit/{id}/{id_assistente?}', ['as'=>'marca.edit', 'uses'=>'Admin\MarcaController@edit']);
	Route::post('/marca/edit/{id}/{id_assistente?}', ['as'=>'marca.edit', 'uses'=>'Admin\MarcaController@edit']);
	Route::put('/marca/update/{id}/{id_assistente?}', ['as'=>'marca.update', 'uses'=>'Admin\MarcaController@update']);
	Route::get('/marca/show/{id}/{id_assistente?}', ['as'=>'marca.show', 'uses'=>'Admin\MarcaController@show']);
	Route::get('/marca/info/{id}/{id_assistente?}', ['as'=>'marca.info', 'uses'=>'Admin\MarcaController@info']);
	Route::post('/marca/info/{id}/{id_assistente?}', ['as'=>'marca.info', 'uses'=>'Admin\MarcaController@info']);
	Route::get('/marca/head/{id_assistente?}', ['as'=>'marca.head', 'uses'=>'Admin\MarcaController@head']);
	Route::get('/marca/destroy/{id}/{id_assistente?}', ['as'=>'marca.destroy', 'uses'=>'Admin\MarcaController@destroy']);


	Route::get('/categoria/index/{id_assistente?}', ['as'=>'categoria.index', 'uses'=>'Admin\CategoriaController@index']);
	Route::post('/categoria/index/{id_assistente?}', ['as'=>'categoria.index', 'uses'=>'Admin\CategoriaController@index']);
	Route::get('/categoria/create/{id_assistente?}', ['as'=>'categoria.create', 'uses'=>'Admin\CategoriaController@create']);
	Route::post('/categoria/create/{id_assistente?}', ['as'=>'categoria.create', 'uses'=>'Admin\CategoriaController@create']);
	Route::post('/categoria/store', ['as'=>'categoria.store', 'uses'=>'Admin\CategoriaController@store']);
	Route::get('/categoria/edit/{id}/{id_assistente?}', ['as'=>'categoria.edit', 'uses'=>'Admin\CategoriaController@edit']);
	Route::post('/categoria/edit/{id}/{id_assistente?}', ['as'=>'categoria.edit', 'uses'=>'Admin\CategoriaController@edit']);
	Route::put('/categoria/update/{id}/{id_assistente?}', ['as'=>'categoria.update', 'uses'=>'Admin\CategoriaController@update']);
	Route::get('/categoria/show/id/{id_assistente?}', ['as'=>'categoria.show', 'uses'=>'Admin\CategoriaController@show']);
	Route::post('/categoria/show/id/{id_assistente?}', ['as'=>'categoria.show', 'uses'=>'Admin\CategoriaController@show']);
	Route::get('/categoria/info/{id}/{id_assistente?}', ['as'=>'categoria.info', 'uses'=>'Admin\CategoriaController@info']);
	Route::post('/categoria/info/{id}/{id_assistente?}', ['as'=>'categoria.info', 'uses'=>'Admin\CategoriaController@info']);
	Route::get('/categoria/head/{id_assistente?}', ['as'=>'categoria.head', 'uses'=>'Admin\CategoriaController@head']);
	Route::get('/categoria/destroy/{id}', ['as'=>'categoria.destroy', 'uses'=>'Admin\CategoriaController@destroy']);

	Route::get('/pessoa/index/{id_assistente?}', ['as'=>'pessoa.index', 'uses'=>'Admin\PessoaController@index']);
	Route::get('/pessoa/create/{id_assistente?}', ['as'=>'pessoa.create', 'uses'=>'Admin\PessoaController@create']);
	Route::post('/pessoa/store/{id_assistente?}', ['as'=>'pessoa.store', 'uses'=>'Admin\PessoaController@store']);
	Route::get('/pessoa/edit/{id}/{id_assistente?}', ['as'=>'pessoa.edit', 'uses'=>'Admin\PessoaController@edit']);
	Route::put('/pessoa/update/{id}/{id_assistente?}', ['as'=>'pessoa.update', 'uses'=>'Admin\PessoaController@update']);
	Route::get('/pessoa/show/{id}/{id_assistente?}', ['as'=>'pessoa.show', 'uses'=>'Admin\PessoaController@show']);
	Route::get('/pessoa/info/{id}/{id_assistente?}', ['as'=>'pessoa.info', 'uses'=>'Admin\PessoaController@info']);
	Route::get('/pessoa/head/{id_assistente?}', ['as'=>'pessoa.head', 'uses'=>'Admin\PessoaController@head']);
	Route::get('/pessoa/destroy/{id}/{id_assistente?}', ['as'=>'pessoa.destroy', 'uses'=>'Admin\PessoaController@destroy']);
	Route::get('/pessoa/valida/cpf/{cpf}/{id_assistente?}', ['as'=>'pessoa.valida.cpf', 'uses'=>'Admin\PessoaController@validarCpf']);
	Route::get('/pessoa/plano/adicionar/{id}/{id_assistente?}', ['as'=>'pessoa.plano.adicionar', 'uses'=>'Admin\PessoaController@adicionarPlano']);
	
	Route::get('/logradouro/index/{id_assistente?}', ['as'=>'logradouro.index', 'uses'=>'Admin\LogradouroController@index']);
	Route::get('/logradouro/create/{id}/{id_assistente?}', ['as'=>'logradouro.create', 'uses'=>'Admin\LogradouroController@create']);
	Route::post('/logradouro/store/{idPessoa}/{id_assistente?}', ['as'=>'logradouro.store', 'uses'=>'Admin\LogradouroController@store']);
	Route::get('/logradouro/edit/{id}/{idPessoa}/{id_assistente?}', ['as'=>'logradouro.edit', 'uses'=>'Admin\LogradouroController@edit']);
	Route::put('/logradouro/update/{id}/{idPessoa}/{id_assistente?}', ['as'=>'logradouro.update', 'uses'=>'Admin\LogradouroController@update']);
	Route::get('/logradouro/show/{id}/{idPessoa}/{id_assistente?}', ['as'=>'logradouro.show', 'uses'=>'Admin\LogradouroController@show']);
	Route::get('/logradouro/info/{id}/{idPessoa}/{id_assistente?}', ['as'=>'logradouro.info', 'uses'=>'Admin\LogradouroController@info']);
	Route::get('/logradouro/head/{id_assistente?}', ['as'=>'logradouro.head', 'uses'=>'Admin\LogradouroController@head']);
	Route::get('/logradouro/destroy/{id}/{idPessoa}/{id_assistente?}', ['as'=>'logradouro.destroy', 'uses'=>'Admin\LogradouroController@destroy']);

	Route::get('/logradouro/load/api', ['as'=>'logradouro.load.api', 'uses'=>'Admin\LogradouroController@loadLogradouroApi']);

	Route::get('/cobranca/receber/index/{id_assistente?}', ['as'=>'cobranca.receber.index', 'uses'=>'Admin\CobrancaReceberController@index']);
	Route::post('/cobranca/receber/index/{id_assistente?}', ['as'=>'cobranca.receber.index', 'uses'=>'Admin\CobrancaReceberController@index']);
	Route::get('/cobranca/receber/index/json/{id_assistente?}', ['as'=>'cobranca.receber.index.json', 'uses'=>'Admin\CobrancaReceberController@indexJson']);
	Route::get('/cobranca/receber/create/{id_assistente?}', ['as'=>'cobranca.receber.create', 'uses'=>'Admin\CobrancaReceberController@create']);
	Route::post('/cobranca/receber/store/{id_assistente?}', ['as'=>'cobranca.receber.store', 'uses'=>'Admin\CobrancaReceberController@store']);
	Route::get('/cobranca/receber/edit/{idReferencia}/{tpReferencia}/{id_assistente?}', ['as'=>'cobranca.receber.edit', 'uses'=>'Admin\CobrancaReceberController@edit']);
	Route::put('/cobranca/receber/update/{id}/{id_assistente?}', ['as'=>'cobranca.receber.update', 'uses'=>'Admin\CobrancaReceberController@update']);
	Route::get('/cobranca/receber/show/{idReferencia}/{tpReferencia}/{id_assistente?}', ['as'=>'cobranca.receber.show', 'uses'=>'Admin\CobrancaReceberController@show']);
	Route::get('/cobranca/receber/info/{id}/{id_assistente?}', ['as'=>'cobranca.receber.info', 'uses'=>'Admin\CobrancaReceberController@info']);
	Route::get('/cobranca/receber/head/{id_assistente?}', ['as'=>'cobranca.receber.head', 'uses'=>'Admin\CobrancaReceberController@head']);
	Route::get('/cobranca/receber/destroy/{id}/{id_assistente?}', ['as'=>'cobranca.receber.destroy', 'uses'=>'Admin\CobrancaReceberController@destroy']);
	Route::get('/cobranca/receber/mensalidade/{id}/{id_assistente?}', ['as'=>'cobranca.receber.mensalidade', 'uses'=>'Admin\CobrancaReceberController@mensalidade']);
	Route::post('/cobranca/receber/mensalidade/store/{id}/{id_assistente?}', ['as'=>'cobranca.receber.mensalidade.store', 'uses'=>'Admin\CobrancaReceberController@saveMensalidade']);

	Route::get('/cobranca/receber/baixar/{idReferencia}/{tpReferencia}/{id_assistente?}', ['as'=>'cobranca.receber.baixar', 'uses'=>'Admin\CobrancaReceberController@baixar']);
	Route::get('/cobranca/receber/baixar/credito/cliente/{idReferencia}/{tpReferencia}/{id_assistente?}', ['as'=>'cobranca.receber.baixar.credito.cliente', 'uses'=>'Admin\CobrancaReceberController@baixarCreCliente']);
	Route::get('/cobranca/receber/extornar/{idReferencia}/{tpReferencia}/{id_assistente?}', ['as'=>'cobranca.receber.extornar', 'uses'=>'Admin\CobrancaReceberController@extornar']);
	Route::get('/cobranca/receber/acertar/{idReferencia}/{tpReferencia?}/{id_assistente?}', ['as'=>'cobranca.receber.acertar', 'uses'=>'Admin\CobrancaReceberController@acertar']);
	Route::post('/cobranca/receber/acertar/save/{idReferencia}/{id_assistente?}', ['as'=>'cobranca.receber.acertar.save', 'uses'=>'Admin\CobrancaReceberController@saveAcertar']);
	Route::get('/cobranca/receber/negativar/{idReferencia}/{tpReferencia}/{id_assistente?}', ['as'=>'cobranca.receber.negativar', 'uses'=>'Admin\CobrancaReceberController@negativar']);
	Route::get('/cobranca/receber/conciliar/cni{idReferencia}/{tpReferencia}/{id_assistente?}', ['as'=>'cobranca.receber.conciliar.cni', 'uses'=>'Admin\CobrancaReceberController@conciliarCni']);
	Route::get('/cobranca/receber/recibo/{idReferencia}/{tpReferencia}/{id_assistente?}', ['as'=>'cobranca.receber.recibo', 'uses'=>'Admin\CobrancaReceberController@recibo']);
	Route::get('/cobranca/receber/anexar/documento/{idReferencia}/{tpReferencia}/{id_assistente?}', ['as'=>'cobranca.receber.baixar.anexar
documento', 'uses'=>'Admin\CobrancaReceberController@anexarDocumento']);
	Route::get('/cobranca/receber/ver/desdobramento/{idReferencia}/{tpReferencia}/{id_assistente?}', ['as'=>'cobranca.receber.ver.desdobramento', 'uses'=>'Admin\CobrancaReceberController@verDesdobramento']);
	Route::get('/cobranca/receber/ficha/debitos/{idReferencia}/{tpReferencia}/{id_assistente?}', ['as'=>'cobranca.receber.ficha.debitos', 'uses'=>'Admin\CobrancaReceberController@fichaDebitos']);

	Route::post('/cobranca/receber/simular/desdobramento/{idReferencia}/{id_assistente?}', ['as'=>'cobranca.receber.simular.desdobramento', 'uses'=>'Admin\CobrancaReceberController@simularAcertar']);
	

	Route::get('/contrato/index/{id_assistente?}', ['as'=>'contrato.index', 'uses'=>'Admin\ContratoController@index']);
	Route::get('/contrato/create/{id}/{id_assistente?}', ['as'=>'contrato.create', 'uses'=>'Admin\ContratoController@create']);
	Route::post('/contrato/store/{idPessoa}/{id_assistente?}', ['as'=>'contrato.store', 'uses'=>'Admin\ContratoController@store']);
	Route::get('/contrato/edit/{id}/{idPessoa}/{id_assistente?}', ['as'=>'contrato.edit', 'uses'=>'Admin\ContratoController@edit']);
	Route::put('/contrato/update/{id}/{idPessoa}/{id_assistente?}', ['as'=>'contrato.update', 'uses'=>'Admin\ContratoController@update']);
	Route::get('/contrato/show/{id}/{idPessoa}/{id_assistente?}', ['as'=>'contrato.show', 'uses'=>'Admin\ContratoController@show']);
	Route::get('/contrato/info/{id}/{idPessoa}/{id_assistente?}', ['as'=>'contrato.info', 'uses'=>'Admin\ContratoController@info']);
	Route::get('/contrato/head/{id_assistente?}', ['as'=>'contrato.head', 'uses'=>'Admin\ContratoController@head']);
	Route::get('/contrato/destroy/{id}/{idPessoa}/{id_assistente?}', ['as'=>'contrato.destroy', 'uses'=>'Admin\ContratoController@destroy']);


	Route::get('/plano_pagamento/index/{id_assistente?}', ['as'=>'plano_pagamento.index', 'uses'=>'Admin\PlanoPagamentoController@index']);
	Route::get('/plano_pagamento/create/{id_assistente?}', ['as'=>'plano_pagamento.create', 'uses'=>'Admin\PlanoPagamentoController@create']);
	Route::post('/plano_pagamento/store/{id_assistente?}', ['as'=>'plano_pagamento.store', 'uses'=>'Admin\PlanoPagamentoController@store']);
	Route::get('/plano_pagamento/edit/{id}/{id_assistente?}', ['as'=>'plano_pagamento.edit', 'uses'=>'Admin\PlanoPagamentoController@edit']);
	Route::put('/plano_pagamento/update/{id}/{id_assistente?}', ['as'=>'plano_pagamento.update', 'uses'=>'Admin\PlanoPagamentoController@update']);
	Route::get('/plano_pagamento/show/{id}/{id_assistente?}', ['as'=>'plano_pagamento.show', 'uses'=>'Admin\PlanoPagamentoController@show']);
	Route::get('/plano_pagamento/info/{id}/{id_assistente?}', ['as'=>'plano_pagamento.info', 'uses'=>'Admin\PlanoPagamentoController@info']);
	Route::get('/plano_pagamento/head/{id_assistente?}', ['as'=>'plano_pagamento.head', 'uses'=>'Admin\PlanoPagamentoController@head']);
	Route::get('/plano_pagamento/destroy/{id}/{id_assistente?}', ['as'=>'plano_pagamento.destroy', 'uses'=>'Admin\PlanoPagamentoController@destroy']);


	Route::get('/forma_pagamento/index/{id_assistente?}', ['as'=>'forma_pagamento.index', 'uses'=>'Admin\FormaPagamentoController@index']);
	Route::get('/forma_pagamento/create/{id_assistente?}', ['as'=>'forma_pagamento.create', 'uses'=>'Admin\FormaPagamentoController@create']);
	Route::post('/forma_pagamento/store/{id_assistente?}', ['as'=>'forma_pagamento.store', 'uses'=>'Admin\FormaPagamentoController@store']);
	Route::get('/forma_pagamento/edit/{id}/{id_assistente?}', ['as'=>'forma_pagamento.edit', 'uses'=>'Admin\FormaPagamentoController@edit']);
	Route::put('/forma_pagamento/update/{id}/{id_assistente?}', ['as'=>'forma_pagamento.update', 'uses'=>'Admin\FormaPagamentoController@update']);
	Route::get('/forma_pagamento/show/{id}/{id_assistente?}', ['as'=>'forma_pagamento.show', 'uses'=>'Admin\FormaPagamentoController@show']);
	Route::get('/forma_pagamento/info/{id}/{id_assistente?}', ['as'=>'forma_pagamento.info', 'uses'=>'Admin\FormaPagamentoController@info']);
	Route::get('/forma_pagamento/head/{id_assistente?}', ['as'=>'forma_pagamento.head', 'uses'=>'Admin\FormaPagamentoController@head']);
	Route::get('/forma_pagamento/destroy/{id}/{id_assistente?}', ['as'=>'forma_pagamento.destroy', 'uses'=>'Admin\FormaPagamentoController@destroy']);

	Route::post('/forma_pagamento/plano/pagamento/json/{id_assistente?}', ['as'=>'forma_pagamento.plano.pagamento.json', 'uses'=>'Admin\FormaPagamentoController@planoPagamentoJson']);
	Route::post('/forma_pagamento/operador/financeiro/json/{id_assistente?}', ['as'=>'forma_pagamento.operador.financeiro.json', 'uses'=>'Admin\FormaPagamentoController@operadorJson']);

	
	Route::get('/nfe/index/{id_assistente?}', ['as'=>'nfe.index', 'uses'=>'Admin\NfeController@index']);
	Route::get('/nfe/create/{id_assistente?}', ['as'=>'nfe.create', 'uses'=>'Admin\NfeController@create']);
	Route::post('/nfe/store/{id_assistente?}', ['as'=>'nfe.store', 'uses'=>'Admin\NfeController@store']);
	Route::get('/nfe/edit/{id}/{id_assistente?}', ['as'=>'nfe.edit', 'uses'=>'Admin\NfeController@edit']);
	Route::put('/nfe/update/{id}/{id_assistente?}', ['as'=>'nfe.update', 'uses'=>'Admin\NfeController@update']);
	Route::get('/nfe/show/{id}/{id_assistente?}', ['as'=>'nfe.show', 'uses'=>'Admin\NfeController@show']);
	Route::get('/nfe/info/{id}/{id_assistente?}', ['as'=>'nfe.info', 'uses'=>'Admin\NfeController@info']);
	Route::get('/nfe/montagemxml/{id_assistente?}', ['as'=>'nfe.index', 'uses'=>'Admin\NfeController@montagemXml']);
	
	Route::get('/ncm/index/{id_assistente?}', ['as'=>'ncm.index', 'uses'=>'Admin\NcmController@index']);
	Route::post('/ncm/index/{id_assistente?}', ['as'=>'ncm.index', 'uses'=>'Admin\NcmController@index']);
	Route::get('/ncm/create/{id_assistente?}', ['as'=>'ncm.create', 'uses'=>'Admin\NcmController@create']);
	Route::post('/ncm/create/{id_assistente?}', ['as'=>'ncm.create', 'uses'=>'Admin\NcmController@create']);
	Route::post('/ncm/store/{id_assistente?}', ['as'=>'ncm.store', 'uses'=>'Admin\NcmController@store']);
	Route::get('/ncm/edit/{id}/{id_assistente?}', ['as'=>'ncm.edit', 'uses'=>'Admin\NcmController@edit']);
	Route::post('/ncm/edit/{id}/{id_assistente?}', ['as'=>'ncm.edit', 'uses'=>'Admin\NcmController@edit']);
	Route::put('/ncm/update/{id}/{id_assistente?}', ['as'=>'ncm.update', 'uses'=>'Admin\NcmController@update']);
	Route::get('/ncm/show/{id}/{id_assistente?}', ['as'=>'ncm.show', 'uses'=>'Admin\NcmController@show']);
	Route::post('/ncm/show/{id}/{id_assistente?}', ['as'=>'ncm.show', 'uses'=>'Admin\NcmController@show']);
	Route::get('/ncm/info/{id}/{id_assistente?}', ['as'=>'ncm.info', 'uses'=>'Admin\NcmController@info']);
	Route::post('/ncm/info/{id}/{id_assistente?}', ['as'=>'ncm.info', 'uses'=>'Admin\NcmController@info']);
	Route::get('/ncm/head/{id_assistente?}', ['as'=>'ncm.head', 'uses'=>'Admin\NcmController@head']);
	Route::get('/ncm/tributacao/tributar/{id}/{id_assistente?}', ['as'=>'ncm.tributacao.tributar', 'uses'=>'Admin\NcmController@tributar']);
	Route::post('/ncm/tributacao/tributar/{id}/{id_assistente?}', ['as'=>'ncm.tributacao.tributar', 'uses'=>'Admin\NcmController@tributar']);
	Route::get('/ncm/destroy/{id}/{id_assistente?}', ['as'=>'ncm.destroy', 'uses'=>'Admin\NcmController@destroy']);
	Route::post('/ncm/destroy/{id}/{id_assistente?}', ['as'=>'ncm.destroy', 'uses'=>'Admin\NcmController@destroy']);

	Route::get('/pis/cofins/index/{id_assistente?}', ['as'=>'pis.cofins.index', 'uses'=>'Admin\PisCofinsController@index']);
	Route::post('/pis/cofins/index/{id_assistente?}', ['as'=>'pis.cofins.index', 'uses'=>'Admin\PisCofinsController@index']);
	Route::get('/pis/cofins/pis/create/{id_assistente?}', ['as'=>'pis.cofins.pis.create', 'uses'=>'Admin\PisCofinsController@createPis']);
	Route::post('/pis/cofins/pis/create/{id_assistente?}', ['as'=>'pis.cofins.pis.create', 'uses'=>'Admin\PisCofinsController@createPis']);
	Route::get('/pis/cofins/pis/st/create/{id_assistente?}', ['as'=>'pis.cofins.pis.st.create', 'uses'=>'Admin\PisCofinsController@createPisSt']);
	Route::post('/pis/cofins/pis/st/create/{id_assistente?}', ['as'=>'pis.cofins.pis.st.create', 'uses'=>'Admin\PisCofinsController@createPisSt']);
	Route::get('/pis/cofins/cofins/create/{id_assistente?}', ['as'=>'pis.cofins.cofins.create', 'uses'=>'Admin\PisCofinsController@createCofins']);
	Route::post('/pis/cofins/cofins/create/{id_assistente?}', ['as'=>'pis.cofins.cofins.create', 'uses'=>'Admin\PisCofinsController@createCofins']);
	Route::get('/pis/cofins/cofins/st/create/{id_assistente?}', ['as'=>'pis.cofins.cofins.st.create', 'uses'=>'Admin\PisCofinsController@createCofinsSt']);
	Route::post('/pis/cofins/cofins/st/create/{id_assistente?}', ['as'=>'pis.cofins.cofins.st.create', 'uses'=>'Admin\PisCofinsController@createCofinsSt']);
	Route::post('/pis/cofins/store/{id_assistente?}', ['as'=>'pis.cofins.store', 'uses'=>'Admin\PisCofinsController@store']);
	Route::get('/pis/cofins/edit/{id}/{id_assistente?}', ['as'=>'pis.cofins.edit', 'uses'=>'Admin\PisCofinsController@edit']);
	Route::post('/pis/cofins/edit/{id}/{id_assistente?}', ['as'=>'pis.cofins.edit', 'uses'=>'Admin\PisCofinsController@edit']);
	Route::put('/pis/cofins/update/{id}/{id_assistente?}', ['as'=>'pis.cofins.update', 'uses'=>'Admin\PisCofinsController@update']);
	Route::get('/pis/cofins/show/{id}/{id_assistente?}', ['as'=>'pis.cofins.show', 'uses'=>'Admin\PisCofinsController@show']);
	Route::post('/pis/cofins/show/{id}/{id_assistente?}', ['as'=>'pis.cofins.show', 'uses'=>'Admin\PisCofinsController@show']);
	Route::get('/pis/cofins/info/{id}/{id_assistente?}', ['as'=>'pis.cofins.info', 'uses'=>'Admin\PisCofinsController@info']);
	Route::post('/pis/cofins/info/{id}/{id_assistente?}', ['as'=>'pis.cofins.info', 'uses'=>'Admin\PisCofinsController@info']);
	Route::get('/pis/cofins/head/{id_assistente?}', ['as'=>'pis.cofins.head', 'uses'=>'Admin\PisCofinsController@head']);
	Route::post('/pis/cofins/head/{id_assistente?}', ['as'=>'pis.cofins.head', 'uses'=>'Admin\PisCofinsController@head']);
	Route::get('/pis/cofins/destroy/{id}/{id_assistente?}', ['as'=>'pis.cofins.destroy', 'uses'=>'Admin\PisCofinsController@destroy']);
	Route::post('/pis/cofins/destroy/{id}/{id_assistente?}', ['as'=>'pis.cofins.destroy', 'uses'=>'Admin\PisCofinsController@destroy']);
	
	Route::get('/ipi/index/{id_assistente?}', ['as'=>'ipi.index', 'uses'=>'Admin\IpiController@index']);
	Route::post('/ipi/index/{id_assistente?}', ['as'=>'ipi.index', 'uses'=>'Admin\IpiController@index']);
	Route::get('/ipi/create/{id_assistente?}', ['as'=>'ipi.create', 'uses'=>'Admin\IpiController@create']);
	Route::post('/ipi/create/{id_assistente?}', ['as'=>'ipi.create', 'uses'=>'Admin\IpiController@create']);
	Route::post('/ipi/store/{id_assistente?}', ['as'=>'ipi.store', 'uses'=>'Admin\IpiController@store']);
	Route::get('/ipi/edit/{id}/{id_assistente?}', ['as'=>'ipi.edit', 'uses'=>'Admin\IpiController@edit']);
	Route::post('/ipi/edit/{id}/{id_assistente?}', ['as'=>'ipi.edit', 'uses'=>'Admin\IpiController@edit']);
	Route::put('/ipi/update/{id}/{id_assistente?}', ['as'=>'ipi.update', 'uses'=>'Admin\IpiController@update']);
	Route::get('/ipi/show/{id}/{id_assistente?}', ['as'=>'ipi.show', 'uses'=>'Admin\IpiController@show']);
	Route::post('/ipi/show/{id}/{id_assistente?}', ['as'=>'ipi.show', 'uses'=>'Admin\IpiController@show']);
	Route::get('/ipi/info/{id}/{id_assistente?}', ['as'=>'ipi.info', 'uses'=>'Admin\IpiController@info']);
	Route::post('/ipi/info/{id}/{id_assistente?}', ['as'=>'ipi.info', 'uses'=>'Admin\IpiController@info']);
	Route::get('/ipi/head/{id_assistente?}', ['as'=>'ipi.head', 'uses'=>'Admin\IpiController@head']);
	Route::post('/ipi/head/{id_assistente?}', ['as'=>'ipi.head', 'uses'=>'Admin\IpiController@head']);
	Route::get('/ipi/destroy/{id}/{id_assistente?}', ['as'=>'ipi.destroy', 'uses'=>'Admin\IpiController@destroy']);
	Route::post('/ipi/destroy/{id}/{id_assistente?}', ['as'=>'ipi.destroy', 'uses'=>'Admin\IpiController@destroy']);

	Route::get('/icms/index/{id_assistente?}', ['as'=>'icms.index', 'uses'=>'Admin\IcmsController@index']);
	Route::post('/icms/index/{id_assistente?}', ['as'=>'icms.index', 'uses'=>'Admin\IcmsController@index']);
	Route::get('/icms/create/{id_assistente?}', ['as'=>'icms.create', 'uses'=>'Admin\IcmsController@create']);
	Route::post('/icms/create/{id_assistente?}', ['as'=>'icms.create', 'uses'=>'Admin\IcmsController@create']);
	Route::post('/icms/store/{id_assistente?}', ['as'=>'icms.store', 'uses'=>'Admin\IcmsController@store']);
	Route::get('/icms/edit/{id}/{id_assistente?}', ['as'=>'icms.edit', 'uses'=>'Admin\IcmsController@edit']);
	Route::post('/icms/edit/{id}/{id_assistente?}', ['as'=>'icms.edit', 'uses'=>'Admin\IcmsController@edit']);
	Route::put('/icms/update/{id}/{id_assistente?}', ['as'=>'icms.update', 'uses'=>'Admin\IcmsController@update']);
	Route::get('/icms/show/{id}/{id_assistente?}', ['as'=>'icms.show', 'uses'=>'Admin\IcmsController@show']);
	Route::post('/icms/show/{id}/{id_assistente?}', ['as'=>'icms.show', 'uses'=>'Admin\IcmsController@show']);
	Route::get('/icms/info/{id}/{id_assistente?}', ['as'=>'icms.info', 'uses'=>'Admin\IcmsController@info']);
	Route::post('/icms/info/{id}/{id_assistente?}', ['as'=>'icms.info', 'uses'=>'Admin\IcmsController@info']);
	Route::get('/icms/head/{id_assistente?}', ['as'=>'icms.head', 'uses'=>'Admin\IcmsController@head']);
	Route::post('/icms/head/{id_assistente?}', ['as'=>'icms.head', 'uses'=>'Admin\IcmsController@head']);
	Route::get('/icms/destroy/{id}/{id_assistente?}', ['as'=>'icms.destroy', 'uses'=>'Admin\IcmsController@destroy']);
	Route::post('/icms/destroy/{id}/{id_assistente?}', ['as'=>'icms.destroy', 'uses'=>'Admin\IcmsController@destroy']);

	Route::get('/pais/index/{id_assistente?}', ['as'=>'pais.index', 'uses'=>'Admin\PaisController@index']);
	Route::post('/pais/index/{id_assistente?}', ['as'=>'pais.index', 'uses'=>'Admin\PaisController@index']);
	Route::get('/pais/create/{id_assistente?}', ['as'=>'pais.create', 'uses'=>'Admin\PaisController@create']);
	Route::post('/pais/create/{id_assistente?}', ['as'=>'pais.create', 'uses'=>'Admin\PaisController@create']);
	Route::post('/pais/store/{id_assistente?}', ['as'=>'pais.store', 'uses'=>'Admin\PaisController@store']);
	Route::get('/pais/edit/{id}/{id_assistente?}', ['as'=>'pais.edit', 'uses'=>'Admin\PaisController@edit']);
	Route::post('/pais/edit/{id}/{id_assistente?}', ['as'=>'pais.edit', 'uses'=>'Admin\PaisController@edit']);
	Route::put('/pais/update/{id}/{id_assistente?}', ['as'=>'pais.update', 'uses'=>'Admin\PaisController@update']);
	Route::get('/pais/show/{id}/{id_assistente?}', ['as'=>'pais.show', 'uses'=>'Admin\PaisController@show']);
	Route::post('/pais/show/{id}/{id_assistente?}', ['as'=>'pais.show', 'uses'=>'Admin\PaisController@show']);
	Route::get('/pais/info/{id}/{id_assistente?}', ['as'=>'pais.info', 'uses'=>'Admin\PaisController@info']);
	Route::post('/pais/info/{id}/{id_assistente?}', ['as'=>'pais.info', 'uses'=>'Admin\PaisController@info']);
	Route::get('/pais/head/{id_assistente?}', ['as'=>'pais.head', 'uses'=>'Admin\PaisController@head']);
	Route::post('/pais/head/{id_assistente?}', ['as'=>'pais.head', 'uses'=>'Admin\PaisController@head']);
	Route::get('/pais/destroy/{id}/{id_assistente?}', ['as'=>'pais.destroy', 'uses'=>'Admin\PaisController@destroy']);
	Route::post('/pais/destroy/{id}/{id_assistente?}', ['as'=>'pais.destroy', 'uses'=>'Admin\PaisController@destroy']);

	Route::get('/estado/index/{id_assistente?}', ['as'=>'estado.index', 'uses'=>'Admin\EstadoController@index']);
	Route::post('/estado/index/{id_assistente?}', ['as'=>'estado.index', 'uses'=>'Admin\EstadoController@index']);
	Route::get('/estado/create/{id_assistente?}', ['as'=>'estado.create', 'uses'=>'Admin\EstadoController@create']);
	Route::post('/estado/create/{id_assistente?}', ['as'=>'estado.create', 'uses'=>'Admin\EstadoController@create']);
	Route::post('/estado/store/{id_assistente?}', ['as'=>'estado.store', 'uses'=>'Admin\EstadoController@store']);
	Route::get('/estado/edit/{id}/{id_assistente?}', ['as'=>'estado.edit', 'uses'=>'Admin\EstadoController@edit']);
	Route::post('/estado/edit/{id}/{id_assistente?}', ['as'=>'estado.edit', 'uses'=>'Admin\EstadoController@edit']);
	Route::put('/estado/update/{id}/{id_assistente?}', ['as'=>'estado.update', 'uses'=>'Admin\EstadoController@update']);
	Route::get('/estado/show/{id}/{id_assistente?}', ['as'=>'estado.show', 'uses'=>'Admin\EstadoController@show']);
	Route::post('/estado/show/{id}/{id_assistente?}', ['as'=>'estado.show', 'uses'=>'Admin\EstadoController@show']);
	Route::get('/estado/info/{id}/{id_assistente?}', ['as'=>'estado.info', 'uses'=>'Admin\EstadoController@info']);
	Route::post('/estado/info/{id}/{id_assistente?}', ['as'=>'estado.info', 'uses'=>'Admin\EstadoController@info']);
	Route::get('/estado/head/{id_assistente?}', ['as'=>'estado.head', 'uses'=>'Admin\EstadoController@head']);
	Route::post('/estado/head/{id_assistente?}', ['as'=>'estado.head', 'uses'=>'Admin\EstadoController@head']);
	Route::get('/estado/destroy/{id}/{id_assistente?}', ['as'=>'estado.destroy', 'uses'=>'Admin\EstadoController@destroy']);
	Route::post('/estado/destroy/{id}/{id_assistente?}', ['as'=>'estado.destroy', 'uses'=>'Admin\EstadoController@destroy']);

	Route::get('/venda/index/{id_assistente?}', ['as'=>'contrato.index', 'uses'=>'Admin\VendaController@index']);//VendaController
	Route::get('/venda/create/{id}/{id_assistente?}', ['as'=>'venda.create', 'uses'=>'Admin\VendaController@create']);
	Route::post('/venda/store/{idPessoa}/{id_assistente?}', ['as'=>'venda.store', 'uses'=>'Admin\VendaController@store']);
	Route::get('/venda/edit/{id}/{idPessoa}/{id_assistente?}', ['as'=>'venda.edit', 'uses'=>'Admin\VendaController@edit']);
	Route::put('/venda/update/{id}/{idPessoa}/{id_assistente?}', ['as'=>'venda.update', 'uses'=>'Admin\VendaController@update']);
	Route::get('/venda/show/{id}/{idPessoa}/{id_assistente?}', ['as'=>'venda.show', 'uses'=>'Admin\VendaController@show']);
	Route::get('/venda/info/{id}/{idPessoa}/{id_assistente?}', ['as'=>'venda.info', 'uses'=>'Admin\VendaController@info']);
	Route::get('/venda/head/{id_assistente?}', ['as'=>'venda.head', 'uses'=>'Admin\VendaController@head']);
	Route::get('/venda/destroy/{id}/{idPessoa}/{id_assistente?}', ['as'=>'venda.destroy', 'uses'=>'Admin\VendaController@destroy']);
	Route::get('/venda/pdv/{id_assistente?}', ['as'=>'venda.pdv', 'uses'=>'Admin\VendaController@pdv']);

	
});


Route::get('/tent', function(){


})->name('tenent')->middleware('tenant');
