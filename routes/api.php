<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api']], function(){
	Route::get('/usuario/index/{id_assistente?}', ['as'=>'usuario.index', 'uses'=>'UsuarioController@index']);
	Route::post('/usuario/index/{id_assistente?}', ['as'=>'usuario.index', 'uses'=>'UsuarioController@index']);
	Route::get('/usuario/json/{id_assistente?}', ['as'=>'usuario.json', 'uses'=>'UsuarioController@json']);
	Route::post('/usuario/json/{id_assistente?}', ['as'=>'usuario.json', 'uses'=>'UsuarioController@json']);
	Route::get('/usuario/create/{id_assistente?}', ['as'=>'usuario.create', 'uses'=>'UsuarioController@create']);
	Route::post('/usuario/create/{id_assistente?}', ['as'=>'usuario.create', 'uses'=>'UsuarioController@create']);
	Route::post('/usuario/store/{id_assistente?}', ['as'=>'usuario.store', 'uses'=>'UsuarioController@store']);
	Route::get('/usuario/edit/{id}/{id_assistente?}', ['as'=>'usuario.edit', 'uses'=>'UsuarioController@edit']);
	Route::post('/usuario/edit/{id}/{id_assistente?}', ['as'=>'usuario.edit', 'uses'=>'UsuarioController@edit']);
	Route::put('/usuario/update/{id}/{id_assistente?}', ['as'=>'usuario.update', 'uses'=>'UsuarioController@update']);
	Route::get('/usuario/show/{id}/{id_assistente?}', ['as'=>'usuario.show', 'uses'=>'UsuarioController@show']);
	Route::post('/usuario/show/{id}/{id_assistente?}', ['as'=>'usuario.show', 'uses'=>'UsuarioController@show']);
	Route::get('/usuario/info/{id}/{id_assistente?}', ['as'=>'usuario.info', 'uses'=>'UsuarioController@info']);
	Route::post('/usuario/info/{id}/{id_assistente?}', ['as'=>'usuario.info', 'uses'=>'UsuarioController@info']);
	Route::get('/usuario/head/{id_assistente?}', ['as'=>'usuario.head', 'uses'=>'UsuarioController@head']);
	Route::post('/usuario/head/{id_assistente?}', ['as'=>'usuario.head', 'uses'=>'UsuarioController@head']);
	Route::get('/usuario/destroy/{id}/{id_assistente?}', ['as'=>'usuario.destroy', 'uses'=>'UsuarioController@destroy']);
	Route::post('/usuario/destroy/{id}/{id_assistente?}', ['as'=>'usuario.destroy', 'uses'=>'UsuarioController@destroy']);

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
	Route::post('/pessoa/index/{id_assistente?}', ['as'=>'pessoa.index', 'uses'=>'Admin\PessoaController@index']);	
	Route::get('/pessoa/json/{id_assistente?}', ['as'=>'pessoa.json', 'uses'=>'Admin\PessoaController@json']);
	Route::post('/pessoa/json/{id_assistente?}', ['as'=>'pessoa.json', 'uses'=>'Admin\PessoaController@json']);
	Route::get('/pessoa/create/{id_assistente?}', ['as'=>'pessoa.create', 'uses'=>'Admin\PessoaController@create']);
	Route::post('/pessoa/create/{id_assistente?}', ['as'=>'pessoa.create', 'uses'=>'Admin\PessoaController@create']);
	Route::post('/pessoa/store/{id_assistente?}', ['as'=>'pessoa.store', 'uses'=>'Admin\PessoaController@store']);
	Route::get('/pessoa/edit/{id}/{id_assistente?}', ['as'=>'pessoa.edit', 'uses'=>'Admin\PessoaController@edit']);
	Route::post('/pessoa/edit/{id}/{id_assistente?}', ['as'=>'pessoa.edit', 'uses'=>'Admin\PessoaController@edit']);
	Route::put('/pessoa/update/{id}/{id_assistente?}', ['as'=>'pessoa.update', 'uses'=>'Admin\PessoaController@update']);
	Route::get('/pessoa/show/{id}/{id_assistente?}', ['as'=>'pessoa.show', 'uses'=>'Admin\PessoaController@show']);
	Route::post('/pessoa/show/{id}/{id_assistente?}', ['as'=>'pessoa.show', 'uses'=>'Admin\PessoaController@show']);
	Route::get('/pessoa/info/{id}', ['as'=>'pessoa.info', 'uses'=>'Admin\PessoaController@info']);
	Route::post('/pessoa/info/{id}', ['as'=>'pessoa.info', 'uses'=>'Admin\PessoaController@info']);
	Route::get('/pessoa/head/{id_assistente?}', ['as'=>'pessoa.head', 'uses'=>'Admin\PessoaController@head']);
	Route::post('/pessoa/head/{id_assistente?}', ['as'=>'pessoa.head', 'uses'=>'Admin\PessoaController@head']);
	Route::get('/pessoa/destroy/{id}/{id_assistente?}', ['as'=>'pessoa.destroy', 'uses'=>'Admin\PessoaController@destroy']);
	Route::get('/pessoa/valida/cpf/{cpf}/{id_assistente?}', ['as'=>'pessoa.valida.cpf', 'uses'=>'Admin\PessoaController@validarCpf']);
	Route::get('/pessoa/plano/adicionar/{id}/{id_assistente?}', ['as'=>'pessoa.plano.adicionar', 'uses'=>'Admin\PessoaController@adicionarPlano']);

	Route::get('/agenda/evento/json', ['as'=>'agenda.evento.json', 'uses'=>'Admin\EventoAgendaController@json']);
	Route::post('/agenda/evento/json', ['as'=>'agenda.evento.json', 'uses'=>'Admin\EventoAgendaController@json']);
	Route::post('/agenda/evento/store', ['as'=>'agenda.evento.store', 'uses'=>'Admin\EventoAgendaController@store']);
	Route::get('/agenda/evento/edit/{id}', ['as'=>'agenda.evento.edit', 'uses'=>'Admin\EventoAgendaController@edit']);
	Route::post('/agenda/evento/edit/{id}', ['as'=>'agenda.evento.edit', 'uses'=>'Admin\EventoAgendaController@edit']);
	Route::put('/agenda/evento/update/{id}', ['as'=>'agenda.evento.update', 'uses'=>'Admin\EventoAgendaController@update']);
	Route::get('/agenda/evento/info/{id}', ['as'=>'agenda.evento.info', 'uses'=>'Admin\EventoAgendaController@info']);
	Route::post('/agenda/evento/info/{id}', ['as'=>'agenda.evento.info', 'uses'=>'Admin\EventoAgendaController@info']);
	Route::get('/agenda/evento/destroy/{id}', ['as'=>'agenda/evento.destroy', 'uses'=>'Admin\EventoAgendaController@destroy']);
	

	Route::get('/grupo/index/{id_assistente?}', ['as'=>'grupo.index', 'uses'=>'Admin\GrupoController@index']);
	Route::post('/grupo/index/{id_assistente?}', ['as'=>'grupo.index', 'uses'=>'Admin\GrupoController@index']);
	Route::get('/grupo/json/{id_assistente?}', ['as'=>'grupo.json', 'uses'=>'Admin\GrupoController@json']);
	Route::post('/grupo/json/{id_assistente?}', ['as'=>'grupo.json', 'uses'=>'Admin\GrupoController@json']);
	Route::get('/grupo/create/{id_assistente?}', ['as'=>'grupo.create', 'uses'=>'Admin\GrupoController@create']);
	Route::post('/grupo/create/{id_assistente?}', ['as'=>'grupo.create', 'uses'=>'Admin\GrupoController@create']);
	Route::post('/grupo/store/{id_assistente?}', ['as'=>'grupo.store', 'uses'=>'Admin\GrupoController@store']);
	Route::get('/grupo/edit/{id}/{id_assistente?}', ['as'=>'grupo.edit', 'uses'=>'Admin\GrupoController@edit']);
	Route::post('/grupo/edit/{id}/{id_assistente?}', ['as'=>'grupo.edit', 'uses'=>'Admin\GrupoController@edit']);
	Route::put('/grupo/update/{id}/{id_assistente?}', ['as'=>'grupo.update', 'uses'=>'Admin\GrupoController@update']);
	Route::get('/grupo/show/{id}/{id_assistente?}', ['as'=>'grupo.show', 'uses'=>'Admin\GrupoController@show']);
	Route::post('/grupo/show/{id}/{id_assistente?}', ['as'=>'grupo.show', 'uses'=>'Admin\GrupoController@show']);
	Route::get('/grupo/info/{id}/{id_assistente?}', ['as'=>'grupo.info', 'uses'=>'Admin\GrupoController@info']);
	Route::post('/grupo/info/{id}/{id_assistente?}', ['as'=>'grupo.info', 'uses'=>'Admin\GrupoController@info']);
	Route::get('/grupo/head/{id_assistente?}', ['as'=>'grupo.head', 'uses'=>'Admin\GrupoController@head']);
	Route::post('/grupo/head/{id_assistente?}', ['as'=>'grupo.head', 'uses'=>'Admin\GrupoController@head']);
	Route::get('/grupo/destroy/{id}/{id_assistente?}', ['as'=>'grupo.destroy', 'uses'=>'Admin\GrupoController@destroy']);
	Route::post('/grupo/destroy/{id}/{id_assistente?}', ['as'=>'grupo.destroy', 'uses'=>'Admin\GrupoController@destroy']);
	
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
	Route::get('/pais/json/{id_assistente?}', ['as'=>'pais.json', 'uses'=>'Admin\PaisController@json']);
	Route::post('/pais/json/{id_assistente?}', ['as'=>'pais.json', 'uses'=>'Admin\PaisController@json']);
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
	Route::get('/estado/json/{id_assistente?}', ['as'=>'estado.json', 'uses'=>'Admin\EstadoController@json']);
	Route::post('/estado/json/{id_assistente?}', ['as'=>'estado.json', 'uses'=>'Admin\EstadoController@json']);
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

	Route::get('/cidade/index/{id_assistente?}', ['as'=>'cidade.index', 'uses'=>'Admin\CidadeController@index']);
	Route::post('/cidade/index/{id_assistente?}', ['as'=>'cidade.index', 'uses'=>'Admin\CidadeController@index']);
	Route::get('/cidade/json/{id_assistente?}', ['as'=>'cidade.json', 'uses'=>'Admin\CidadeController@json']);
	Route::post('/cidade/json/{id_assistente?}', ['as'=>'cidade.json', 'uses'=>'Admin\CidadeController@json']);
	Route::get('/cidade/create/{id_assistente?}', ['as'=>'cidade.create', 'uses'=>'Admin\CidadeController@create']);
	Route::post('/cidade/create/{id_assistente?}', ['as'=>'cidade.create', 'uses'=>'Admin\CidadeController@create']);
	Route::post('/cidade/store/{id_assistente?}', ['as'=>'cidade.store', 'uses'=>'Admin\CidadeController@store']);
	Route::get('/cidade/edit/{id}/{id_assistente?}', ['as'=>'cidade.edit', 'uses'=>'Admin\CidadeController@edit']);
	Route::post('/cidade/edit/{id}/{id_assistente?}', ['as'=>'cidade.edit', 'uses'=>'Admin\CidadeController@edit']);
	Route::put('/cidade/update/{id}/{id_assistente?}', ['as'=>'cidade.update', 'uses'=>'Admin\CidadeController@update']);
	Route::get('/cidade/show/{id}/{id_assistente?}', ['as'=>'cidade.show', 'uses'=>'Admin\CidadeController@show']);
	Route::post('/cidade/show/{id}/{id_assistente?}', ['as'=>'cidade.show', 'uses'=>'Admin\CidadeController@show']);
	Route::get('/cidade/info/{id}/{id_assistente?}', ['as'=>'cidade.info', 'uses'=>'Admin\CidadeController@info']);
	Route::post('/cidade/info/{id}/{id_assistente?}', ['as'=>'cidade.info', 'uses'=>'Admin\CidadeController@info']);
	Route::get('/cidade/head/{id_assistente?}', ['as'=>'cidade.head', 'uses'=>'Admin\CidadeController@head']);
	Route::post('/cidade/head/{id_assistente?}', ['as'=>'cidade.head', 'uses'=>'Admin\CidadeController@head']);
	Route::get('/cidade/destroy/{id}/{id_assistente?}', ['as'=>'cidade.destroy', 'uses'=>'Admin\CidadeController@destroy']);
	Route::post('/cidade/destroy/{id}/{id_assistente?}', ['as'=>'cidade.destroy', 'uses'=>'Admin\CidadeController@destroy']);

	Route::get('/bairro/index/{id_assistente?}', ['as'=>'bairro.index', 'uses'=>'Admin\BairroController@index']);
	Route::post('/bairro/index/{id_assistente?}', ['as'=>'bairro.index', 'uses'=>'Admin\BairroController@index']);
	Route::get('/bairro/create/{id_assistente?}', ['as'=>'bairro.create', 'uses'=>'Admin\BairroController@create']);
	Route::post('/bairro/create/{id_assistente?}', ['as'=>'bairro.create', 'uses'=>'Admin\BairroController@create']);
	Route::post('/bairro/store/{id_assistente?}', ['as'=>'bairro.store', 'uses'=>'Admin\BairroController@store']);
	Route::get('/bairro/edit/{id}/{id_assistente?}', ['as'=>'bairro.edit', 'uses'=>'Admin\BairroController@edit']);
	Route::post('/bairro/edit/{id}/{id_assistente?}', ['as'=>'bairro.edit', 'uses'=>'Admin\BairroController@edit']);
	Route::put('/bairro/update/{id}/{id_assistente?}', ['as'=>'bairro.update', 'uses'=>'Admin\BairroController@update']);
	Route::get('/bairro/show/{id}/{id_assistente?}', ['as'=>'bairro.show', 'uses'=>'Admin\BairroController@show']);
	Route::post('/bairro/show/{id}/{id_assistente?}', ['as'=>'bairro.show', 'uses'=>'Admin\BairroController@show']);
	Route::get('/bairro/info/{id}/{id_assistente?}', ['as'=>'bairro.info', 'uses'=>'Admin\BairroController@info']);
	Route::post('/bairro/info/{id}/{id_assistente?}', ['as'=>'bairro.info', 'uses'=>'Admin\BairroController@info']);
	Route::get('/bairro/head/{id_assistente?}', ['as'=>'bairro.head', 'uses'=>'Admin\BairroController@head']);
	Route::post('/bairro/head/{id_assistente?}', ['as'=>'bairro.head', 'uses'=>'Admin\BairroController@head']);
	Route::get('/bairro/destroy/{id}/{id_assistente?}', ['as'=>'bairro.destroy', 'uses'=>'Admin\BairroController@destroy']);
	Route::post('/bairro/destroy/{id}/{id_assistente?}', ['as'=>'bairro.destroy', 'uses'=>'Admin\BairroController@destroy']);

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

	Route::get('/receber/index/{id_assistente?}', ['as'=>'receber.index', 'uses'=>'Admin\CobrancaReceberController@index']);
	Route::post('/receber/index/{id_assistente?}', ['as'=>'receber.index', 'uses'=>'Admin\CobrancaReceberController@index']);
	Route::get('/receber/create/{id_assistente?}', ['as'=>'receber.create', 'uses'=>'Admin\CobrancaReceberController@create']);
	Route::post('/receber/create/{id_assistente?}', ['as'=>'receber.create', 'uses'=>'Admin\CobrancaReceberController@create']);
	Route::post('/receber/store/{id_assistente?}', ['as'=>'receber.store', 'uses'=>'Admin\CobrancaReceberController@store']);
	Route::get('/receber/edit/{id}/{id_assistente?}', ['as'=>'receber.edit', 'uses'=>'Admin\CobrancaReceberController@edit']);
	Route::post('/receber/edit/{id}/{id_assistente?}', ['as'=>'receber.edit', 'uses'=>'Admin\CobrancaReceberController@edit']);
	Route::put('/receber/update/{id}/{id_assistente?}', ['as'=>'receber.update', 'uses'=>'Admin\CobrancaReceberController@update']);
	Route::get('/receber/show/{id}/{id_assistente?}', ['as'=>'receber.show', 'uses'=>'Admin\CobrancaReceberController@show']);
	Route::post('/receber/show/{id}/{id_assistente?}', ['as'=>'receber.show', 'uses'=>'Admin\CobrancaReceberController@show']);
	Route::get('/receber/info/{id}/{id_assistente?}', ['as'=>'receber.info', 'uses'=>'Admin\CobrancaReceberController@info']);
	Route::post('/receber/info/{id}/{id_assistente?}', ['as'=>'receber.info', 'uses'=>'Admin\CobrancaReceberController@info']);
	Route::get('/receber/head/{id_assistente?}', ['as'=>'receber.head', 'uses'=>'Admin\CobrancaReceberController@head']);
	Route::post('/receber/head/{id_assistente?}', ['as'=>'receber.head', 'uses'=>'Admin\CobrancaReceberController@head']);
	Route::get('/receber/destroy/{id}/{id_assistente?}', ['as'=>'receber.destroy', 'uses'=>'Admin\CobrancaReceberController@destroy']);
	Route::post('/receber/destroy/{id}/{id_assistente?}', ['as'=>'receber.destroy', 'uses'=>'Admin\CobrancaReceberController@destroy']);

	Route::get('/caixa/index/{id_assistente?}', ['as'=>'caixa.index', 'uses'=>'Admin\CaixaController@index']);
	Route::post('/caixa/index/{id_assistente?}', ['as'=>'caixa.index', 'uses'=>'Admin\CaixaController@index']);
	Route::get('/caixa/json/{id_assistente?}', ['as'=>'caixa.json', 'uses'=>'Admin\CaixaController@json']);
	Route::post('/caixa/json/{id_assistente?}', ['as'=>'caixa.json', 'uses'=>'Admin\CaixaController@json']);
	Route::get('/caixa/create/{id_assistente?}', ['as'=>'caixa.create', 'uses'=>'Admin\CaixaController@create']);
	Route::post('/caixa/create/{id_assistente?}', ['as'=>'caixa.create', 'uses'=>'Admin\CaixaController@create']);
	Route::post('/caixa/store/{id_assistente?}', ['as'=>'caixa.store', 'uses'=>'Admin\CaixaController@store']);
	Route::get('/caixa/edit/{id}/{id_assistente?}', ['as'=>'caixa.edit', 'uses'=>'Admin\CaixaController@edit']);
	Route::post('/caixa/edit/{id}/{id_assistente?}', ['as'=>'caixa.edit', 'uses'=>'Admin\CaixaController@edit']);
	Route::put('/caixa/update/{id}/{id_assistente?}', ['as'=>'caixa.update', 'uses'=>'Admin\CaixaController@update']);
	Route::get('/caixa/show/{id}/{id_assistente?}', ['as'=>'caixa.show', 'uses'=>'Admin\CaixaController@show']);
	Route::post('/caixa/show/{id}/{id_assistente?}', ['as'=>'caixa.show', 'uses'=>'Admin\CaixaController@show']);
	Route::get('/caixa/info/{id}/{id_assistente?}', ['as'=>'caixa.info', 'uses'=>'Admin\CaixaController@info']);
	Route::post('/caixa/info/{id}/{id_assistente?}', ['as'=>'caixa.info', 'uses'=>'Admin\CaixaController@info']);
	Route::get('/caixa/head/{id_assistente?}', ['as'=>'caixa.head', 'uses'=>'Admin\CaixaController@head']);
	Route::post('/caixa/head/{id_assistente?}', ['as'=>'caixa.head', 'uses'=>'Admin\CaixaController@head']);
	Route::get('/caixa/destroy/{id}/{id_assistente?}', ['as'=>'caixa.destroy', 'uses'=>'Admin\CaixaController@destroy']);
	Route::post('/caixa/destroy/{id}/{id_assistente?}', ['as'=>'caixa.destroy', 'uses'=>'Admin\CaixaController@destroy']);

	Route::get('/categoria_conta/index/{id_assistente?}', ['as'=>'categoria_conta.index', 'uses'=>'Admin\CategoriaContaController@index']);
	Route::post('/categoria_conta/index/{id_assistente?}', ['as'=>'categoria_conta.index', 'uses'=>'Admin\CategoriaContaController@index']);
	Route::get('/categoria_conta/json/{id_assistente?}', ['as'=>'categoria_conta.json', 'uses'=>'Admin\CategoriaContaController@json']);
	Route::post('/categoria_conta/json/{id_assistente?}', ['as'=>'categoria_conta.json', 'uses'=>'Admin\CategoriaContaController@json']);
	Route::get('/categoria_conta/create/{id_assistente?}', ['as'=>'categoria_conta.create', 'uses'=>'Admin\CategoriaContaController@create']);
	Route::post('/categoria_conta/create/{id_assistente?}', ['as'=>'categoria_conta.create', 'uses'=>'Admin\CategoriaContaController@create']);
	Route::post('/categoria_conta/store/{id_assistente?}', ['as'=>'categoria_conta.store', 'uses'=>'Admin\CategoriaContaController@store']);
	Route::get('/categoria_conta/edit/{id}/{id_assistente?}', ['as'=>'categoria_conta.edit', 'uses'=>'Admin\CategoriaContaController@edit']);
	Route::post('/categoria_conta/edit/{id}/{id_assistente?}', ['as'=>'categoria_conta.edit', 'uses'=>'Admin\CategoriaContaController@edit']);
	Route::put('/categoria_conta/update/{id}/{id_assistente?}', ['as'=>'categoria_conta.update', 'uses'=>'Admin\CategoriaContaController@update']);
	Route::get('/categoria_conta/show/{id}/{id_assistente?}', ['as'=>'categoria_conta.show', 'uses'=>'Admin\CategoriaContaController@show']);
	Route::post('/categoria_conta/show/{id}/{id_assistente?}', ['as'=>'categoria_conta.show', 'uses'=>'Admin\CategoriaContaController@show']);
	Route::get('/categoria_conta/info/{id}/{id_assistente?}', ['as'=>'categoria_conta.info', 'uses'=>'Admin\CategoriaContaController@info']);
	Route::post('/categoria_conta/info/{id}/{id_assistente?}', ['as'=>'categoria_conta.info', 'uses'=>'Admin\CategoriaContaController@info']);
	Route::get('/categoria_conta/head/{id_assistente?}', ['as'=>'categoria_conta.head', 'uses'=>'Admin\CategoriaContaController@head']);
	Route::post('/categoria_conta/head/{id_assistente?}', ['as'=>'categoria_conta.head', 'uses'=>'Admin\CategoriaContaController@head']);
	Route::get('/categoria_conta/destroy/{id}/{id_assistente?}', ['as'=>'categoria_conta.destroy', 'uses'=>'Admin\CategoriaContaController@destroy']);
	Route::post('/categoria_conta/destroy/{id}/{id_assistente?}', ['as'=>'categoria_conta.destroy', 'uses'=>'Admin\CategoriaContaController@destroy']);

	Route::get('/conta/index/{id_assistente?}', ['as'=>'conta.index', 'uses'=>'Admin\ContaController@index']);
	Route::post('/conta/index/{id_assistente?}', ['as'=>'conta.index', 'uses'=>'Admin\ContaController@index']);
	Route::get('/conta/json/{id_assistente?}', ['as'=>'conta.json', 'uses'=>'Admin\ContaController@json']);
	Route::post('/conta/json/{id_assistente?}', ['as'=>'conta.json', 'uses'=>'Admin\ContaController@json']);
	Route::get('/conta/create/{id_assistente?}', ['as'=>'conta.create', 'uses'=>'Admin\ContaController@create']);
	Route::post('/conta/create/{id_assistente?}', ['as'=>'conta.create', 'uses'=>'Admin\ContaController@create']);
	Route::post('/conta/store/{id_assistente?}', ['as'=>'conta.store', 'uses'=>'Admin\ContaController@store']);
	Route::get('/conta/edit/{id}/{id_assistente?}', ['as'=>'conta.edit', 'uses'=>'Admin\ContaController@edit']);
	Route::post('/conta/edit/{id}/{id_assistente?}', ['as'=>'conta.edit', 'uses'=>'Admin\ContaController@edit']);
	Route::put('/conta/update/{id}/{id_assistente?}', ['as'=>'conta.update', 'uses'=>'Admin\ContaController@update']);
	Route::get('/conta/show/{id}/{id_assistente?}', ['as'=>'conta.show', 'uses'=>'Admin\ContaController@show']);
	Route::post('/conta/show/{id}/{id_assistente?}', ['as'=>'conta.show', 'uses'=>'Admin\ContaController@show']);
	Route::get('/conta/info/{id}/{id_assistente?}', ['as'=>'conta.info', 'uses'=>'Admin\ContaController@info']);
	Route::post('/conta/info/{id}/{id_assistente?}', ['as'=>'conta.info', 'uses'=>'Admin\ContaController@info']);
	Route::get('/conta/head/{id_assistente?}', ['as'=>'conta.head', 'uses'=>'Admin\ContaController@head']);
	Route::post('/conta/head/{id_assistente?}', ['as'=>'conta.head', 'uses'=>'Admin\ContaController@head']);
	Route::get('/conta/destroy/{id}/{id_assistente?}', ['as'=>'conta.destroy', 'uses'=>'Admin\ContaController@destroy']);
	Route::post('/conta/destroy/{id}/{id_assistente?}', ['as'=>'conta.destroy', 'uses'=>'Admin\ContaController@destroy']);

});



