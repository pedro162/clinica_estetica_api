<?php

namespace App\Http\Controllers\Admin;

use App\Categoria;
use App\Exceptions\ProdutoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProdutoRequest;
use App\Marca;
use App\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProdutoController extends Controller
{
    protected function requestProduto(Request $request)
    {
        $validador = Validator::make($request->all(), [

            'name' => 'required',
            'description' => 'required',
            'marca_id' => 'required',
            'categoria_id' => 'required'

        ]);

        return $validador;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            DB::beginTransaction();

            $consulta = $request->all();
            //dd($consulta);

            $parse = [
                'marca_produto' => 'marca.name',
                'codigo_produto' => 'produtos.id',
                'nome_produto' => 'produtos.name'

            ];

            $registro = DB::table('produtos')->join('categoria_produto', function ($join) {
                $join->on('produtos.id', '=', 'categoria_produto.produto_id');
            })->join('categorias', function ($join) {
                $join->on('categorias.id', '=', 'categoria_produto.categoria_id');
            })->join('marcas', function ($join) {
                $join->on('marcas.id', '=', 'produtos.marca_id');
            });

            $campos =  null;

            if (is_array($consulta) && count($consulta) > 0) {
                foreach ($consulta as $key => $val) {
                    switch (trim($key)) {
                        case 'id':
                            if (is_string($val)) {
                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }

                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $val = explode(',', $val);

                                $registro->whereIn('produtos.id', $val);
                            }
                            break;
                        case 'nome_produto':
                            if (is_string($val)) {
                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }

                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('produtos.name', 'like', '%' . $val . '%');
                            }
                            break;
                        case 'marca_produto':
                            if (is_string($val)) {
                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }

                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('marcas.name', 'like', '%' . $val . '%');
                            }
                            break;
                        case 'limite':
                            $val = (int) $val;

                            if (is_integer($val) && $val > 0) {
                                $registro->limit($val);
                            }
                            break;
                        case 'ordem':
                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }

                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $val = explode(',', $val);

                            for ($i = 0; !($i == count($val)); $i++) {
                                $atual = explode('-', $val[$i]);

                                if (count($atual) == 2) {
                                    if (array_key_exists(trim($atual[0]), $parse)) {
                                        $parsed = $parse[trim($atual[0])];

                                        if ($parsed) {
                                            $registro->orderBy($parsed, $atual[1]);
                                        }
                                    }
                                }
                            }
                            break;

                        case 'campos':
                            if (is_array($val) && count($val) > 0) {
                                $campos = $this->montaCamposConsulta($registro, $val);
                            }
                            break;
                    }
                }
            }

            if ($campos) {
                $registro->select($campos);
            } else {
                $registro->select('produtos.*', 'categorias.name as categoria', 'marcas.name as marca');
            }

            //$registro = \App\Produto::where('active', '=', 'yes')->get();
            $registro = $registro->where('categoria_produto.active', '=', 'yes')
                ->where('produtos.active', '=', 'yes')
                ->where('categoria_produto.tipo', '=', 'principal')->get();

            DB::commit();

            return view('admin.produto.index', compact('registro', 'consulta'));
        } catch (ProdutoException $e) {
            DB::rollback();
            return response()->json(['errors' => ['error' => 'teste: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 404);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $idAssistente)
    {
        $dadosRequest = $request->all();
        $callBack = $dadosRequest['callBack'] ?? '';
        $idAssistente =  $idAssistente ?? $dadosRequest['idAssistente'] ?? '';

        $marcas = Marca::where('active', '=', 'yes')->get();
        $categorias = Categoria::where('active', '=', 'yes')->get();
        return view('admin.produto.create', compact('marcas', 'categorias', 'callBack', 'idAssistente'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProdutoRequest $request)
    {
        try {
            set_time_limit(900000);
            $validator = $request->validated();

            $sentinela = null;

            DB::transaction(function () use (&$request, &$sentinela) {
                $dados = $request->all();
                $dadosRequest = [];

                $dadosRequest['marca_id']           = $dados['marca_id'];
                $dadosRequest['categoria_id']       = $dados['categoria_id'];
                $dadosRequest['sub_categoria_id']   = $dados['sub_categoria_id'];
                $dadosRequest['image']              = $dados['imagem'];
                $dadosRequest['name']               = $dados['name'];
                $dadosRequest['description']        = $dados['description'];
                $dadosRequest['price']              = $dados['price'];
                //$dadosRequest['spotigth']           = $dados['spotigth'];
                $dadosRequest['stock']              = $dados['stock'] ?? 0;
                $dadosRequest['user_id']            = Auth::User()->id; //trocar pelo id do usuario logado
                $dadosRequest['active']             = 'yes';
                //verifica a existencia de imagem
                $file = $request->file('imagem');

                if ($file) {
                    //cofigura o diretorio pra salvar a imagem do produto
                    $rand = rand(111111111, 999999999);
                    $diretorio = 'img/produtos';
                    $extensao = $file->guessClientExtension();
                    $nameArquivo = '_img_' . Str::slug($dadosRequest['name']) . '_' . $rand . '.' . $extensao;

                    if ($file->move($diretorio, $nameArquivo)) {
                        //adiciona o nome da imagem para salvar no banco
                        $dadosRequest['image'] = $diretorio . '/' . $nameArquivo;
                    } else {
                        //adiciona o nome da imagem para salvar no banco
                        $dadosRequest['image'] = '_img_standard.jpeg';
                    }
                } else {
                    //adiciona o nome da imagem para salvar no banco
                    $dadosRequest['image'] = '_img_standard.jpeg';
                }

                //salva o produto
                $sentinela      = $produto = Produto::create($dadosRequest);

                $marca          = Marca::find($dados['marca_id']);
                $categoria      = Categoria::find($dados['categoria_id']);
                $subCategoria   = Categoria::find($dados['sub_categoria_id']);

                $resultCategoria    = $produto->adicionarCategoria($categoria, ['active' => 'yes', 'tipo' => 'principal']);
                $resultSubCategoria = $produto->adicionarCategoria($subCategoria, ['active' => 'yes', 'tipo' => 'secundaria']);
            });

            if ($sentinela) {
                return response()->json(['mensagem' => $sentinela, 'class' => 'success'], 200);
            } else {
                return response()->json(['mensagem' => 'Erro ao cadastrar produto', 'class' => 'warning'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor', 'class' => 'warning'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id, $idAssistente)
    {
        try {
            $dados = $request->all();

            $id = $id ?? $dados['id'];
            $callBack = $dados['callBack'] ?? '';
            $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';

            if ((!isset($id)) || ($id <= 0)) {
                return response()->json(['errors' => ['error' => 'Parâmetro inválido']], 400);
            }

            if ((!isset($id)) || ($id <= 0)) {
                return response()->json(['errors' => ['error' => 'Parâmetro inválido']], 400);
            }

            DB::beginTransaction();
            $registro = Produto::where('active', '=', 'yes')->where('id', '=', $id)->first();

            if (! $registro) {
                throw new ProdutoException('Registro não encontrado');
            }

            DB::commit();

            return view('admin.produto.container', compact('registro', 'idAssistente', 'callBack'));
        } catch (ProdutoException $e) {
            DB::rollback();
            return response()->json(['errors' => ['error' => 'teste: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 404);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 500);
        }
    }


    public function info(Request $request, $id, $idAssistente)
    {
        try {
            $dados = $request->all();
            $id = $id ?? $dados['id'];
            $callBack = $dados['callBack'] ?? '';
            $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';

            if ($id <= 0) {
                throw new ProdutoException('Parâmetro ínválido');
            }

            DB::beginTransaction();

            $registro = Produto::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if ($registro == null) {
                throw new ProdutoException('Produto não encontrado');
            }

            DB::commit();

            return view('admin.produto.info', compact('registro', 'idAssistente', 'callBack'));
        } catch (ProdutoException $e) {
            DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id, $idAssistente)
    {
        try {
            $dadosRequest = $request->all();

            $callBack = $dadosRequest['callBack'] ?? '';
            $idAssistente =  $idAssistente ?? $dadosRequest['idAssistente'] ?? '';

            if (! isset($id)) {
                $id = isset($dadosRequest['id']) ? $dadosRequest['id'] : 0;
            }

            if ($id <= 0) {
                Session::flash('mensagem', ['msg' => 'Parâmetro ínválido', 'class' => 'alert alert-danger']);
                return redirect()->route('produto.index');
            }

            $registro = null;
            $marcas = null;
            $categorias = null;

            DB::transaction(function () use (&$id, &$registro, &$marcas, &$categorias) {
                $registro = DB::table('produtos')->join('categoria_produto as c', function ($join) {
                    $join->on('produtos.id', '=', 'c.produto_id');
                })
                    ->join('categoria_produto as cp', function ($join) {
                        $join->on('produtos.id', '=', 'cp.produto_id');
                    })->join('marcas', function ($join) {
                        $join->on('marcas.id', '=', 'produtos.marca_id');
                    })->select(
                        'produtos.*',
                        'c.categoria_id as categoria_id_pri',
                        'cp.categoria_id as categoria_id_sec',
                        'c.tipo as tipo_pri',
                        'cp.tipo as tipo_sec',
                        'marcas.name as marca',
                        'c.tipo',
                        'cp.tipo'
                    )
                    ->where('c.tipo', '=', 'principal')
                    ->where('c.active', '=', 'yes')
                    ->where('cp.tipo', '=', 'secundaria')
                    ->where('cp.active', '=', 'yes')
                    ->where('produtos.id', '=', $id)->first();

                $marcas = Marca::where('active', '=', 'yes')->get();
                $categorias = Categoria::where('active', '=', 'yes')->get();
            });

            if ($registro == null) {
                return response()->json(['mensagem' => 'Erro, registro não encontrado.', 'class' => 'warning'], 400);
            }

            return view('admin.produto.edit', compact('registro', 'marcas', 'categorias', 'idAssistente', 'callBack'));
        } catch (\Exception $e) {
            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor', 'class' => 'warning'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProdutoRequest $request, $id)
    {
        try {
            $validator = $request->validated();

            $dados = $request->all();
            $registro = null;

            DB::transaction(function () use (&$dados, &$id, &$registro, &$request) {
                $dadosRequest = [];

                $dadosRequest['marca_id']           = $dados['marca_id'];
                $dadosRequest['categoria_id']       = $dados['categoria_id'];
                $dadosRequest['sub_categoria_id']   = $dados['sub_categoria_id'];
                $dadosRequest['name']               = $dados['name'];
                $dadosRequest['description']        = $dados['description'];
                $dadosRequest['price']              = $dados['price'];
                //$dadosRequest['spotigth']           = $dados['spotigth'];
                $dadosRequest['stock']              = $dados['stock'] ?? 0;
                $dadosRequest['user_id']            = Auth::user()->id; //trocar pelo id do usuario logado
                $dadosRequest['active']             = 'yes';

                //tenta capturar a imagem do produto
                $file = $request->file('imagem');

                if ($file) {
                    //cofigura o diretorio pra salvar a imagem do produto
                    $rand = rand(111111111, 999999999);
                    $diretorio = 'img/produtos';
                    $extensao = $file->guessClientExtension();
                    $nameArquivo = '_img_' . Str::slug($dadosRequest['name']) . '_' . $rand . '.' . $extensao;

                    if ($file->move($diretorio, $nameArquivo)) {
                        //adiciona o nome da imagem para salvar no banco
                        $dadosRequest['image'] = $diretorio . '/' . $nameArquivo;
                    } else {
                        //adiciona o nome da imagem para salvar no banco
                        $dadosRequest['image'] = '_img_standard.jpeg';
                    }
                } else {
                    //adiciona o nome da imagem para salvar no banco
                    $dadosRequest['image'] = '_img_standard.jpeg';
                }

                $produto = Produto::find($id);
                $categorias = $produto->categoria;

                for ($i = 0; !($i == count($categorias)); $i++) {
                    $produto->removeverCategoria($categorias[$i]);
                }

                $produto->update($dadosRequest);

                $categoria      = Categoria::find($dadosRequest['categoria_id']);
                $subCategoria   = Categoria::find($dadosRequest['sub_categoria_id']);

                $resultCategoria    = $produto->adicionarCategoria($categoria, ['active' => 'yes', 'tipo' => 'principal']);
                $resultSubCategoria = $produto->adicionarCategoria($subCategoria, ['active' => 'yes', 'tipo' => 'secundaria']);
                $registro = $produto;
            });

            if ($registro != null) {
                return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);
            }

            return response()->json(['mensagem' => 'Erro ao atualizar registro', 'class' => 'warning'], 400);
        } catch (\Exception $e) {
            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor : ' . $e->getMessage(), 'class' => 'warning'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if ($id <= 0) {
                return response()->json([['mensagem' => 'Parâmetro inválido', 'class' => 'warning'], 400]);
            }

            $registro = null;

            DB::transaction(function () use (&$id, &$registro) {
                $produto = Produto::where('active', '=', 'yes')
                    ->where('id', '=', $id)->first();

                if (! $produto) {
                    $registro = null;
                } else {
                    $registro = $produto->update(['active' => 'no']);
                }
            });

            if ($registro == null) {
                return response()->json(['mensagem' => 'Erro ao exclir registro', 'class' => 'warning'], 400);
            }

            return response()->json(['mensagem' => 'Registro deletado com sucesso', 'class' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor', 'class' => 'warning'], 500);
        }
    }

    public function head(Request $request)
    {
        $dados = $request->all();

        $isReload = isset($dados['isReload']) && $dados['isReload'] == true ? $dados['isReload'] : false;

        if ($isReload) {
            return view('admin.produto.head_refresh', compact('isReload'));
        } else {
            return view('admin.produto.head', compact('isReload'));
        }
    }

    public function adicionarIngrediente($id)
    {
        try {
            $produto    = null;
            $registros  = null;

            DB::transaction(function () use (&$id, &$produto, &$registros) {
                $produto    = Produto::where('id', '=', $id)->first();
                $registros  = Produto::where('id', '!=', $id)->get();
            });

            if (($produto == null) || ($registros == null)) {
                return response()->json(['mensagem' => 'Registro não encontrado', 'class' => 'warning'], 400);
            }

            return view('admin.produto.ingrediente_adicionar', compact('produto', 'registros'));
        } catch (\Exception $e) {
            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor', 'class' => 'warning'], 500);
        }
    }

    public function ingredienteSalvar(ProdutoRequest $request, $id)
    {
        try {
            $produto    = null;
            $registros  = null;

            DB::transaction(function () use (&$id, &$produto, &$registros) {
                $produto    = Produto::where('id', '=', $id)->first();
            });

            if ($produto == null) {
                return response()->json(['mensagem' => 'Registro não encontrado', 'class' => 'warning'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor', 'class' => 'warning'], 500);
        }
    }

    /**
     * Return a listing of the resource in json.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function indexJson(Request $request)
    {
        try {
            $consulta = $request->all();

            $parse = [
                'marca_produto' => 'marca.name',
                'codigo_produto' => 'produtos.id',
                'nome_produto' => 'produtos.name'

            ];

            $registro = DB::table('produtos')->join('categoria_produto', function ($join) {
                $join->on('produtos.id', '=', 'categoria_produto.produto_id');
            })->join('categorias', function ($join) {

                $join->on('categorias.id', '=', 'categoria_produto.categoria_id');
            })->join('marcas', function ($join) {
                $join->on('marcas.id', '=', 'produtos.marca_id');
            });

            $campos =  null;

            if (is_array($consulta) && count($consulta) > 0) {
                foreach ($consulta as $key => $val) {
                    switch (trim($key)) {
                        case 'id':
                            if (is_string($val)) {
                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }

                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $val = explode(',', $val);

                                $registro->whereIn('produtos.id', $val);
                            }
                            break;
                        case 'nome_produto':
                            if (is_string($val)) {
                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }

                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('produtos.name', 'like', '%' . $val . '%');
                            }
                            break;
                        case 'marca_produto':
                            if (is_string($val)) {
                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }

                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('marcas.name', 'like', '%' . $val . '%');
                            }
                            break;
                        case 'limite':
                            $val = (int) $val;

                            if (is_integer($val) && $val > 0) {
                                $registro->limit($val);
                            }
                            break;
                        case 'ordem':
                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }

                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $val = explode(',', $val);

                            for ($i = 0; !($i == count($val)); $i++) {
                                $atual = explode('-', $val[$i]);

                                if (array_key_exists(trim($atual[0]), $parse)) {
                                    $parsed = $parse[trim($atual[0])];

                                    if ($parsed) {
                                        $registro->orderBy($parsed, $atual[1]);
                                    }
                                }
                            }
                            break;

                        case 'campos':
                            if (is_array($val) && count($val) > 0) {
                                $campos = $this->montaCamposConsulta($registro, $val);
                            }
                            break;
                    }
                }
            }

            if ($campos) {
                $registro->select($campos);
            } else {
                $registro->select('produtos.*', 'categorias.name as categoria', 'marcas.name as marca');
            }

            $registro = $registro->where('categoria_produto.active', '=', 'yes')
                ->where('produtos.active', '=', 'yes')
                ->where('categoria_produto.tipo', '=', 'principal')->get();

            DB::commit();

            return response()->json(['data' => $registro, 'class' => 'success'], 201);
        } catch (ProdutoException $e) {
            DB::rollback();
            return response()->json(['errors' => ['error' => 'teste: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 404);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 500);
        }
    }
}
