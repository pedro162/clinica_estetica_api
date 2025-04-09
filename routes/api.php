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
	$user = $request->user();
	if ($user) {
		$user->pessoa;
	}
	return $user;
});

Route::group(['middleware' => ['auth:api']], function () {
	Route::get('/usuario/index/{id_assistente?}', ['as' => 'usuario.index', 'uses' => 'UsuarioController@index']);
	Route::post('/usuario/index/{id_assistente?}', ['as' => 'usuario.index', 'uses' => 'UsuarioController@index']);
	Route::get('/usuario/json/{id_assistente?}', ['as' => 'usuario.json', 'uses' => 'UsuarioController@json']);
	Route::post('/usuario/json/{id_assistente?}', ['as' => 'usuario.json', 'uses' => 'UsuarioController@json']);
	Route::get('/usuario/create/{id_assistente?}', ['as' => 'usuario.create', 'uses' => 'UsuarioController@create']);
	Route::post('/usuario/create/{id_assistente?}', ['as' => 'usuario.create', 'uses' => 'UsuarioController@create']);
	Route::post('/usuario/store/{id_assistente?}', ['as' => 'usuario.store', 'uses' => 'UsuarioController@store']);
	Route::get('/usuario/edit/{id}/{id_assistente?}', ['as' => 'usuario.edit', 'uses' => 'UsuarioController@edit']);
	Route::post('/usuario/edit/{id}/{id_assistente?}', ['as' => 'usuario.edit', 'uses' => 'UsuarioController@edit']);
	Route::put('/usuario/update/{id}/{id_assistente?}', ['as' => 'usuario.update', 'uses' => 'UsuarioController@update']);
	Route::get('/usuario/show/{id}/{id_assistente?}', ['as' => 'usuario.show', 'uses' => 'UsuarioController@show']);
	Route::post('/usuario/show/{id}/{id_assistente?}', ['as' => 'usuario.show', 'uses' => 'UsuarioController@show']);
	Route::get('/usuario/info/{id}/{id_assistente?}', ['as' => 'usuario.info', 'uses' => 'UsuarioController@info']);
	Route::post('/usuario/info/{id}/{id_assistente?}', ['as' => 'usuario.info', 'uses' => 'UsuarioController@info']);
	Route::get('/usuario/head/{id_assistente?}', ['as' => 'usuario.head', 'uses' => 'UsuarioController@head']);
	Route::post('/usuario/head/{id_assistente?}', ['as' => 'usuario.head', 'uses' => 'UsuarioController@head']);
	Route::get('/usuario/destroy/{id}/{id_assistente?}', ['as' => 'usuario.destroy', 'uses' => 'UsuarioController@destroy']);
	Route::post('/usuario/destroy/{id}/{id_assistente?}', ['as' => 'usuario.destroy', 'uses' => 'UsuarioController@destroy']);

	Route::get('/filial/json', ['as' => 'filial.json', 'uses' => 'Admin\FilialController@json']);
	Route::post('/filial/json', ['as' => 'filial.json', 'uses' => 'Admin\FilialController@json']);
	Route::post('/filial/store', ['as' => 'filial.store', 'uses' => 'Admin\FilialController@store']);
	Route::get('/filial/edit/{id}', ['as' => 'filial.edit', 'uses' => 'Admin\FilialController@edit']);
	Route::post('/filial/edit/{id}', ['as' => 'filial.edit', 'uses' => 'Admin\FilialController@edit']);
	Route::put('/filial/update/{id}', ['as' => 'filial.update', 'uses' => 'Admin\FilialController@update']);
	Route::get('/filial/info/{id}', ['as' => 'filial.info', 'uses' => 'Admin\FilialController@info']);
	Route::post('/filial/info/{id}', ['as' => 'filial.info', 'uses' => 'Admin\FilialController@info']);
	Route::get('/filial/destroy/{id}', ['as' => 'filial.destroy', 'uses' => 'Admin\FilialController@destroy']);

	Route::get('/produto/index/{id_assistente?}', ['as' => 'produto.index', 'uses' => 'Admin\ProdutoController@index']);
	Route::post('/produto/index/post', ['as' => 'produto.index.post', 'uses' => 'Admin\ProdutoController@index']);
	Route::get('/produto/create/{id_assistente?}', ['as' => 'produto.create', 'uses' => 'Admin\ProdutoController@create']);
	Route::post('/produto/create/{id_assistente?}', ['as' => 'produto.create', 'uses' => 'Admin\ProdutoController@create']);
	Route::post('/produto/store/{id_assistente?}', ['as' => 'produto.store', 'uses' => 'Admin\ProdutoController@store']);
	Route::get('/produto/edit/{id}/{id_assistente?}', ['as' => 'produto.edit', 'uses' => 'Admin\ProdutoController@edit']);
	Route::post('/produto/edit/{id}/{id_assistente?}', ['as' => 'produto.edit', 'uses' => 'Admin\ProdutoController@edit']);
	Route::put('/produto/update/{id}/{id_assistente?}', ['as' => 'produto.update', 'uses' => 'Admin\ProdutoController@update']);
	Route::get('/produto/show/{id}/{id_assistente?}', ['as' => 'produto.show', 'uses' => 'Admin\ProdutoController@show']);
	Route::post('/produto/show/{id}/{id_assistente?}', ['as' => 'produto.show', 'uses' => 'Admin\ProdutoController@show']);
	Route::get('/produto/info/{id}/{id_assistente?}', ['as' => 'produto.info', 'uses' => 'Admin\ProdutoController@info']);
	Route::post('/produto/info/{id}/{id_assistente?}', ['as' => 'produto.info', 'uses' => 'Admin\ProdutoController@info']);
	Route::get('/produto/head/{id_assistente?}', ['as' => 'produto.head', 'uses' => 'Admin\ProdutoController@head']);
	Route::get('/produto/destroy/{id}/{id_assistente?}', ['as' => 'produto.destroy', 'uses' => 'Admin\ProdutoController@destroy']);
	Route::get('/produto/adiconar/ingrediente/{id}/{id_assistente?}', ['as' => 'produto.adicionar.ingrediente', 'uses' => 'Admin\ProdutoController@adicionarIngrediente']);
	Route::post('/produto/ingrediente/salvar/{id}/{id_assistente?}', ['as' => 'produto.ingrediente.salvar', 'uses' => 'Admin\ProdutoController@ingredienteSalvar']);
	Route::post('/produto/index/json/{id_assistente?}', ['as' => 'produto.index.json', 'uses' => 'Admin\ProdutoController@indexJson']);

	Route::get('/marca/index/{id_assistente?}', ['as' => 'marca.index', 'uses' => 'Admin\MarcaController@index']);
	Route::post('/marca/index/{id_assistente?}', ['as' => 'marca.index', 'uses' => 'Admin\MarcaController@index']);
	Route::get('/marca/create/{id_assistente?}', ['as' => 'marca.create', 'uses' => 'Admin\MarcaController@create']);
	Route::post('/marca/create/{id_assistente?}', ['as' => 'marca.create', 'uses' => 'Admin\MarcaController@create']);
	Route::post('/marca/store', ['as' => 'marca.store', 'uses' => 'Admin\MarcaController@store']);
	Route::get('/marca/edit/{id}/{id_assistente?}', ['as' => 'marca.edit', 'uses' => 'Admin\MarcaController@edit']);
	Route::post('/marca/edit/{id}/{id_assistente?}', ['as' => 'marca.edit', 'uses' => 'Admin\MarcaController@edit']);
	Route::put('/marca/update/{id}/{id_assistente?}', ['as' => 'marca.update', 'uses' => 'Admin\MarcaController@update']);
	Route::get('/marca/show/{id}/{id_assistente?}', ['as' => 'marca.show', 'uses' => 'Admin\MarcaController@show']);
	Route::get('/marca/info/{id}/{id_assistente?}', ['as' => 'marca.info', 'uses' => 'Admin\MarcaController@info']);
	Route::post('/marca/info/{id}/{id_assistente?}', ['as' => 'marca.info', 'uses' => 'Admin\MarcaController@info']);
	Route::get('/marca/head/{id_assistente?}', ['as' => 'marca.head', 'uses' => 'Admin\MarcaController@head']);
	Route::get('/marca/destroy/{id}/{id_assistente?}', ['as' => 'marca.destroy', 'uses' => 'Admin\MarcaController@destroy']);

	Route::get('/categoria/index/{id_assistente?}', ['as' => 'categoria.index', 'uses' => 'Admin\CategoriaController@index']);
	Route::post('/categoria/index/{id_assistente?}', ['as' => 'categoria.index', 'uses' => 'Admin\CategoriaController@index']);
	Route::get('/categoria/create/{id_assistente?}', ['as' => 'categoria.create', 'uses' => 'Admin\CategoriaController@create']);
	Route::post('/categoria/create/{id_assistente?}', ['as' => 'categoria.create', 'uses' => 'Admin\CategoriaController@create']);
	Route::post('/categoria/store', ['as' => 'categoria.store', 'uses' => 'Admin\CategoriaController@store']);
	Route::get('/categoria/edit/{id}/{id_assistente?}', ['as' => 'categoria.edit', 'uses' => 'Admin\CategoriaController@edit']);
	Route::post('/categoria/edit/{id}/{id_assistente?}', ['as' => 'categoria.edit', 'uses' => 'Admin\CategoriaController@edit']);
	Route::put('/categoria/update/{id}/{id_assistente?}', ['as' => 'categoria.update', 'uses' => 'Admin\CategoriaController@update']);
	Route::get('/categoria/show/id/{id_assistente?}', ['as' => 'categoria.show', 'uses' => 'Admin\CategoriaController@show']);
	Route::post('/categoria/show/id/{id_assistente?}', ['as' => 'categoria.show', 'uses' => 'Admin\CategoriaController@show']);
	Route::get('/categoria/info/{id}/{id_assistente?}', ['as' => 'categoria.info', 'uses' => 'Admin\CategoriaController@info']);
	Route::post('/categoria/info/{id}/{id_assistente?}', ['as' => 'categoria.info', 'uses' => 'Admin\CategoriaController@info']);
	Route::get('/categoria/head/{id_assistente?}', ['as' => 'categoria.head', 'uses' => 'Admin\CategoriaController@head']);
	Route::get('/categoria/destroy/{id}', ['as' => 'categoria.destroy', 'uses' => 'Admin\CategoriaController@destroy']);

	Route::get('/pessoa/index/{id_assistente?}', ['as' => 'pessoa.index', 'uses' => 'Admin\PessoaController@index']);
	Route::post('/pessoa/index/{id_assistente?}', ['as' => 'pessoa.index', 'uses' => 'Admin\PessoaController@index']);
	Route::get('/pessoa/json/{id_assistente?}', ['as' => 'pessoa.json', 'uses' => 'Admin\PessoaController@json']);
	Route::post('/pessoa/json/{id_assistente?}', ['as' => 'pessoa.json', 'uses' => 'Admin\PessoaController@json']);
	Route::get('/pessoa/create/{id_assistente?}', ['as' => 'pessoa.create', 'uses' => 'Admin\PessoaController@create']);
	Route::post('/pessoa/create/{id_assistente?}', ['as' => 'pessoa.create', 'uses' => 'Admin\PessoaController@create']);
	Route::post('/pessoa/store/{id_assistente?}', ['as' => 'pessoa.store', 'uses' => 'Admin\PessoaController@store']);
	Route::get('/pessoa/edit/{id}/{id_assistente?}', ['as' => 'pessoa.edit', 'uses' => 'Admin\PessoaController@edit']);
	Route::post('/pessoa/edit/{id}/{id_assistente?}', ['as' => 'pessoa.edit', 'uses' => 'Admin\PessoaController@edit']);
	Route::put('/pessoa/update/{id}/{id_assistente?}', ['as' => 'pessoa.update', 'uses' => 'Admin\PessoaController@update']);
	Route::get('/pessoa/show/{id}/{id_assistente?}', ['as' => 'pessoa.show', 'uses' => 'Admin\PessoaController@show']);
	Route::post('/pessoa/show/{id}/{id_assistente?}', ['as' => 'pessoa.show', 'uses' => 'Admin\PessoaController@show']);
	Route::get('/pessoa/info/{id}', ['as' => 'pessoa.info', 'uses' => 'Admin\PessoaController@info']);
	Route::post('/pessoa/info/{id}', ['as' => 'pessoa.info', 'uses' => 'Admin\PessoaController@info']);
	Route::get('/pessoa/head/{id_assistente?}', ['as' => 'pessoa.head', 'uses' => 'Admin\PessoaController@head']);
	Route::post('/pessoa/head/{id_assistente?}', ['as' => 'pessoa.head', 'uses' => 'Admin\PessoaController@head']);
	Route::get('/pessoa/destroy/{id}/{id_assistente?}', ['as' => 'pessoa.destroy', 'uses' => 'Admin\PessoaController@destroy']);
	Route::get('/pessoa/valida/cpf/{cpf}/{id_assistente?}', ['as' => 'pessoa.valida.cpf', 'uses' => 'Admin\PessoaController@validarCpf']);
	Route::get('/pessoa/plano/adicionar/{id}/{id_assistente?}', ['as' => 'pessoa.plano.adicionar', 'uses' => 'Admin\PessoaController@adicionarPlano']);
	Route::get('/pessoa/ultima/ficha/info/{id}', ['as' => 'pessoa.ultima.ficha.info', 'uses' => 'Admin\PessoaController@lastFichaInfo']);
	Route::post('/pessoa/ultima/ficha/info/{id}', ['as' => 'pessoa.ultima.ficha.info', 'uses' => 'Admin\PessoaController@lastFichaInfo']);

	Route::get('/agenda/evento/json', ['as' => 'agenda.evento.json', 'uses' => 'Admin\EventoAgendaController@json']);
	Route::post('/agenda/evento/json', ['as' => 'agenda.evento.json', 'uses' => 'Admin\EventoAgendaController@json']);
	Route::post('/agenda/evento/store', ['as' => 'agenda.evento.store', 'uses' => 'Admin\EventoAgendaController@store']);
	Route::get('/agenda/evento/edit/{id}', ['as' => 'agenda.evento.edit', 'uses' => 'Admin\EventoAgendaController@edit']);
	Route::post('/agenda/evento/edit/{id}', ['as' => 'agenda.evento.edit', 'uses' => 'Admin\EventoAgendaController@edit']);
	Route::put('/agenda/evento/update/{id}', ['as' => 'agenda.evento.update', 'uses' => 'Admin\EventoAgendaController@update']);
	Route::get('/agenda/evento/info/{id}', ['as' => 'agenda.evento.info', 'uses' => 'Admin\EventoAgendaController@info']);
	Route::post('/agenda/evento/info/{id}', ['as' => 'agenda.evento.info', 'uses' => 'Admin\EventoAgendaController@info']);
	Route::get('/agenda/evento/destroy/{id}', ['as' => 'agenda/evento.destroy', 'uses' => 'Admin\EventoAgendaController@destroy']);

	Route::get('/categoria/evento/json', ['as' => 'categoria.evento.json', 'uses' => 'Admin\CategoriaEventoController@json']);
	Route::post('/categoria/evento/json', ['as' => 'categoria.evento.json', 'uses' => 'Admin\CategoriaEventoController@json']);
	Route::post('/categoria/evento/store', ['as' => 'categoria.evento.store', 'uses' => 'Admin\CategoriaEventoController@store']);
	Route::get('/categoria/evento/edit/{id}', ['as' => 'categoria.evento.edit', 'uses' => 'Admin\CategoriaEventoController@edit']);
	Route::post('/categoria/evento/edit/{id}', ['as' => 'categoria.evento.edit', 'uses' => 'Admin\CategoriaEventoController@edit']);
	Route::put('/categoria/evento/update/{id}', ['as' => 'categoria.evento.update', 'uses' => 'Admin\CategoriaEventoController@update']);
	Route::get('/categoria/evento/info/{id}', ['as' => 'categoria.evento.info', 'uses' => 'Admin\CategoriaEventoController@info']);
	Route::post('/categoria/evento/info/{id}', ['as' => 'categoria.evento.info', 'uses' => 'Admin\CategoriaEventoController@info']);
	Route::get('/categoria/evento/destroy/{id}', ['as' => 'categoria/evento.destroy', 'uses' => 'Admin\CategoriaEventoController@destroy']);

	Route::get('/especialidade/json', ['as' => 'especialidade.json', 'uses' => 'Admin\EspecialidadeController@json']);
	Route::post('/especialidade/json', ['as' => 'especialidade.json', 'uses' => 'Admin\EspecialidadeController@json']);
	Route::post('/especialidade/store', ['as' => 'especialidade.store', 'uses' => 'Admin\EspecialidadeController@store']);
	Route::get('/especialidade/edit/{id}', ['as' => 'especialidade.edit', 'uses' => 'Admin\EspecialidadeController@edit']);
	Route::post('/especialidade/edit/{id}', ['as' => 'especialidade.edit', 'uses' => 'Admin\EspecialidadeController@edit']);
	Route::put('/especialidade/update/{id}', ['as' => 'especialidade.update', 'uses' => 'Admin\EspecialidadeController@update']);
	Route::get('/especialidade/info/{id}', ['as' => 'especialidade.info', 'uses' => 'Admin\EspecialidadeController@info']);
	Route::post('/especialidade/info/{id}', ['as' => 'especialidade.info', 'uses' => 'Admin\EspecialidadeController@info']);
	Route::get('/especialidade/destroy/{id}', ['as' => 'especialidade/destroy', 'uses' => 'Admin\EspecialidadeController@destroy']);

	Route::get('/profissional/json', ['as' => 'profissional.json', 'uses' => 'Admin\ProfissionalController@json']);
	Route::post('/profissional/json', ['as' => 'profissional.json', 'uses' => 'Admin\ProfissionalController@json']);
	Route::post('/profissional/store', ['as' => 'profissional.store', 'uses' => 'Admin\ProfissionalController@store']);
	Route::get('/profissional/edit/{id}', ['as' => 'profissional.edit', 'uses' => 'Admin\ProfissionalController@edit']);
	Route::post('/profissional/edit/{id}', ['as' => 'profissional.edit', 'uses' => 'Admin\ProfissionalController@edit']);
	Route::put('/profissional/update/{id}', ['as' => 'profissional.update', 'uses' => 'Admin\ProfissionalController@update']);
	Route::get('/profissional/info/{id}', ['as' => 'profissional.info', 'uses' => 'Admin\ProfissionalController@info']);
	Route::post('/profissional/info/{id}', ['as' => 'profissional.info', 'uses' => 'Admin\ProfissionalController@info']);
	Route::get('/profissional/destroy/{id}', ['as' => 'profissional/destroy', 'uses' => 'Admin\ProfissionalController@destroy']);

	Route::get('/profissional/hoario/json', ['as' => 'profissional.hoario.json', 'uses' => 'Admin\ProfissionalHorarioController@json']);
	Route::post('/profissional/hoario/json', ['as' => 'profissional.hoario.json', 'uses' => 'Admin\ProfissionalHorarioController@json']);
	Route::post('/profissional/hoario/store', ['as' => 'profissional.hoario.store', 'uses' => 'Admin\ProfissionalHorarioController@store']);
	Route::get('/profissional/hoario/edit/{id}', ['as' => 'profissional.hoario.edit', 'uses' => 'Admin\ProfissionalHorarioController@edit']);
	Route::post('/profissional/hoario/edit/{id}', ['as' => 'profissional.hoario.edit', 'uses' => 'Admin\ProfissionalHorarioController@edit']);
	Route::put('/profissional/hoario/update/{id}', ['as' => 'profissional.hoario.update', 'uses' => 'Admin\ProfissionalHorarioController@update']);
	Route::get('/profissional/hoario/info/{id}', ['as' => 'profissional.hoario.info', 'uses' => 'Admin\ProfissionalHorarioController@info']);
	Route::post('/profissional/hoario/info/{id}', ['as' => 'profissional.hoario.info', 'uses' => 'Admin\ProfissionalHorarioController@info']);
	Route::get('/profissional/hoario/destroy/{id}', ['as' => 'profissional.hoario/destroy', 'uses' => 'Admin\ProfissionalHorarioController@destroy']);

	Route::get('/profissional/dia/exprediente/json', ['as' => 'profissional.dia.exprediente.json', 'uses' => 'Admin\ProfissionalDiaExpedienteController@json']);
	Route::post('/profissional/dia/exprediente/json', ['as' => 'profissional.dia.exprediente.json', 'uses' => 'Admin\ProfissionalDiaExpedienteController@json']);
	Route::post('/profissional/dia/exprediente/store', ['as' => 'profissional.dia.exprediente.store', 'uses' => 'Admin\ProfissionalDiaExpedienteController@store']);
	Route::get('/profissional/dia/exprediente/edit/{id}', ['as' => 'profissional.dia.exprediente.edit', 'uses' => 'Admin\ProfissionalDiaExpedienteController@edit']);
	Route::post('/profissional/dia/exprediente/edit/{id}', ['as' => 'profissional.dia.exprediente.edit', 'uses' => 'Admin\ProfissionalDiaExpedienteController@edit']);
	Route::put('/profissional/dia/exprediente/update/{id}', ['as' => 'profissional.dia.exprediente.update', 'uses' => 'Admin\ProfissionalDiaExpedienteController@update']);
	Route::get('/profissional/dia/exprediente/info/{id}', ['as' => 'profissional.dia.exprediente.info', 'uses' => 'Admin\ProfissionalDiaExpedienteController@info']);
	Route::post('/profissional/dia/exprediente/info/{id}', ['as' => 'profissional.dia.exprediente.info', 'uses' => 'Admin\ProfissionalDiaExpedienteController@info']);
	Route::get('/profissional/dia/exprediente/destroy/{id}', ['as' => 'profissional.dia.exprediente/destroy', 'uses' => 'Admin\ProfissionalDiaExpedienteController@destroy']);

	Route::get('/grupo/index/{id_assistente?}', ['as' => 'grupo.index', 'uses' => 'Admin\GrupoController@index']);
	Route::post('/grupo/index/{id_assistente?}', ['as' => 'grupo.index', 'uses' => 'Admin\GrupoController@index']);
	Route::get('/grupo/json/{id_assistente?}', ['as' => 'grupo.json', 'uses' => 'Admin\GrupoController@json']);
	Route::post('/grupo/json/{id_assistente?}', ['as' => 'grupo.json', 'uses' => 'Admin\GrupoController@json']);
	Route::get('/grupo/create/{id_assistente?}', ['as' => 'grupo.create', 'uses' => 'Admin\GrupoController@create']);
	Route::post('/grupo/create/{id_assistente?}', ['as' => 'grupo.create', 'uses' => 'Admin\GrupoController@create']);
	Route::post('/grupo/store/{id_assistente?}', ['as' => 'grupo.store', 'uses' => 'Admin\GrupoController@store']);
	Route::get('/grupo/edit/{id}/{id_assistente?}', ['as' => 'grupo.edit', 'uses' => 'Admin\GrupoController@edit']);
	Route::post('/grupo/edit/{id}/{id_assistente?}', ['as' => 'grupo.edit', 'uses' => 'Admin\GrupoController@edit']);
	Route::put('/grupo/update/{id}/{id_assistente?}', ['as' => 'grupo.update', 'uses' => 'Admin\GrupoController@update']);
	Route::get('/grupo/show/{id}/{id_assistente?}', ['as' => 'grupo.show', 'uses' => 'Admin\GrupoController@show']);
	Route::post('/grupo/show/{id}/{id_assistente?}', ['as' => 'grupo.show', 'uses' => 'Admin\GrupoController@show']);
	Route::get('/grupo/info/{id}/{id_assistente?}', ['as' => 'grupo.info', 'uses' => 'Admin\GrupoController@info']);
	Route::post('/grupo/info/{id}/{id_assistente?}', ['as' => 'grupo.info', 'uses' => 'Admin\GrupoController@info']);
	Route::get('/grupo/head/{id_assistente?}', ['as' => 'grupo.head', 'uses' => 'Admin\GrupoController@head']);
	Route::post('/grupo/head/{id_assistente?}', ['as' => 'grupo.head', 'uses' => 'Admin\GrupoController@head']);
	Route::get('/grupo/destroy/{id}/{id_assistente?}', ['as' => 'grupo.destroy', 'uses' => 'Admin\GrupoController@destroy']);
	Route::post('/grupo/destroy/{id}/{id_assistente?}', ['as' => 'grupo.destroy', 'uses' => 'Admin\GrupoController@destroy']);

	Route::get('/logradouro/index/{id_assistente?}', ['as' => 'logradouro.index', 'uses' => 'Admin\LogradouroController@index']);
	Route::get('/logradouro/create/{id}/{id_assistente?}', ['as' => 'logradouro.create', 'uses' => 'Admin\LogradouroController@create']);
	Route::post('/logradouro/store/{idPessoa}/{id_assistente?}', ['as' => 'logradouro.store', 'uses' => 'Admin\LogradouroController@store']);
	Route::get('/logradouro/edit/{id}/{idPessoa}/{id_assistente?}', ['as' => 'logradouro.edit', 'uses' => 'Admin\LogradouroController@edit']);
	Route::put('/logradouro/update/{id}/{idPessoa}/{id_assistente?}', ['as' => 'logradouro.update', 'uses' => 'Admin\LogradouroController@update']);
	Route::get('/logradouro/show/{id}/{idPessoa}/{id_assistente?}', ['as' => 'logradouro.show', 'uses' => 'Admin\LogradouroController@show']);
	Route::get('/logradouro/info/{id}/{idPessoa}/{id_assistente?}', ['as' => 'logradouro.info', 'uses' => 'Admin\LogradouroController@info']);
	Route::get('/logradouro/head/{id_assistente?}', ['as' => 'logradouro.head', 'uses' => 'Admin\LogradouroController@head']);
	Route::get('/logradouro/destroy/{id}/{idPessoa}/{id_assistente?}', ['as' => 'logradouro.destroy', 'uses' => 'Admin\LogradouroController@destroy']);

	Route::get('/logradouro/load/api', ['as' => 'logradouro.load.api', 'uses' => 'Admin\LogradouroController@loadLogradouroApi']);


	Route::get('/contrato/index/{id_assistente?}', ['as' => 'contrato.index', 'uses' => 'Admin\ContratoController@index']);
	Route::get('/contrato/create/{id}/{id_assistente?}', ['as' => 'contrato.create', 'uses' => 'Admin\ContratoController@create']);
	Route::post('/contrato/store/{idPessoa}/{id_assistente?}', ['as' => 'contrato.store', 'uses' => 'Admin\ContratoController@store']);
	Route::get('/contrato/edit/{id}/{idPessoa}/{id_assistente?}', ['as' => 'contrato.edit', 'uses' => 'Admin\ContratoController@edit']);
	Route::put('/contrato/update/{id}/{idPessoa}/{id_assistente?}', ['as' => 'contrato.update', 'uses' => 'Admin\ContratoController@update']);
	Route::get('/contrato/show/{id}/{idPessoa}/{id_assistente?}', ['as' => 'contrato.show', 'uses' => 'Admin\ContratoController@show']);
	Route::get('/contrato/info/{id}/{idPessoa}/{id_assistente?}', ['as' => 'contrato.info', 'uses' => 'Admin\ContratoController@info']);
	Route::get('/contrato/head/{id_assistente?}', ['as' => 'contrato.head', 'uses' => 'Admin\ContratoController@head']);
	Route::get('/contrato/destroy/{id}/{idPessoa}/{id_assistente?}', ['as' => 'contrato.destroy', 'uses' => 'Admin\ContratoController@destroy']);


	Route::get('/plano_pagamento/index/{id_assistente?}', ['as' => 'plano_pagamento.index', 'uses' => 'Admin\PlanoPagamentoController@index']);
	Route::post('/plano_pagamento/index/{id_assistente?}', ['as' => 'plano_pagamento.index', 'uses' => 'Admin\PlanoPagamentoController@index']);
	Route::get('/plano_pagamento/json/{id_assistente?}', ['as' => 'plano_pagamento.json', 'uses' => 'Admin\PlanoPagamentoController@json']);
	Route::post('/plano_pagamento/json/{id_assistente?}', ['as' => 'plano_pagamento.json', 'uses' => 'Admin\PlanoPagamentoController@json']);
	Route::get('/plano_pagamento/create/{id_assistente?}', ['as' => 'plano_pagamento.create', 'uses' => 'Admin\PlanoPagamentoController@create']);
	Route::post('/plano_pagamento/store/{id_assistente?}', ['as' => 'plano_pagamento.store', 'uses' => 'Admin\PlanoPagamentoController@store']);
	Route::get('/plano_pagamento/edit/{id}/{id_assistente?}', ['as' => 'plano_pagamento.edit', 'uses' => 'Admin\PlanoPagamentoController@edit']);
	Route::put('/plano_pagamento/update/{id}/{id_assistente?}', ['as' => 'plano_pagamento.update', 'uses' => 'Admin\PlanoPagamentoController@update']);
	Route::get('/plano_pagamento/show/{id}/{id_assistente?}', ['as' => 'plano_pagamento.show', 'uses' => 'Admin\PlanoPagamentoController@show']);
	Route::get('/plano_pagamento/info/{id}/{id_assistente?}', ['as' => 'plano_pagamento.info', 'uses' => 'Admin\PlanoPagamentoController@info']);
	Route::get('/plano_pagamento/head/{id_assistente?}', ['as' => 'plano_pagamento.head', 'uses' => 'Admin\PlanoPagamentoController@head']);
	Route::get('/plano_pagamento/destroy/{id}/{id_assistente?}', ['as' => 'plano_pagamento.destroy', 'uses' => 'Admin\PlanoPagamentoController@destroy']);


	Route::get('/prazo_pagamento/index/{id_assistente?}', ['as' => 'prazo_pagamento.index', 'uses' => 'Admin\PrazoPagamentoController@index']);
	Route::post('/prazo_pagamento/index/{id_assistente?}', ['as' => 'prazo_pagamento.index', 'uses' => 'Admin\PrazoPagamentoController@index']);
	Route::get('/prazo_pagamento/json/{id_assistente?}', ['as' => 'prazo_pagamento.json', 'uses' => 'Admin\PrazoPagamentoController@json']);
	Route::post('/prazo_pagamento/json/{id_assistente?}', ['as' => 'prazo_pagamento.json', 'uses' => 'Admin\PrazoPagamentoController@json']);
	Route::get('/prazo_pagamento/create/{id_assistente?}', ['as' => 'prazo_pagamento.create', 'uses' => 'Admin\PrazoPagamentoController@create']);
	Route::post('/prazo_pagamento/store/{id_assistente?}', ['as' => 'prazo_pagamento.store', 'uses' => 'Admin\PrazoPagamentoController@store']);
	Route::get('/prazo_pagamento/edit/{id}/{id_assistente?}', ['as' => 'prazo_pagamento.edit', 'uses' => 'Admin\PrazoPagamentoController@edit']);
	Route::put('/prazo_pagamento/update/{id}/{id_assistente?}', ['as' => 'prazo_pagamento.update', 'uses' => 'Admin\PrazoPagamentoController@update']);
	Route::get('/prazo_pagamento/show/{id}/{id_assistente?}', ['as' => 'prazo_pagamento.show', 'uses' => 'Admin\PrazoPagamentoController@show']);
	Route::get('/prazo_pagamento/info/{id}/{id_assistente?}', ['as' => 'prazo_pagamento.info', 'uses' => 'Admin\PrazoPagamentoController@info']);
	Route::get('/prazo_pagamento/head/{id_assistente?}', ['as' => 'prazo_pagamento.head', 'uses' => 'Admin\PrazoPagamentoController@head']);
	Route::get('/prazo_pagamento/destroy/{id}/{id_assistente?}', ['as' => 'prazo_pagamento.destroy', 'uses' => 'Admin\PrazoPagamentoController@destroy']);


	Route::get('/forma_pagamento/index/{id_assistente?}', ['as' => 'forma_pagamento.index', 'uses' => 'Admin\FormaPagamentoController@index']);
	Route::post('/forma_pagamento/index/{id_assistente?}', ['as' => 'forma_pagamento.index', 'uses' => 'Admin\FormaPagamentoController@index']);
	Route::get('/forma_pagamento/json/{id_assistente?}', ['as' => 'forma_pagamento.json', 'uses' => 'Admin\FormaPagamentoController@json']);
	Route::post('/forma_pagamento/json/{id_assistente?}', ['as' => 'forma_pagamento.json', 'uses' => 'Admin\FormaPagamentoController@json']);
	Route::get('/forma_pagamento/create/{id_assistente?}', ['as' => 'forma_pagamento.create', 'uses' => 'Admin\FormaPagamentoController@create']);
	Route::post('/forma_pagamento/store/{id_assistente?}', ['as' => 'forma_pagamento.store', 'uses' => 'Admin\FormaPagamentoController@store']);
	Route::get('/forma_pagamento/edit/{id}/{id_assistente?}', ['as' => 'forma_pagamento.edit', 'uses' => 'Admin\FormaPagamentoController@edit']);
	Route::put('/forma_pagamento/update/{id}/{id_assistente?}', ['as' => 'forma_pagamento.update', 'uses' => 'Admin\FormaPagamentoController@update']);
	Route::get('/forma_pagamento/show/{id}/{id_assistente?}', ['as' => 'forma_pagamento.show', 'uses' => 'Admin\FormaPagamentoController@show']);
	Route::get('/forma_pagamento/info/{id}/{id_assistente?}', ['as' => 'forma_pagamento.info', 'uses' => 'Admin\FormaPagamentoController@info']);
	Route::get('/forma_pagamento/head/{id_assistente?}', ['as' => 'forma_pagamento.head', 'uses' => 'Admin\FormaPagamentoController@head']);
	Route::get('/forma_pagamento/destroy/{id}/{id_assistente?}', ['as' => 'forma_pagamento.destroy', 'uses' => 'Admin\FormaPagamentoController@destroy']);

	Route::post('/forma_pagamento/plano/pagamento/json/{id_assistente?}', ['as' => 'forma_pagamento.plano.pagamento.json', 'uses' => 'Admin\FormaPagamentoController@planoPagamentoJson']);
	Route::post('/forma_pagamento/operador/financeiro/json/{id_assistente?}', ['as' => 'forma_pagamento.operador.financeiro.json', 'uses' => 'Admin\FormaPagamentoController@operadorJson']);


	Route::get('/operador_financeiro/index/{id_assistente?}', ['as' => 'operador_financeiro.index', 'uses' => 'Admin\OperadorFinanceiroController@index']);
	Route::post('/operador_financeiro/index/{id_assistente?}', ['as' => 'operador_financeiro.index', 'uses' => 'Admin\OperadorFinanceiroController@index']);
	Route::get('/operador_financeiro/json/{id_assistente?}', ['as' => 'operador_financeiro.json', 'uses' => 'Admin\OperadorFinanceiroController@json']);
	Route::post('/operador_financeiro/json/{id_assistente?}', ['as' => 'operador_financeiro.json', 'uses' => 'Admin\OperadorFinanceiroController@json']);
	Route::get('/operador_financeiro/create/{id_assistente?}', ['as' => 'operador_financeiro.create', 'uses' => 'Admin\OperadorFinanceiroController@create']);
	Route::post('/operador_financeiro/store/{id_assistente?}', ['as' => 'operador_financeiro.store', 'uses' => 'Admin\OperadorFinanceiroController@store']);
	Route::get('/operador_financeiro/edit/{id}/{id_assistente?}', ['as' => 'operador_financeiro.edit', 'uses' => 'Admin\OperadorFinanceiroController@edit']);
	Route::put('/operador_financeiro/update/{id}/{id_assistente?}', ['as' => 'operador_financeiro.update', 'uses' => 'Admin\OperadorFinanceiroController@update']);
	Route::get('/operador_financeiro/show/{id}/{id_assistente?}', ['as' => 'operador_financeiro.show', 'uses' => 'Admin\OperadorFinanceiroController@show']);
	Route::get('/operador_financeiro/info/{id}/{id_assistente?}', ['as' => 'operador_financeiro.info', 'uses' => 'Admin\OperadorFinanceiroController@info']);
	Route::post('/operador_financeiro/info/{id}/{id_assistente?}', ['as' => 'operador_financeiro.info', 'uses' => 'Admin\OperadorFinanceiroController@info']);
	Route::get('/operador_financeiro/head/{id_assistente?}', ['as' => 'operador_financeiro.head', 'uses' => 'Admin\OperadorFinanceiroController@head']);
	Route::get('/operador_financeiro/destroy/{id}/{id_assistente?}', ['as' => 'operador_financeiro.destroy', 'uses' => 'Admin\OperadorFinanceiroController@destroy']);

	Route::get('/nfe/index/{id_assistente?}', ['as' => 'nfe.index', 'uses' => 'Admin\NfeController@index']);
	Route::get('/nfe/create/{id_assistente?}', ['as' => 'nfe.create', 'uses' => 'Admin\NfeController@create']);
	Route::post('/nfe/store/{id_assistente?}', ['as' => 'nfe.store', 'uses' => 'Admin\NfeController@store']);
	Route::get('/nfe/edit/{id}/{id_assistente?}', ['as' => 'nfe.edit', 'uses' => 'Admin\NfeController@edit']);
	Route::put('/nfe/update/{id}/{id_assistente?}', ['as' => 'nfe.update', 'uses' => 'Admin\NfeController@update']);
	Route::get('/nfe/show/{id}/{id_assistente?}', ['as' => 'nfe.show', 'uses' => 'Admin\NfeController@show']);
	Route::get('/nfe/info/{id}/{id_assistente?}', ['as' => 'nfe.info', 'uses' => 'Admin\NfeController@info']);
	Route::get('/nfe/montagemxml/{id_assistente?}', ['as' => 'nfe.index', 'uses' => 'Admin\NfeController@montagemXml']);

	Route::get('/ncm/index/{id_assistente?}', ['as' => 'ncm.index', 'uses' => 'Admin\NcmController@index']);
	Route::post('/ncm/index/{id_assistente?}', ['as' => 'ncm.index', 'uses' => 'Admin\NcmController@index']);
	Route::get('/ncm/create/{id_assistente?}', ['as' => 'ncm.create', 'uses' => 'Admin\NcmController@create']);
	Route::post('/ncm/create/{id_assistente?}', ['as' => 'ncm.create', 'uses' => 'Admin\NcmController@create']);
	Route::post('/ncm/store/{id_assistente?}', ['as' => 'ncm.store', 'uses' => 'Admin\NcmController@store']);
	Route::get('/ncm/edit/{id}/{id_assistente?}', ['as' => 'ncm.edit', 'uses' => 'Admin\NcmController@edit']);
	Route::post('/ncm/edit/{id}/{id_assistente?}', ['as' => 'ncm.edit', 'uses' => 'Admin\NcmController@edit']);
	Route::put('/ncm/update/{id}/{id_assistente?}', ['as' => 'ncm.update', 'uses' => 'Admin\NcmController@update']);
	Route::get('/ncm/show/{id}/{id_assistente?}', ['as' => 'ncm.show', 'uses' => 'Admin\NcmController@show']);
	Route::post('/ncm/show/{id}/{id_assistente?}', ['as' => 'ncm.show', 'uses' => 'Admin\NcmController@show']);
	Route::get('/ncm/info/{id}/{id_assistente?}', ['as' => 'ncm.info', 'uses' => 'Admin\NcmController@info']);
	Route::post('/ncm/info/{id}/{id_assistente?}', ['as' => 'ncm.info', 'uses' => 'Admin\NcmController@info']);
	Route::get('/ncm/head/{id_assistente?}', ['as' => 'ncm.head', 'uses' => 'Admin\NcmController@head']);
	Route::get('/ncm/tributacao/tributar/{id}/{id_assistente?}', ['as' => 'ncm.tributacao.tributar', 'uses' => 'Admin\NcmController@tributar']);
	Route::post('/ncm/tributacao/tributar/{id}/{id_assistente?}', ['as' => 'ncm.tributacao.tributar', 'uses' => 'Admin\NcmController@tributar']);
	Route::get('/ncm/destroy/{id}/{id_assistente?}', ['as' => 'ncm.destroy', 'uses' => 'Admin\NcmController@destroy']);
	Route::post('/ncm/destroy/{id}/{id_assistente?}', ['as' => 'ncm.destroy', 'uses' => 'Admin\NcmController@destroy']);

	Route::get('/pis/cofins/index/{id_assistente?}', ['as' => 'pis.cofins.index', 'uses' => 'Admin\PisCofinsController@index']);
	Route::post('/pis/cofins/index/{id_assistente?}', ['as' => 'pis.cofins.index', 'uses' => 'Admin\PisCofinsController@index']);
	Route::get('/pis/cofins/pis/create/{id_assistente?}', ['as' => 'pis.cofins.pis.create', 'uses' => 'Admin\PisCofinsController@createPis']);
	Route::post('/pis/cofins/pis/create/{id_assistente?}', ['as' => 'pis.cofins.pis.create', 'uses' => 'Admin\PisCofinsController@createPis']);
	Route::get('/pis/cofins/pis/st/create/{id_assistente?}', ['as' => 'pis.cofins.pis.st.create', 'uses' => 'Admin\PisCofinsController@createPisSt']);
	Route::post('/pis/cofins/pis/st/create/{id_assistente?}', ['as' => 'pis.cofins.pis.st.create', 'uses' => 'Admin\PisCofinsController@createPisSt']);
	Route::get('/pis/cofins/cofins/create/{id_assistente?}', ['as' => 'pis.cofins.cofins.create', 'uses' => 'Admin\PisCofinsController@createCofins']);
	Route::post('/pis/cofins/cofins/create/{id_assistente?}', ['as' => 'pis.cofins.cofins.create', 'uses' => 'Admin\PisCofinsController@createCofins']);
	Route::get('/pis/cofins/cofins/st/create/{id_assistente?}', ['as' => 'pis.cofins.cofins.st.create', 'uses' => 'Admin\PisCofinsController@createCofinsSt']);
	Route::post('/pis/cofins/cofins/st/create/{id_assistente?}', ['as' => 'pis.cofins.cofins.st.create', 'uses' => 'Admin\PisCofinsController@createCofinsSt']);
	Route::post('/pis/cofins/store/{id_assistente?}', ['as' => 'pis.cofins.store', 'uses' => 'Admin\PisCofinsController@store']);
	Route::get('/pis/cofins/edit/{id}/{id_assistente?}', ['as' => 'pis.cofins.edit', 'uses' => 'Admin\PisCofinsController@edit']);
	Route::post('/pis/cofins/edit/{id}/{id_assistente?}', ['as' => 'pis.cofins.edit', 'uses' => 'Admin\PisCofinsController@edit']);
	Route::put('/pis/cofins/update/{id}/{id_assistente?}', ['as' => 'pis.cofins.update', 'uses' => 'Admin\PisCofinsController@update']);
	Route::get('/pis/cofins/show/{id}/{id_assistente?}', ['as' => 'pis.cofins.show', 'uses' => 'Admin\PisCofinsController@show']);
	Route::post('/pis/cofins/show/{id}/{id_assistente?}', ['as' => 'pis.cofins.show', 'uses' => 'Admin\PisCofinsController@show']);
	Route::get('/pis/cofins/info/{id}/{id_assistente?}', ['as' => 'pis.cofins.info', 'uses' => 'Admin\PisCofinsController@info']);
	Route::post('/pis/cofins/info/{id}/{id_assistente?}', ['as' => 'pis.cofins.info', 'uses' => 'Admin\PisCofinsController@info']);
	Route::get('/pis/cofins/head/{id_assistente?}', ['as' => 'pis.cofins.head', 'uses' => 'Admin\PisCofinsController@head']);
	Route::post('/pis/cofins/head/{id_assistente?}', ['as' => 'pis.cofins.head', 'uses' => 'Admin\PisCofinsController@head']);
	Route::get('/pis/cofins/destroy/{id}/{id_assistente?}', ['as' => 'pis.cofins.destroy', 'uses' => 'Admin\PisCofinsController@destroy']);
	Route::post('/pis/cofins/destroy/{id}/{id_assistente?}', ['as' => 'pis.cofins.destroy', 'uses' => 'Admin\PisCofinsController@destroy']);

	Route::get('/ipi/index/{id_assistente?}', ['as' => 'ipi.index', 'uses' => 'Admin\IpiController@index']);
	Route::post('/ipi/index/{id_assistente?}', ['as' => 'ipi.index', 'uses' => 'Admin\IpiController@index']);
	Route::get('/ipi/create/{id_assistente?}', ['as' => 'ipi.create', 'uses' => 'Admin\IpiController@create']);
	Route::post('/ipi/create/{id_assistente?}', ['as' => 'ipi.create', 'uses' => 'Admin\IpiController@create']);
	Route::post('/ipi/store/{id_assistente?}', ['as' => 'ipi.store', 'uses' => 'Admin\IpiController@store']);
	Route::get('/ipi/edit/{id}/{id_assistente?}', ['as' => 'ipi.edit', 'uses' => 'Admin\IpiController@edit']);
	Route::post('/ipi/edit/{id}/{id_assistente?}', ['as' => 'ipi.edit', 'uses' => 'Admin\IpiController@edit']);
	Route::put('/ipi/update/{id}/{id_assistente?}', ['as' => 'ipi.update', 'uses' => 'Admin\IpiController@update']);
	Route::get('/ipi/show/{id}/{id_assistente?}', ['as' => 'ipi.show', 'uses' => 'Admin\IpiController@show']);
	Route::post('/ipi/show/{id}/{id_assistente?}', ['as' => 'ipi.show', 'uses' => 'Admin\IpiController@show']);
	Route::get('/ipi/info/{id}/{id_assistente?}', ['as' => 'ipi.info', 'uses' => 'Admin\IpiController@info']);
	Route::post('/ipi/info/{id}/{id_assistente?}', ['as' => 'ipi.info', 'uses' => 'Admin\IpiController@info']);
	Route::get('/ipi/head/{id_assistente?}', ['as' => 'ipi.head', 'uses' => 'Admin\IpiController@head']);
	Route::post('/ipi/head/{id_assistente?}', ['as' => 'ipi.head', 'uses' => 'Admin\IpiController@head']);
	Route::get('/ipi/destroy/{id}/{id_assistente?}', ['as' => 'ipi.destroy', 'uses' => 'Admin\IpiController@destroy']);
	Route::post('/ipi/destroy/{id}/{id_assistente?}', ['as' => 'ipi.destroy', 'uses' => 'Admin\IpiController@destroy']);

	Route::get('/icms/index/{id_assistente?}', ['as' => 'icms.index', 'uses' => 'Admin\IcmsController@index']);
	Route::post('/icms/index/{id_assistente?}', ['as' => 'icms.index', 'uses' => 'Admin\IcmsController@index']);
	Route::get('/icms/create/{id_assistente?}', ['as' => 'icms.create', 'uses' => 'Admin\IcmsController@create']);
	Route::post('/icms/create/{id_assistente?}', ['as' => 'icms.create', 'uses' => 'Admin\IcmsController@create']);
	Route::post('/icms/store/{id_assistente?}', ['as' => 'icms.store', 'uses' => 'Admin\IcmsController@store']);
	Route::get('/icms/edit/{id}/{id_assistente?}', ['as' => 'icms.edit', 'uses' => 'Admin\IcmsController@edit']);
	Route::post('/icms/edit/{id}/{id_assistente?}', ['as' => 'icms.edit', 'uses' => 'Admin\IcmsController@edit']);
	Route::put('/icms/update/{id}/{id_assistente?}', ['as' => 'icms.update', 'uses' => 'Admin\IcmsController@update']);
	Route::get('/icms/show/{id}/{id_assistente?}', ['as' => 'icms.show', 'uses' => 'Admin\IcmsController@show']);
	Route::post('/icms/show/{id}/{id_assistente?}', ['as' => 'icms.show', 'uses' => 'Admin\IcmsController@show']);
	Route::get('/icms/info/{id}/{id_assistente?}', ['as' => 'icms.info', 'uses' => 'Admin\IcmsController@info']);
	Route::post('/icms/info/{id}/{id_assistente?}', ['as' => 'icms.info', 'uses' => 'Admin\IcmsController@info']);
	Route::get('/icms/head/{id_assistente?}', ['as' => 'icms.head', 'uses' => 'Admin\IcmsController@head']);
	Route::post('/icms/head/{id_assistente?}', ['as' => 'icms.head', 'uses' => 'Admin\IcmsController@head']);
	Route::get('/icms/destroy/{id}/{id_assistente?}', ['as' => 'icms.destroy', 'uses' => 'Admin\IcmsController@destroy']);
	Route::post('/icms/destroy/{id}/{id_assistente?}', ['as' => 'icms.destroy', 'uses' => 'Admin\IcmsController@destroy']);

	Route::get('/pais/index/{id_assistente?}', ['as' => 'pais.index', 'uses' => 'Admin\PaisController@index']);
	Route::post('/pais/index/{id_assistente?}', ['as' => 'pais.index', 'uses' => 'Admin\PaisController@index']);
	Route::get('/pais/json/{id_assistente?}', ['as' => 'pais.json', 'uses' => 'Admin\PaisController@json']);
	Route::post('/pais/json/{id_assistente?}', ['as' => 'pais.json', 'uses' => 'Admin\PaisController@json']);
	Route::get('/pais/create/{id_assistente?}', ['as' => 'pais.create', 'uses' => 'Admin\PaisController@create']);
	Route::post('/pais/create/{id_assistente?}', ['as' => 'pais.create', 'uses' => 'Admin\PaisController@create']);
	Route::post('/pais/store/{id_assistente?}', ['as' => 'pais.store', 'uses' => 'Admin\PaisController@store']);
	Route::get('/pais/edit/{id}/{id_assistente?}', ['as' => 'pais.edit', 'uses' => 'Admin\PaisController@edit']);
	Route::post('/pais/edit/{id}/{id_assistente?}', ['as' => 'pais.edit', 'uses' => 'Admin\PaisController@edit']);
	Route::put('/pais/update/{id}/{id_assistente?}', ['as' => 'pais.update', 'uses' => 'Admin\PaisController@update']);
	Route::get('/pais/show/{id}/{id_assistente?}', ['as' => 'pais.show', 'uses' => 'Admin\PaisController@show']);
	Route::post('/pais/show/{id}/{id_assistente?}', ['as' => 'pais.show', 'uses' => 'Admin\PaisController@show']);
	Route::get('/pais/info/{id}/{id_assistente?}', ['as' => 'pais.info', 'uses' => 'Admin\PaisController@info']);
	Route::post('/pais/info/{id}/{id_assistente?}', ['as' => 'pais.info', 'uses' => 'Admin\PaisController@info']);
	Route::get('/pais/head/{id_assistente?}', ['as' => 'pais.head', 'uses' => 'Admin\PaisController@head']);
	Route::post('/pais/head/{id_assistente?}', ['as' => 'pais.head', 'uses' => 'Admin\PaisController@head']);
	Route::get('/pais/destroy/{id}/{id_assistente?}', ['as' => 'pais.destroy', 'uses' => 'Admin\PaisController@destroy']);
	Route::post('/pais/destroy/{id}/{id_assistente?}', ['as' => 'pais.destroy', 'uses' => 'Admin\PaisController@destroy']);

	Route::get('/estado/index/{id_assistente?}', ['as' => 'estado.index', 'uses' => 'Admin\EstadoController@index']);
	Route::post('/estado/index/{id_assistente?}', ['as' => 'estado.index', 'uses' => 'Admin\EstadoController@index']);
	Route::get('/estado/json/{id_assistente?}', ['as' => 'estado.json', 'uses' => 'Admin\EstadoController@json']);
	Route::post('/estado/json/{id_assistente?}', ['as' => 'estado.json', 'uses' => 'Admin\EstadoController@json']);
	Route::get('/estado/create/{id_assistente?}', ['as' => 'estado.create', 'uses' => 'Admin\EstadoController@create']);
	Route::post('/estado/create/{id_assistente?}', ['as' => 'estado.create', 'uses' => 'Admin\EstadoController@create']);
	Route::post('/estado/store/{id_assistente?}', ['as' => 'estado.store', 'uses' => 'Admin\EstadoController@store']);
	Route::get('/estado/edit/{id}/{id_assistente?}', ['as' => 'estado.edit', 'uses' => 'Admin\EstadoController@edit']);
	Route::post('/estado/edit/{id}/{id_assistente?}', ['as' => 'estado.edit', 'uses' => 'Admin\EstadoController@edit']);
	Route::put('/estado/update/{id}/{id_assistente?}', ['as' => 'estado.update', 'uses' => 'Admin\EstadoController@update']);
	Route::get('/estado/show/{id}/{id_assistente?}', ['as' => 'estado.show', 'uses' => 'Admin\EstadoController@show']);
	Route::post('/estado/show/{id}/{id_assistente?}', ['as' => 'estado.show', 'uses' => 'Admin\EstadoController@show']);
	Route::get('/estado/info/{id}/{id_assistente?}', ['as' => 'estado.info', 'uses' => 'Admin\EstadoController@info']);
	Route::post('/estado/info/{id}/{id_assistente?}', ['as' => 'estado.info', 'uses' => 'Admin\EstadoController@info']);
	Route::get('/estado/head/{id_assistente?}', ['as' => 'estado.head', 'uses' => 'Admin\EstadoController@head']);
	Route::post('/estado/head/{id_assistente?}', ['as' => 'estado.head', 'uses' => 'Admin\EstadoController@head']);
	Route::get('/estado/destroy/{id}/{id_assistente?}', ['as' => 'estado.destroy', 'uses' => 'Admin\EstadoController@destroy']);
	Route::post('/estado/destroy/{id}/{id_assistente?}', ['as' => 'estado.destroy', 'uses' => 'Admin\EstadoController@destroy']);

	Route::get('/cidade/index/{id_assistente?}', ['as' => 'cidade.index', 'uses' => 'Admin\V1\City\CityController@index']);
	Route::post('/cidade/index/{id_assistente?}', ['as' => 'cidade.index', 'uses' => 'Admin\V1\City\CityController@index']);
	Route::get('/cidade/json/{id_assistente?}', ['as' => 'cidade.json', 'uses' => 'Admin\V1\City\CityController@index']);
	Route::post('/cidade/json/{id_assistente?}', ['as' => 'cidade.json', 'uses' => 'Admin\V1\City\CityController@index']);
	Route::post('/cidade/store/{id_assistente?}', ['as' => 'cidade.store', 'uses' => 'Admin\V1\City\CityController@store']);
	Route::put('/cidade/update/{id}/{id_assistente?}', ['as' => 'cidade.update', 'uses' => 'Admin\V1\City\CityController@update']);
	Route::get('/cidade/show/{id}/{id_assistente?}', ['as' => 'cidade.show', 'uses' => 'Admin\V1\City\CityController@show']);
	Route::post('/cidade/show/{id}/{id_assistente?}', ['as' => 'cidade.show', 'uses' => 'Admin\V1\City\CityController@show']);
	Route::get('/cidade/info/{id}/{id_assistente?}', ['as' => 'cidade.info', 'uses' => 'Admin\V1\City\CityController@show']);
	Route::post('/cidade/info/{id}/{id_assistente?}', ['as' => 'cidade.info', 'uses' => 'Admin\V1\City\CityController@show']);
	Route::get('/cidade/destroy/{id}/{id_assistente?}', ['as' => 'cidade.destroy', 'uses' => 'Admin\V1\City\CityController@destroy']);
	Route::post('/cidade/destroy/{id}/{id_assistente?}', ['as' => 'cidade.destroy', 'uses' => 'Admin\V1\City\CityController@destroy']);

	Route::get('/bairro/index/{id_assistente?}', ['as' => 'bairro.index', 'uses' => 'Admin\BairroController@index']);
	Route::post('/bairro/index/{id_assistente?}', ['as' => 'bairro.index', 'uses' => 'Admin\BairroController@index']);
	Route::get('/bairro/create/{id_assistente?}', ['as' => 'bairro.create', 'uses' => 'Admin\BairroController@create']);
	Route::post('/bairro/create/{id_assistente?}', ['as' => 'bairro.create', 'uses' => 'Admin\BairroController@create']);
	Route::post('/bairro/store/{id_assistente?}', ['as' => 'bairro.store', 'uses' => 'Admin\BairroController@store']);
	Route::get('/bairro/edit/{id}/{id_assistente?}', ['as' => 'bairro.edit', 'uses' => 'Admin\BairroController@edit']);
	Route::post('/bairro/edit/{id}/{id_assistente?}', ['as' => 'bairro.edit', 'uses' => 'Admin\BairroController@edit']);
	Route::put('/bairro/update/{id}/{id_assistente?}', ['as' => 'bairro.update', 'uses' => 'Admin\BairroController@update']);
	Route::get('/bairro/show/{id}/{id_assistente?}', ['as' => 'bairro.show', 'uses' => 'Admin\BairroController@show']);
	Route::post('/bairro/show/{id}/{id_assistente?}', ['as' => 'bairro.show', 'uses' => 'Admin\BairroController@show']);
	Route::get('/bairro/info/{id}/{id_assistente?}', ['as' => 'bairro.info', 'uses' => 'Admin\BairroController@info']);
	Route::post('/bairro/info/{id}/{id_assistente?}', ['as' => 'bairro.info', 'uses' => 'Admin\BairroController@info']);
	Route::get('/bairro/head/{id_assistente?}', ['as' => 'bairro.head', 'uses' => 'Admin\BairroController@head']);
	Route::post('/bairro/head/{id_assistente?}', ['as' => 'bairro.head', 'uses' => 'Admin\BairroController@head']);
	Route::get('/bairro/destroy/{id}/{id_assistente?}', ['as' => 'bairro.destroy', 'uses' => 'Admin\BairroController@destroy']);
	Route::post('/bairro/destroy/{id}/{id_assistente?}', ['as' => 'bairro.destroy', 'uses' => 'Admin\BairroController@destroy']);

	Route::get('/venda/index/{id_assistente?}', ['as' => 'contrato.index', 'uses' => 'Admin\VendaController@index']); //VendaController
	Route::get('/venda/create/{id}/{id_assistente?}', ['as' => 'venda.create', 'uses' => 'Admin\VendaController@create']);
	Route::post('/venda/store/{idPessoa}/{id_assistente?}', ['as' => 'venda.store', 'uses' => 'Admin\VendaController@store']);
	Route::get('/venda/edit/{id}/{idPessoa}/{id_assistente?}', ['as' => 'venda.edit', 'uses' => 'Admin\VendaController@edit']);
	Route::put('/venda/update/{id}/{idPessoa}/{id_assistente?}', ['as' => 'venda.update', 'uses' => 'Admin\VendaController@update']);
	Route::get('/venda/show/{id}/{idPessoa}/{id_assistente?}', ['as' => 'venda.show', 'uses' => 'Admin\VendaController@show']);
	Route::get('/venda/info/{id}/{idPessoa}/{id_assistente?}', ['as' => 'venda.info', 'uses' => 'Admin\VendaController@info']);
	Route::get('/venda/head/{id_assistente?}', ['as' => 'venda.head', 'uses' => 'Admin\VendaController@head']);
	Route::get('/venda/destroy/{id}/{idPessoa}/{id_assistente?}', ['as' => 'venda.destroy', 'uses' => 'Admin\VendaController@destroy']);
	Route::get('/venda/pdv/{id_assistente?}', ['as' => 'venda.pdv', 'uses' => 'Admin\VendaController@pdv']);

	Route::get('/receber/index/{id_assistente?}', ['as' => 'receber.index', 'uses' => 'Admin\V1\AccountReceivable\AccountReceivableController@index']);
	Route::post('/receber/index/{id_assistente?}', ['as' => 'receber.index', 'uses' => 'Admin\V1\AccountReceivable\AccountReceivableController@index']);
	Route::get('/receber/json/{id_assistente?}', ['as' => 'receber.json', 'uses' => 'Admin\V1\AccountReceivable\AccountReceivableController@index']);
	Route::post('/receber/json/{id_assistente?}', ['as' => 'receber.json', 'uses' => 'Admin\V1\AccountReceivable\AccountReceivableController@index']);
	Route::post('/receber/store/{id_assistente?}', ['as' => 'receber.store', 'uses' => 'Admin\V1\AccountReceivable\AccountReceivableController@store']);
	Route::put('/receber/update/{id}/{id_assistente?}', ['as' => 'receber.update', 'uses' => 'Admin\V1\AccountReceivable\AccountReceivableController@update']);
	Route::get('/receber/show/{id}/{id_assistente?}', ['as' => 'receber.show', 'uses' => 'Admin\V1\AccountReceivable\AccountReceivableController@show']);
	Route::post('/receber/show/{id}/{id_assistente?}', ['as' => 'receber.show', 'uses' => 'Admin\V1\AccountReceivable\AccountReceivableController@show']);
	Route::get('/receber/info/{id}/{id_assistente?}', ['as' => 'receber.info', 'uses' => 'Admin\V1\AccountReceivable\AccountReceivableController@show']);
	Route::post('/receber/info/{id}/{id_assistente?}', ['as' => 'receber.info', 'uses' => 'Admin\V1\AccountReceivable\AccountReceivableController@show']);
	Route::get('/receber/destroy/{id}/{id_assistente?}', ['as' => 'receber.destroy', 'uses' => 'Admin\V1\AccountReceivable\AccountReceivableController@destroy']);
	Route::post('/receber/destroy/{id}/{id_assistente?}', ['as' => 'receber.destroy', 'uses' => 'Admin\V1\AccountReceivable\AccountReceivableController@destroy']);
	Route::post('/receber/baixar/{id}/{id_assistente?}', ['as' => 'receber.baixar', 'uses' => 'Admin\V1\AccountReceivable\AccountReceivableController@payOff']);

	Route::get('/receber/item/index/{id_assistente?}', ['as' => 'receber.item.index', 'uses' => 'Admin\V1\AccountReceivableItem\AccountReceivableItemController@index']);
	Route::post('/receber/item/index/{id_assistente?}', ['as' => 'receber.item.index', 'uses' => 'Admin\V1\AccountReceivableItem\AccountReceivableItemController@index']);
	Route::get('/receber/item/json/{id_assistente?}', ['as' => 'receber.item.json', 'uses' => 'Admin\V1\AccountReceivableItem\AccountReceivableItemController@index']);
	Route::post('/receber/item/json/{id_assistente?}', ['as' => 'receber.item.json', 'uses' => 'Admin\V1\AccountReceivableItem\AccountReceivableItemController@index']);
	Route::post('/receber/item/store/{id_assistente?}', ['as' => 'receber.item.store', 'uses' => 'Admin\V1\AccountReceivableItem\AccountReceivableItemController@store']);
	Route::put('/receber/item/update/{id}/{id_assistente?}', ['as' => 'receber.item.update', 'uses' => 'Admin\V1\AccountReceivableItem\AccountReceivableItemController@update']);
	Route::get('/receber/item/show/{id}/{id_assistente?}', ['as' => 'receber.item.show', 'uses' => 'Admin\V1\AccountReceivableItem\AccountReceivableItemController@show']);
	Route::post('/receber/item/show/{id}/{id_assistente?}', ['as' => 'receber.item.show', 'uses' => 'Admin\V1\AccountReceivableItem\AccountReceivableItemController@show']);
	Route::get('/receber/item/info/{id}/{id_assistente?}', ['as' => 'receber.item.info', 'uses' => 'Admin\V1\AccountReceivableItem\AccountReceivableItemController@show']);
	Route::post('/receber/item/info/{id}/{id_assistente?}', ['as' => 'receber.item.info', 'uses' => 'Admin\V1\AccountReceivableItem\AccountReceivableItemController@show']);
	Route::get('/receber/item/destroy/{id}/{id_assistente?}', ['as' => 'receber.item.destroy', 'uses' => 'Admin\V1\AccountReceivableItem\AccountReceivableItemController@destroy']);
	Route::post('/receber/item/destroy/{id}/{id_assistente?}', ['as' => 'receber.item.destroy', 'uses' => 'Admin\V1\AccountReceivableItem\AccountReceivableItemController@destroy']);
	Route::put('/receber/item/baixar/{id}/{id_assistente?}', ['as' => 'receber.item.baixar', 'uses' => 'Admin\V1\AccountReceivableItem\AccountReceivableItemController@baixar']);

	Route::get('/financeiro/movimentacoes/index/{id_assistente?}', ['as' => 'financeiro.movimentacoes.index', 'uses' => 'Admin\MovimentacoesFinanceirasController@index']);
	Route::post('/financeiro/movimentacoes/index/{id_assistente?}', ['as' => 'financeiro.movimentacoes.index', 'uses' => 'Admin\MovimentacoesFinanceirasController@index']);
	Route::get('/financeiro/movimentacoes/json/{id_assistente?}', ['as' => 'financeiro.movimentacoes.json', 'uses' => 'Admin\MovimentacoesFinanceirasController@json']);
	Route::post('/financeiro/movimentacoes/json/{id_assistente?}', ['as' => 'financeiro.movimentacoes.json', 'uses' => 'Admin\MovimentacoesFinanceirasController@json']);
	Route::get('/financeiro/movimentacoes/create/{id_assistente?}', ['as' => 'financeiro.movimentacoes.create', 'uses' => 'Admin\MovimentacoesFinanceirasController@create']);
	Route::post('/financeiro/movimentacoes/create/{id_assistente?}', ['as' => 'financeiro.movimentacoes.create', 'uses' => 'Admin\MovimentacoesFinanceirasController@create']);
	Route::post('/financeiro/movimentacoes/store/{id_assistente?}', ['as' => 'financeiro.movimentacoes.store', 'uses' => 'Admin\MovimentacoesFinanceirasController@store']);
	Route::get('/financeiro/movimentacoes/edit/{id}/{id_assistente?}', ['as' => 'financeiro.movimentacoes.edit', 'uses' => 'Admin\MovimentacoesFinanceirasController@edit']);
	Route::post('/financeiro/movimentacoes/edit/{id}/{id_assistente?}', ['as' => 'financeiro.movimentacoes.edit', 'uses' => 'Admin\MovimentacoesFinanceirasController@edit']);
	Route::put('/financeiro/movimentacoes/update/{id}/{id_assistente?}', ['as' => 'financeiro.movimentacoes.update', 'uses' => 'Admin\MovimentacoesFinanceirasController@update']);
	Route::get('/financeiro/movimentacoes/show/{id}/{id_assistente?}', ['as' => 'financeiro.movimentacoes.show', 'uses' => 'Admin\MovimentacoesFinanceirasController@show']);
	Route::post('/financeiro/movimentacoes/show/{id}/{id_assistente?}', ['as' => 'financeiro.movimentacoes.show', 'uses' => 'Admin\MovimentacoesFinanceirasController@show']);
	Route::get('/financeiro/movimentacoes/info/{id}/{id_assistente?}', ['as' => 'financeiro.movimentacoes.info', 'uses' => 'Admin\MovimentacoesFinanceirasController@info']);
	Route::post('/financeiro/movimentacoes/info/{id}/{id_assistente?}', ['as' => 'financeiro.movimentacoes.info', 'uses' => 'Admin\MovimentacoesFinanceirasController@info']);
	Route::get('/financeiro/movimentacoes/head/{id_assistente?}', ['as' => 'financeiro.movimentacoes.head', 'uses' => 'Admin\MovimentacoesFinanceirasController@head']);
	Route::post('/financeiro/movimentacoes/head/{id_assistente?}', ['as' => 'financeiro.movimentacoes.head', 'uses' => 'Admin\MovimentacoesFinanceirasController@head']);
	Route::get('/financeiro/movimentacoes/destroy/{id}/{id_assistente?}', ['as' => 'financeiro.movimentacoes.destroy', 'uses' => 'Admin\MovimentacoesFinanceirasController@destroy']);
	Route::post('/financeiro/movimentacoes/destroy/{id}/{id_assistente?}', ['as' => 'financeiro.movimentacoes.destroy', 'uses' => 'Admin\MovimentacoesFinanceirasController@destroy']);

	Route::get('/caixa/index/{id_assistente?}', ['as' => 'caixa.index', 'uses' => 'Admin\V1\Cashier\CashierController@index']);
	Route::post('/caixa/index/{id_assistente?}', ['as' => 'caixa.index', 'uses' => 'Admin\V1\Cashier\CashierController@index']);
	Route::get('/caixa/json/{id_assistente?}', ['as' => 'caixa.json', 'uses' => 'Admin\V1\Cashier\CashierController@index']);
	Route::post('/caixa/json/{id_assistente?}', ['as' => 'caixa.json', 'uses' => 'Admin\V1\Cashier\CashierController@index']);
	Route::post('/caixa/store/{id_assistente?}', ['as' => 'caixa.store', 'uses' => 'Admin\V1\Cashier\CashierController@store']);
	Route::put('/caixa/update/{id}/{id_assistente?}', ['as' => 'caixa.update', 'uses' => 'Admin\V1\Cashier\CashierController@update']);
	Route::get('/caixa/show/{id}/{id_assistente?}', ['as' => 'caixa.show', 'uses' => 'Admin\V1\Cashier\CashierController@show']);
	Route::post('/caixa/show/{id}/{id_assistente?}', ['as' => 'caixa.show', 'uses' => 'Admin\V1\Cashier\CashierController@show']);
	Route::get('/caixa/info/{id}/{id_assistente?}', ['as' => 'caixa.info', 'uses' => 'Admin\V1\Cashier\CashierController@show']);
	Route::post('/caixa/show/{id}/{id_assistente?}', ['as' => 'caixa.info', 'uses' => 'Admin\V1\Cashier\CashierController@show']);
	Route::get('/caixa/destroy/{id}/{id_assistente?}', ['as' => 'caixa.destroy', 'uses' => 'Admin\V1\Cashier\CashierController@destroy']);
	Route::post('/caixa/destroy/{id}/{id_assistente?}', ['as' => 'caixa.destroy', 'uses' => 'Admin\V1\Cashier\CashierController@destroy']);

	Route::get('/categoria_conta/index/{id_assistente?}', ['as' => 'categoria_conta.index', 'uses' => 'Admin\CategoriaContaController@index']);
	Route::post('/categoria_conta/index/{id_assistente?}', ['as' => 'categoria_conta.index', 'uses' => 'Admin\CategoriaContaController@index']);
	Route::get('/categoria_conta/json/{id_assistente?}', ['as' => 'categoria_conta.json', 'uses' => 'Admin\CategoriaContaController@json']);
	Route::post('/categoria_conta/json/{id_assistente?}', ['as' => 'categoria_conta.json', 'uses' => 'Admin\CategoriaContaController@json']);
	Route::get('/categoria_conta/create/{id_assistente?}', ['as' => 'categoria_conta.create', 'uses' => 'Admin\CategoriaContaController@create']);
	Route::post('/categoria_conta/create/{id_assistente?}', ['as' => 'categoria_conta.create', 'uses' => 'Admin\CategoriaContaController@create']);
	Route::post('/categoria_conta/store/{id_assistente?}', ['as' => 'categoria_conta.store', 'uses' => 'Admin\CategoriaContaController@store']);
	Route::get('/categoria_conta/edit/{id}/{id_assistente?}', ['as' => 'categoria_conta.edit', 'uses' => 'Admin\CategoriaContaController@edit']);
	Route::post('/categoria_conta/edit/{id}/{id_assistente?}', ['as' => 'categoria_conta.edit', 'uses' => 'Admin\CategoriaContaController@edit']);
	Route::put('/categoria_conta/update/{id}/{id_assistente?}', ['as' => 'categoria_conta.update', 'uses' => 'Admin\CategoriaContaController@update']);
	Route::get('/categoria_conta/show/{id}/{id_assistente?}', ['as' => 'categoria_conta.show', 'uses' => 'Admin\CategoriaContaController@show']);
	Route::post('/categoria_conta/show/{id}/{id_assistente?}', ['as' => 'categoria_conta.show', 'uses' => 'Admin\CategoriaContaController@show']);
	Route::get('/categoria_conta/info/{id}/{id_assistente?}', ['as' => 'categoria_conta.info', 'uses' => 'Admin\CategoriaContaController@info']);
	Route::post('/categoria_conta/info/{id}/{id_assistente?}', ['as' => 'categoria_conta.info', 'uses' => 'Admin\CategoriaContaController@info']);
	Route::get('/categoria_conta/head/{id_assistente?}', ['as' => 'categoria_conta.head', 'uses' => 'Admin\CategoriaContaController@head']);
	Route::post('/categoria_conta/head/{id_assistente?}', ['as' => 'categoria_conta.head', 'uses' => 'Admin\CategoriaContaController@head']);
	Route::get('/categoria_conta/destroy/{id}/{id_assistente?}', ['as' => 'categoria_conta.destroy', 'uses' => 'Admin\CategoriaContaController@destroy']);
	Route::post('/categoria_conta/destroy/{id}/{id_assistente?}', ['as' => 'categoria_conta.destroy', 'uses' => 'Admin\CategoriaContaController@destroy']);

	Route::get('/conta/index/{id_assistente?}', ['as' => 'conta.index', 'uses' => 'Admin\ContaController@index']);
	Route::post('/conta/index/{id_assistente?}', ['as' => 'conta.index', 'uses' => 'Admin\ContaController@index']);
	Route::get('/conta/json/{id_assistente?}', ['as' => 'conta.json', 'uses' => 'Admin\ContaController@json']);
	Route::post('/conta/json/{id_assistente?}', ['as' => 'conta.json', 'uses' => 'Admin\ContaController@json']);
	Route::get('/conta/create/{id_assistente?}', ['as' => 'conta.create', 'uses' => 'Admin\ContaController@create']);
	Route::post('/conta/create/{id_assistente?}', ['as' => 'conta.create', 'uses' => 'Admin\ContaController@create']);
	Route::post('/conta/store/{id_assistente?}', ['as' => 'conta.store', 'uses' => 'Admin\ContaController@store']);
	Route::get('/conta/edit/{id}/{id_assistente?}', ['as' => 'conta.edit', 'uses' => 'Admin\ContaController@edit']);
	Route::post('/conta/edit/{id}/{id_assistente?}', ['as' => 'conta.edit', 'uses' => 'Admin\ContaController@edit']);
	Route::put('/conta/update/{id}/{id_assistente?}', ['as' => 'conta.update', 'uses' => 'Admin\ContaController@update']);
	Route::get('/conta/show/{id}/{id_assistente?}', ['as' => 'conta.show', 'uses' => 'Admin\ContaController@show']);
	Route::post('/conta/show/{id}/{id_assistente?}', ['as' => 'conta.show', 'uses' => 'Admin\ContaController@show']);
	Route::get('/conta/info/{id}/{id_assistente?}', ['as' => 'conta.info', 'uses' => 'Admin\ContaController@info']);
	Route::post('/conta/info/{id}/{id_assistente?}', ['as' => 'conta.info', 'uses' => 'Admin\ContaController@info']);
	Route::get('/conta/head/{id_assistente?}', ['as' => 'conta.head', 'uses' => 'Admin\ContaController@head']);
	Route::post('/conta/head/{id_assistente?}', ['as' => 'conta.head', 'uses' => 'Admin\ContaController@head']);
	Route::get('/conta/destroy/{id}/{id_assistente?}', ['as' => 'conta.destroy', 'uses' => 'Admin\ContaController@destroy']);
	Route::post('/conta/destroy/{id}/{id_assistente?}', ['as' => 'conta.destroy', 'uses' => 'Admin\ContaController@destroy']);

	Route::get('/atendimento/json', ['as' => 'atendimento.json', 'uses' => 'Admin\AtendimentoController@json']);
	Route::post('/atendimento/json', ['as' => 'atendimento.json', 'uses' => 'Admin\AtendimentoController@json']);
	Route::post('/atendimento/store', ['as' => 'atendimento.store', 'uses' => 'Admin\AtendimentoController@store']);
	Route::get('/atendimento/edit/{id}', ['as' => 'atendimento.edit', 'uses' => 'Admin\AtendimentoController@edit']);
	Route::post('/atendimento/edit/{id}', ['as' => 'atendimento.edit', 'uses' => 'Admin\AtendimentoController@edit']);
	Route::put('/atendimento/update/{id}', ['as' => 'atendimento.update', 'uses' => 'Admin\AtendimentoController@update']);
	Route::get('/atendimento/info/{id}', ['as' => 'atendimento.info', 'uses' => 'Admin\AtendimentoController@info']);
	Route::post('/atendimento/info/{id}', ['as' => 'atendimento.info', 'uses' => 'Admin\AtendimentoController@info']);
	Route::get('/atendimento/destroy/{id}', ['as' => 'atendimento/destroy', 'uses' => 'Admin\AtendimentoController@destroy']);
	Route::put('/atendimento/cancelar/{id}', ['as' => 'atendimento.cancelar', 'uses' => 'Admin\AtendimentoController@cancelar']);

	Route::get('/formulario/json', ['as' => 'formulario.json', 'uses' => 'Admin\FormularioController@json']);
	Route::post('/formulario/json', ['as' => 'formulario.json', 'uses' => 'Admin\FormularioController@json']);
	Route::post('/formulario/store', ['as' => 'formulario.store', 'uses' => 'Admin\FormularioController@store']);
	Route::get('/formulario/edit/{id}', ['as' => 'formulario.edit', 'uses' => 'Admin\FormularioController@edit']);
	Route::post('/formulario/edit/{id}', ['as' => 'formulario.edit', 'uses' => 'Admin\FormularioController@edit']);
	Route::put('/formulario/update/{id}', ['as' => 'formulario.update', 'uses' => 'Admin\FormularioController@update']);
	Route::get('/formulario/info/{id}', ['as' => 'formulario.info', 'uses' => 'Admin\FormularioController@info']);
	Route::post('/formulario/info/{id}', ['as' => 'formulario.info', 'uses' => 'Admin\FormularioController@info']);
	Route::get('/formulario/destroy/{id}', ['as' => 'formulario/destroy', 'uses' => 'Admin\FormularioController@destroy']);

	Route::get('/formulario/grupo/json', ['as' => 'formulario.grupo.json', 'uses' => 'Admin\FormularioGrupoController@json']);
	Route::post('/formulario/grupo/json', ['as' => 'formulario.grupo.json', 'uses' => 'Admin\FormularioGrupoController@json']);
	Route::post('/formulario/grupo/store', ['as' => 'formulario.grupo.store', 'uses' => 'Admin\FormularioGrupoController@store']);
	Route::get('/formulario/grupo/edit/{id}', ['as' => 'formulario.grupo.edit', 'uses' => 'Admin\FormularioGrupoController@edit']);
	Route::post('/formulario/grupo/edit/{id}', ['as' => 'formulario.grupo.edit', 'uses' => 'Admin\FormularioGrupoController@edit']);
	Route::put('/formulario/grupo/update/{id}', ['as' => 'formulario.grupo.update', 'uses' => 'Admin\FormularioGrupoController@update']);
	Route::get('/formulario/grupo/info/{id}', ['as' => 'formulario.grupo.info', 'uses' => 'Admin\FormularioGrupoController@info']);
	Route::post('/formulario/grupo/info/{id}', ['as' => 'formulario.grupo.info', 'uses' => 'Admin\FormularioGrupoController@info']);
	Route::get('/formulario/grupo/destroy/{id}', ['as' => 'formulario.grupo.destroy', 'uses' => 'Admin\FormularioGrupoController@destroy']);

	Route::get('/formulario/item/json', ['as' => 'formulario.item.json', 'uses' => 'Admin\FormularioItenController@json']);
	Route::post('/formulario/item/json', ['as' => 'formulario.item.json', 'uses' => 'Admin\FormularioItenController@json']);
	Route::post('/formulario/item/store', ['as' => 'formulario.item.store', 'uses' => 'Admin\FormularioItenController@store']);
	Route::get('/formulario/item/edit/{id}', ['as' => 'formulario.item.edit', 'uses' => 'Admin\FormularioItenController@edit']);
	Route::post('/formulario/item/edit/{id}', ['as' => 'formulario.item.edit', 'uses' => 'Admin\FormularioItenController@edit']);
	Route::put('/formulario/item/update/{id}', ['as' => 'formulario.item.update', 'uses' => 'Admin\FormularioItenController@update']);
	Route::get('/formulario/item/info/{id}', ['as' => 'formulario.item.info', 'uses' => 'Admin\FormularioItenController@info']);
	Route::post('/formulario/item/info/{id}', ['as' => 'formulario.item.info', 'uses' => 'Admin\FormularioItenController@info']);
	Route::get('/formulario/item/destroy/{id}', ['as' => 'formulario.item.destroy', 'uses' => 'Admin\FormularioItenController@destroy']);

	Route::get('/formulario/pessoa/json', ['as' => 'formulario.pessoa.json', 'uses' => 'Admin\PessoaFichaController@json']);
	Route::post('/formulario/pessoa/json', ['as' => 'formulario.pessoa.json', 'uses' => 'Admin\PessoaFichaController@json']);
	Route::post('/formulario/pessoa/store', ['as' => 'formulario.pessoa.store', 'uses' => 'Admin\PessoaFichaController@store']);
	Route::get('/formulario/pessoa/edit/{id}', ['as' => 'formulario.pessoa.edit', 'uses' => 'Admin\PessoaFichaController@edit']);
	Route::post('/formulario/pessoa/edit/{id}', ['as' => 'formulario.pessoa.edit', 'uses' => 'Admin\PessoaFichaController@edit']);
	Route::put('/formulario/pessoa/update/{id}', ['as' => 'formulario.pessoa.update', 'uses' => 'Admin\PessoaFichaController@update']);
	Route::get('/formulario/pessoa/info/{id}', ['as' => 'formulario.pessoa.info', 'uses' => 'Admin\PessoaFichaController@info']);
	Route::post('/formulario/pessoa/info/{id}', ['as' => 'formulario.pessoa.info', 'uses' => 'Admin\PessoaFichaController@info']);
	Route::get('/formulario/pessoa/destroy/{id}', ['as' => 'formulario.pessoa.destroy', 'uses' => 'Admin\PessoaFichaController@destroy']);

	Route::get('/agenda/json', ['as' => 'agenda.json', 'uses' => 'Admin\AgendaController@json']);
	Route::post('/agenda/json', ['as' => 'agenda.json', 'uses' => 'Admin\AgendaController@json']);
	Route::post('/agenda/store', ['as' => 'agenda.store', 'uses' => 'Admin\AgendaController@store']);
	Route::get('/agenda/edit/{id}', ['as' => 'agenda.edit', 'uses' => 'Admin\AgendaController@edit']);
	Route::post('/agenda/edit/{id}', ['as' => 'agenda.edit', 'uses' => 'Admin\AgendaController@edit']);
	Route::put('/agenda/update/{id}', ['as' => 'agenda.update', 'uses' => 'Admin\AgendaController@update']);
	Route::get('/agenda/info/{id}', ['as' => 'agenda.info', 'uses' => 'Admin\AgendaController@info']);
	Route::post('/agenda/info/{id}', ['as' => 'agenda.info', 'uses' => 'Admin\AgendaController@info']);
	Route::get('/agenda/destroy/{id}', ['as' => 'agenda.destroy', 'uses' => 'Admin\AgendaController@destroy']);

	Route::get('/servico/json', ['as' => 'servico.json', 'uses' => 'Admin\ServicoController@json']);
	Route::post('/servico/json', ['as' => 'servico.json', 'uses' => 'Admin\ServicoController@json']);
	Route::post('/servico/store', ['as' => 'servico.store', 'uses' => 'Admin\ServicoController@store']);
	Route::get('/servico/edit/{id}', ['as' => 'servico.edit', 'uses' => 'Admin\ServicoController@edit']);
	Route::post('/servico/edit/{id}', ['as' => 'servico.edit', 'uses' => 'Admin\ServicoController@edit']);
	Route::put('/servico/update/{id}', ['as' => 'servico.update', 'uses' => 'Admin\ServicoController@update']);
	Route::get('/servico/info/{id}', ['as' => 'servico.info', 'uses' => 'Admin\ServicoController@info']);
	Route::post('/servico/info/{id}', ['as' => 'servico.info', 'uses' => 'Admin\ServicoController@info']);
	Route::get('/servico/destroy/{id}', ['as' => 'servico.destroy', 'uses' => 'Admin\ServicoController@destroy']);

	Route::get('/ordem/servico/json', ['as' => 'ordem.servico.json', 'uses' => 'Admin\OrdemServicoController@json']);
	Route::post('/ordem/servico/json', ['as' => 'ordem.servico.json', 'uses' => 'Admin\OrdemServicoController@json']);
	Route::post('/ordem/servico/store', ['as' => 'ordem.servico.store', 'uses' => 'Admin\OrdemServicoController@store']);
	Route::get('/ordem/servico/edit/{id}', ['as' => 'ordem.servico.edit', 'uses' => 'Admin\OrdemServicoController@edit']);
	Route::post('/ordem/servico/edit/{id}', ['as' => 'ordem.servico.edit', 'uses' => 'Admin\OrdemServicoController@edit']);
	Route::put('/ordem/servico/update/{id}', ['as' => 'ordem.servico.update', 'uses' => 'Admin\OrdemServicoController@update']);
	Route::put('/ordem/servico/adicionar/item/{id}', ['as' => 'ordem.servico.adicionar.item', 'uses' => 'Admin\OrdemServicoController@adicionarItem']);
	Route::put('/ordem/servico/remover/item/{id}', ['as' => 'ordem.servico.remover.item', 'uses' => 'Admin\OrdemServicoController@removerItem']);
	Route::get('/ordem/servico/info/{id}', ['as' => 'ordem.servico.info', 'uses' => 'Admin\OrdemServicoController@info']);
	Route::post('/ordem/servico/info/{id}', ['as' => 'ordem.servico.info', 'uses' => 'Admin\OrdemServicoController@info']);
	Route::get('/ordem/servico/destroy/{id}', ['as' => 'ordem.servico.destroy', 'uses' => 'Admin\OrdemServicoController@destroy']);
	Route::put('/ordem/servico/finalizar/{id}', ['as' => 'ordem.servico.finalizar', 'uses' => 'Admin\OrdemServicoController@finalizar']);
	Route::put('/ordem/servico/cancelar/{id}', ['as' => 'ordem.servico.cancelar', 'uses' => 'Admin\OrdemServicoController@cancelar']);
	Route::put('/ordem/servico/finalizar/procedimento/{id}', ['as' => 'ordem.servico.finalizar.procedimento', 'uses' => 'Admin\OrdemServicoController@finalizarProcedimento']);


	Route::get('/ordem/servico/item/json', ['as' => 'ordem.servico.item.json', 'uses' => 'Admin\ServicoItemController@json']);
	Route::post('/ordem/servico/item/json', ['as' => 'ordem.servico.item.json', 'uses' => 'Admin\ServicoItemController@json']);
	Route::post('/ordem/servico/item/store', ['as' => 'ordem.servico.item.store', 'uses' => 'Admin\ServicoItemController@store']);
	Route::get('/ordem/servico/item/edit/{id}', ['as' => 'ordem.servico.item.edit', 'uses' => 'Admin\ServicoItemController@edit']);
	Route::post('/ordem/servico/item/edit/{id}', ['as' => 'ordem.servico.item.edit', 'uses' => 'Admin\ServicoItemController@edit']);
	Route::put('/ordem/servico/item/update/{id}', ['as' => 'ordem.servico.item.update', 'uses' => 'Admin\ServicoItemController@update']);
	Route::get('/ordem/servico/item/info/{id}', ['as' => 'ordem.servico.item.info', 'uses' => 'Admin\ServicoItemController@info']);
	Route::post('/ordem/servico/item/info/{id}', ['as' => 'ordem.servico.item.info', 'uses' => 'Admin\ServicoItemController@info']);
	Route::get('/ordem/servico/item/destroy/{id}', ['as' => 'ordem.servico.item.destroy', 'uses' => 'Admin\ServicoItemController@destroy']);

	Route::get('/rca/json', ['as' => 'rca.json', 'uses' => 'Admin\RcaController@json']);
	Route::post('/rca/json', ['as' => 'rca.json', 'uses' => 'Admin\RcaController@json']);
	Route::post('/rca/store', ['as' => 'rca.store', 'uses' => 'Admin\RcaController@store']);
	Route::get('/rca/edit/{id}', ['as' => 'rca.edit', 'uses' => 'Admin\RcaController@edit']);
	Route::post('/rca/edit/{id}', ['as' => 'rca.edit', 'uses' => 'Admin\RcaController@edit']);
	Route::put('/rca/update/{id}', ['as' => 'rca.update', 'uses' => 'Admin\RcaController@update']);
	Route::get('/rca/info/{id}', ['as' => 'rca.info', 'uses' => 'Admin\RcaController@info']);
	Route::post('/rca/info/{id}', ['as' => 'rca.info', 'uses' => 'Admin\RcaController@info']);
	Route::get('/rca/destroy/{id}', ['as' => 'rca.destroy', 'uses' => 'Admin\RcaController@destroy']);

	Route::get('/ordem/servico/cobranca/json', ['as' => 'ordem.servico.cobranca.json', 'uses' => 'Admin\OrdemServicoCobrancaController@json']);
	Route::post('/ordem/servico/cobranca/json', ['as' => 'ordem.servico.cobranca.json', 'uses' => 'Admin\OrdemServicoCobrancaController@json']);
	Route::post('/ordem/servico/cobranca/store', ['as' => 'ordem.servico.cobranca.store', 'uses' => 'Admin\OrdemServicoCobrancaController@store']);
	Route::get('/ordem/servico/cobranca/edit/{id}', ['as' => 'ordem.servico.cobranca.edit', 'uses' => 'Admin\OrdemServicoCobrancaController@edit']);
	Route::post('/ordem/servico/cobranca/edit/{id}', ['as' => 'ordem.servico.cobranca.edit', 'uses' => 'Admin\OrdemServicoCobrancaController@edit']);
	Route::put('/ordem/servico/cobranca/update/{id}', ['as' => 'ordem.servico.cobranca.update', 'uses' => 'Admin\OrdemServicoCobrancaController@update']);
	Route::get('/ordem/servico/cobranca/info/{id}', ['as' => 'ordem.servico.cobranca.info', 'uses' => 'Admin\OrdemServicoCobrancaController@info']);
	Route::post('/ordem/servico/cobranca/info/{id}', ['as' => 'ordem.servico.cobranca.info', 'uses' => 'Admin\OrdemServicoCobrancaController@info']);
	Route::get('/ordem/servico/cobranca/destroy/{id}', ['as' => 'ordem.servico.cobranca.destroy', 'uses' => 'Admin\OrdemServicoCobrancaController@destroy']);

	Route::get('/motivo/cancelamento/ordem/servico/json', ['as' => 'motivo.cancelamento.ordem.servico.json', 'uses' => 'Admin\MotivoCancelamentoOrdemServicoController@json']);
	Route::post('/motivo/cancelamento/ordem/servico/json', ['as' => 'motivo.cancelamento.ordem.servico.json', 'uses' => 'Admin\MotivoCancelamentoOrdemServicoController@json']);
	Route::post('/motivo/cancelamento/ordem/servico/store', ['as' => 'motivo.cancelamento.ordem.servico.store', 'uses' => 'Admin\MotivoCancelamentoOrdemServicoController@store']);
	Route::get('/motivo/cancelamento/ordem/servico/edit/{id}', ['as' => 'motivo.cancelamento.ordem.servico.edit', 'uses' => 'Admin\MotivoCancelamentoOrdemServicoController@edit']);
	Route::post('/motivo/cancelamento/ordem/servico/edit/{id}', ['as' => 'motivo.cancelamento.ordem.servico.edit', 'uses' => 'Admin\MotivoCancelamentoOrdemServicoController@edit']);
	Route::put('/motivo/cancelamento/ordem/servico/update/{id}', ['as' => 'motivo.cancelamento.ordem.servico.update', 'uses' => 'Admin\MotivoCancelamentoOrdemServicoController@update']);
	Route::get('/motivo/cancelamento/ordem/servico/info/{id}', ['as' => 'motivo.cancelamento.ordem.servico.info', 'uses' => 'Admin\MotivoCancelamentoOrdemServicoController@info']);
	Route::post('/motivo/cancelamento/ordem/servico/info/{id}', ['as' => 'motivo.cancelamento.ordem.servico.info', 'uses' => 'Admin\MotivoCancelamentoOrdemServicoController@info']);
	Route::get('/motivo/cancelamento/ordem/servico/destroy/{id}', ['as' => 'motivo.cancelamento.ordem.servico.destroy', 'uses' => 'Admin\MotivoCancelamentoOrdemServicoController@destroy']);

	Route::get('/notification/json', ['as' => 'notification.json', 'uses' => 'Admin\NotificationController@json']);
	Route::post('/notification/json', ['as' => 'notification.json', 'uses' => 'Admin\NotificationController@json']);
	Route::post('/notification/store', ['as' => 'notification.store', 'uses' => 'Admin\NotificationController@store']);
	Route::get('/notification/edit/{id}', ['as' => 'notification.edit', 'uses' => 'Admin\NotificationController@edit']);
	Route::post('/notification/edit/{id}', ['as' => 'notification.edit', 'uses' => 'Admin\NotificationController@edit']);
	Route::put('/notification/update/{id}', ['as' => 'notification.update', 'uses' => 'Admin\NotificationController@update']);
	Route::get('/notification/info/{id}', ['as' => 'notification.info', 'uses' => 'Admin\NotificationController@info']);
	Route::post('/notification/info/{id}', ['as' => 'notification.info', 'uses' => 'Admin\NotificationController@info']);
	Route::get('/notification/destroy/{id}', ['as' => 'notification.destroy', 'uses' => 'Admin\NotificationController@destroy']);
	Route::post('/notification/email/store', ['as' => 'notification.email.store', 'uses' => 'Admin\NotificationController@emailStore']);
	Route::post('/notification/whatsapp/store', ['as' => 'notification.whatsapp.store', 'uses' => 'Admin\NotificationController@whatsAppStore']);

	Route::get('/widget/faturamento/liquidez/mes_ano/json/{widget?}', ['as' => 'widget.faturamento.liquidez.mes_ano.json', 'uses' => 'Admin\WidgetController@faturamentoLiquidezAgrupadoMesAnoWidgetJson']);
	Route::post('/widget/faturamento/liquidez/mes_ano/json/{widget?}', ['as' => 'widget.faturamento.liquidez.mes_ano.json', 'uses' => 'Admin\WidgetController@faturamentoLiquidezAgrupadoMesAnoWidgetJson']);

	Route::get('/widget/faturamento/liquidez/filial/json/{widget?}', ['as' => 'widget.faturamento.liquidez.filial.json', 'uses' => 'Admin\WidgetController@faturamentoLiquidezAgrupadoFilialWidgetJson']);
	Route::post('/widget/faturamento/liquidez/filial/json/{widget?}', ['as' => 'widget.faturamento.liquidez.filial.json', 'uses' => 'Admin\WidgetController@faturamentoLiquidezAgrupadoFilialWidgetJson']);

	Route::get('/widget/faturamento/liquidez/profissional/json/{widget?}', ['as' => 'widget.faturamento.liquidez.profissional.json', 'uses' => 'Admin\WidgetController@faturamentoLiquidezAgrupadoProfissionalWidgetJson']);
	Route::post('/widget/faturamento/liquidez/profissional/json/{widget?}', ['as' => 'widget.faturamento.liquidez.profissional.json', 'uses' => 'Admin\WidgetController@faturamentoLiquidezAgrupadoProfissionalWidgetJson']);

	Route::get('/widget/atendimento/qtd/json/{widget?}', ['as' => 'widget.atendimento.qtd.json', 'uses' => 'Admin\WidgetController@atendimentosPorTipoWidgetJson']);
	Route::post('/widget/atendimento/qtd/json/{widget?}', ['as' => 'widget.atendimento.qtd.json', 'uses' => 'Admin\WidgetController@atendimentosPorTipoWidgetJson']);

	Route::get('/parametro/json', ['as' => 'parametro.json', 'uses' => 'Admin\ParametroController@json']);
	Route::post('/parametro/json', ['as' => 'parametro.json', 'uses' => 'Admin\ParametroController@json']);
	Route::post('/parametro/store', ['as' => 'parametro.store', 'uses' => 'Admin\ParametroController@store']);
	Route::get('/parametro/edit/{id}', ['as' => 'parametro.edit', 'uses' => 'Admin\ParametroController@edit']);
	Route::post('/parametro/edit/{id}', ['as' => 'parametro.edit', 'uses' => 'Admin\ParametroController@edit']);
	Route::put('/parametro/update/{id}', ['as' => 'parametro.update', 'uses' => 'Admin\ParametroController@update']);
	Route::get('/parametro/info/{id}', ['as' => 'parametro.info', 'uses' => 'Admin\ParametroController@info']);
	Route::post('/parametro/info/{id}', ['as' => 'parametro.info', 'uses' => 'Admin\ParametroController@info']);
	Route::get('/parametro/destroy/{id}', ['as' => 'parametro.destroy', 'uses' => 'Admin\ParametroController@destroy']);
});
