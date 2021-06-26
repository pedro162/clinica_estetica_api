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
}]);
Route::post('/admin/login', ['as' => 'admin.login', 'uses' => 'UsuarioController@login']);

Route::group(['middleware' => 'auth'], function(){

	Route::get('/produto/index/{id_assistente?}', ['as'=>'produto.index', 'uses'=>'Admin\ProdutoController@index']);
	Route::post('/produto/index/post', ['as'=>'produto.index.post', 'uses'=>'Admin\ProdutoController@index']);
	Route::get('/produto/create/{id_assistente?}', ['as'=>'produto.create', 'uses'=>'Admin\ProdutoController@create']);
	Route::post('/produto/store/{id_assistente?}', ['as'=>'produto.store', 'uses'=>'Admin\ProdutoController@store']);
	Route::get('/produto/edit/{id}/{id_assistente?}', ['as'=>'produto.edit', 'uses'=>'Admin\ProdutoController@edit']);
	Route::put('/produto/update/{id}/{id_assistente?}', ['as'=>'produto.update', 'uses'=>'Admin\ProdutoController@update']);
	Route::get('/produto/show/{id}/{id_assistente?}', ['as'=>'produto.show', 'uses'=>'Admin\ProdutoController@show']);
	Route::get('/produto/info/{id}/{id_assistente?}', ['as'=>'produto.info', 'uses'=>'Admin\ProdutoController@info']);
	Route::get('/produto/head/{id_assistente?}', ['as'=>'produto.head', 'uses'=>'Admin\ProdutoController@head']);
	Route::get('/produto/destroy/{id}/{id_assistente?}', ['as'=>'produto.destroy', 'uses'=>'Admin\ProdutoController@destroy']);
	Route::get('/produto/adiconar/ingrediente/{id}/{id_assistente?}', ['as'=>'produto.adicionar.ingrediente', 'uses'=>'Admin\ProdutoController@adicionarIngrediente']);
	Route::post('/produto/ingrediente/salvar/{id}/{id_assistente?}', ['as'=>'produto.ingrediente.salvar', 'uses'=>'Admin\ProdutoController@ingredienteSalvar']);
	Route::post('/produto/index/json/{id_assistente?}', ['as'=>'produto.index.json', 'uses'=>'Admin\ProdutoController@indexJson']);


	Route::get('/marca/index', ['as'=>'marca.index', 'uses'=>'Admin\MarcaController@index']);
	Route::get('/marca/create', ['as'=>'marca.create', 'uses'=>'Admin\MarcaController@create']);
	Route::post('/marca/store', ['as'=>'marca.store', 'uses'=>'Admin\MarcaController@store']);
	Route::get('/marca/edit/{id}/{id_assistente?}', ['as'=>'marca.edit', 'uses'=>'Admin\MarcaController@edit']);
	Route::put('/marca/update/{id}', ['as'=>'marca.update', 'uses'=>'Admin\MarcaController@update']);
	Route::get('/marca/show/id', ['as'=>'marca.show', 'uses'=>'Admin\MarcaController@show']);
	Route::get('/marca/info/{id}', ['as'=>'marca.info', 'uses'=>'Admin\MarcaController@info']);
	Route::get('/marca/head', ['as'=>'marca.head', 'uses'=>'Admin\MarcaController@head']);
	Route::get('/marca/destroy/{id}', ['as'=>'marca.destroy', 'uses'=>'Admin\MarcaController@destroy']);


	Route::get('/categoria/index', ['as'=>'categoria.index', 'uses'=>'Admin\CategoriaController@index']);
	Route::get('/categoria/create', ['as'=>'categoria.create', 'uses'=>'Admin\CategoriaController@create']);
	Route::post('/categoria/store', ['as'=>'categoria.store', 'uses'=>'Admin\CategoriaController@store']);
	Route::get('/categoria/edit/{id}', ['as'=>'categoria.edit', 'uses'=>'Admin\CategoriaController@edit']);
	Route::put('/categoria/update/{id}', ['as'=>'categoria.update', 'uses'=>'Admin\CategoriaController@update']);
	Route::get('/categoria/show/id', ['as'=>'categoria.show', 'uses'=>'Admin\CategoriaController@show']);
	Route::get('/categoria/info/{id}', ['as'=>'categoria.info', 'uses'=>'Admin\CategoriaController@info']);
	Route::get('/categoria/head', ['as'=>'categoria.head', 'uses'=>'Admin\CategoriaController@head']);
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

