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

	Route::get('/produto/index', ['as'=>'produto.index', 'uses'=>'Admin\ProdutoController@index']);
	Route::get('/produto/create', ['as'=>'produto.create', 'uses'=>'Admin\ProdutoController@create']);
	Route::post('/produto/store', ['as'=>'produto.store', 'uses'=>'Admin\ProdutoController@store']);
	Route::get('/produto/edit/{id}', ['as'=>'produto.edit', 'uses'=>'Admin\ProdutoController@edit']);
	Route::put('/produto/update/{id}', ['as'=>'produto.update', 'uses'=>'Admin\ProdutoController@update']);
	Route::get('/produto/show/id', ['as'=>'produto.show', 'uses'=>'Admin\ProdutoController@show']);
	Route::get('/produto/info/{id}', ['as'=>'produto.info', 'uses'=>'Admin\ProdutoController@info']);
	Route::get('/produto/head', ['as'=>'produto.head', 'uses'=>'Admin\ProdutoController@head']);
	Route::get('/produto/destroy/{id}', ['as'=>'produto.destroy', 'uses'=>'Admin\ProdutoController@destroy']);
	Route::get('/produto/adiconar/ingrediente/{id}', ['as'=>'produto.adicionar.ingrediente', 'uses'=>'Admin\ProdutoController@adicionarIngrediente']);
	Route::post('/produto/ingrediente/salvar/{id}', ['as'=>'produto.ingrediente.salvar', 'uses'=>'Admin\ProdutoController@ingredienteSalvar']);



	Route::get('/marca/index', ['as'=>'marca.index', 'uses'=>'Admin\MarcaController@index']);
	Route::get('/marca/create', ['as'=>'marca.create', 'uses'=>'Admin\MarcaController@create']);
	Route::post('/marca/store', ['as'=>'marca.store', 'uses'=>'Admin\MarcaController@store']);
	Route::get('/marca/edit/{id}', ['as'=>'marca.edit', 'uses'=>'Admin\MarcaController@edit']);
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

	Route::get('/pessoa/index', ['as'=>'pessoa.index', 'uses'=>'Admin\PessoaController@index']);
	Route::get('/pessoa/create', ['as'=>'pessoa.create', 'uses'=>'Admin\PessoaController@create']);
	Route::post('/pessoa/store', ['as'=>'pessoa.store', 'uses'=>'Admin\PessoaController@store']);
	Route::get('/pessoa/edit/{id}', ['as'=>'pessoa.edit', 'uses'=>'Admin\PessoaController@edit']);
	Route::put('/pessoa/update/{id}', ['as'=>'pessoa.update', 'uses'=>'Admin\PessoaController@update']);
	Route::get('/pessoa/show/{id}', ['as'=>'pessoa.show', 'uses'=>'Admin\PessoaController@show']);
	Route::get('/pessoa/info/{id}', ['as'=>'pessoa.info', 'uses'=>'Admin\PessoaController@info']);
	Route::get('/pessoa/head', ['as'=>'pessoa.head', 'uses'=>'Admin\PessoaController@head']);
	Route::get('/pessoa/destroy/{id}', ['as'=>'pessoa.destroy', 'uses'=>'Admin\PessoaController@destroy']);
	Route::get('/pessoa/valida/cpf/{cpf}', ['as'=>'pessoa.valida.cpf', 'uses'=>'Admin\PessoaController@validarCpf']);

	Route::get('/logradouro/index', ['as'=>'logradouro.index', 'uses'=>'Admin\LogradouroController@index']);
	Route::get('/logradouro/create/{id}', ['as'=>'logradouro.create', 'uses'=>'Admin\LogradouroController@create']);
	Route::post('/logradouro/store/{idPessoa}', ['as'=>'logradouro.store', 'uses'=>'Admin\LogradouroController@store']);
	Route::get('/logradouro/edit/{id}/{idPessoa}', ['as'=>'logradouro.edit', 'uses'=>'Admin\LogradouroController@edit']);
	Route::put('/logradouro/update/{id}/{idPessoa}', ['as'=>'logradouro.update', 'uses'=>'Admin\LogradouroController@update']);
	Route::get('/logradouro/show/{id}/{idPessoa}', ['as'=>'logradouro.show', 'uses'=>'Admin\LogradouroController@show']);
	Route::get('/logradouro/info/{id}/{idPessoa}', ['as'=>'logradouro.info', 'uses'=>'Admin\LogradouroController@info']);
	Route::get('/logradouro/head', ['as'=>'logradouro.head', 'uses'=>'Admin\LogradouroController@head']);
	Route::get('/logradouro/destroy/{id}/{idPessoa}', ['as'=>'logradouro.destroy', 'uses'=>'Admin\LogradouroController@destroy']);

	Route::get('/logradouro/load/api', ['as'=>'logradouro.load.api', 'uses'=>'Admin\LogradouroController@loadLogradouroApi']);

	Route::get('/cobranca/receber/index', ['as'=>'cobranca.receber.index', 'uses'=>'Admin\CobrancaReceberController@index']);
	Route::get('/cobranca/receber/index/json', ['as'=>'cobranca.receber.index.json', 'uses'=>'Admin\CobrancaReceberController@indexJson']);
	Route::get('/cobranca/receber/create', ['as'=>'cobranca.receber.create', 'uses'=>'Admin\CobrancaReceberController@create']);
	Route::post('/cobranca/receber/store', ['as'=>'cobranca.receber.store', 'uses'=>'Admin\CobrancaReceberController@store']);
	Route::get('/cobranca/receber/edit/{idReferencia}/{tpReferencia}', ['as'=>'cobranca.receber.edit', 'uses'=>'Admin\CobrancaReceberController@edit']);
	Route::put('/cobranca/receber/update/{id}', ['as'=>'cobranca.receber.update', 'uses'=>'Admin\CobrancaReceberController@update']);
	Route::get('/cobranca/receber/show/{idReferencia}/{tpReferencia}', ['as'=>'cobranca.receber.show', 'uses'=>'Admin\CobrancaReceberController@show']);
	Route::get('/cobranca/receber/info/{id}', ['as'=>'cobranca.receber.info', 'uses'=>'Admin\CobrancaReceberController@info']);
	Route::get('/cobranca/receber/head', ['as'=>'cobranca.receber.head', 'uses'=>'Admin\CobrancaReceberController@head']);
	Route::get('/cobranca/receber/destroy/{id}', ['as'=>'cobranca.receber.destroy', 'uses'=>'Admin\CobrancaReceberController@destroy']);
	Route::get('/cobranca/receber/mensalidade/{id}', ['as'=>'cobranca.receber.mensalidade', 'uses'=>'Admin\CobrancaReceberController@mensalidade']);
	Route::post('/cobranca/receber/mensalidade/store/{id}', ['as'=>'cobranca.receber.mensalidade.store', 'uses'=>'Admin\CobrancaReceberController@saveMensalidade']);

	Route::get('/cobranca/receber/baixar/{idReferencia}/{tpReferencia}', ['as'=>'cobranca.receber.baixar', 'uses'=>'Admin\CobrancaReceberController@baixar']);
	Route::get('/cobranca/receber/baixar/credito/cliente/{idReferencia}/{tpReferencia}', ['as'=>'cobranca.receber.baixar.credito.cliente', 'uses'=>'Admin\CobrancaReceberController@baixarCreCliente']);
	Route::get('/cobranca/receber/extornar/{idReferencia}/{tpReferencia}', ['as'=>'cobranca.receber.extornar', 'uses'=>'Admin\CobrancaReceberController@extornar']);
	Route::get('/cobranca/receber/acertar/{idReferencia}/{tpReferencia}', ['as'=>'cobranca.receber.acertar', 'uses'=>'Admin\CobrancaReceberController@acertar']);
	Route::get('/cobranca/receber/desdobrar/{idReferencia}/{tpReferencia}', ['as'=>'cobranca.receber.desdobrar', 'uses'=>'Admin\CobrancaReceberController@desdobrar']);
	Route::get('/cobranca/receber/negativar/{idReferencia}/{tpReferencia}', ['as'=>'cobranca.receber.negativar', 'uses'=>'Admin\CobrancaReceberController@negativar']);
	Route::get('/cobranca/receber/conciliar/cni{idReferencia}/{tpReferencia}', ['as'=>'cobranca.receber.conciliar.cni', 'uses'=>'Admin\CobrancaReceberController@conciliarCni']);
	Route::get('/cobranca/receber/recibo/{idReferencia}/{tpReferencia}', ['as'=>'cobranca.receber.recibo', 'uses'=>'Admin\CobrancaReceberController@recibo']);
	Route::get('/cobranca/receber/anexar/documento/{idReferencia}/{tpReferencia}', ['as'=>'cobranca.receber.baixar.anexar
documento', 'uses'=>'Admin\CobrancaReceberController@anexarDocumento']);
	Route::get('/cobranca/receber/ver/desdobramento/{idReferencia}/{tpReferencia}', ['as'=>'cobranca.receber.ver.desdobramento', 'uses'=>'Admin\CobrancaReceberController@verDesdobramento']);
	Route::get('/cobranca/receber/ficha/debitos/{idReferencia}/{tpReferencia}', ['as'=>'cobranca.receber.ficha.debitos', 'uses'=>'Admin\CobrancaReceberController@fichaDebitos']);

	Route::get('/cobranca/receber/recibo/{idReferencia}/{tpReferencia}', ['as'=>'cobranca.receber.recibo', 'uses'=>'Admin\CobrancaReceberController@recibo']);
});
