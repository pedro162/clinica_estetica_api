<?php

namespace App\Http\Controllers\Admin;

use App\ContaCategoria;
use App\Exceptions\CategoriaContaException as ExceptionsCategoriaContaException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoriaContaController extends Controller
{
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
            $campos =  null;
            $parse = [
                'categoria_conta' => 'conta_categorias.name'

            ];

            $registro = DB::table('conta_categorias');
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

                                $registro->whereIn('conta_categorias.id', $val);
                            }
                            break;
                        case 'name':
                            if (is_string($val)) {

                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }
                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('conta_categorias.name', 'like', '%' . $val . '%');
                            }
                            break;
                        case 'categoria_conta_id':
                            if (is_string($val)) {

                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }
                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('conta_categorias.id', '=', '' . $val . '');
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
                                //$campos = $this->montaCamposConsulta($registro, $val);

                            }
                            break;
                    }
                }
            }
            if ($campos) {
                $registro->select($campos);
            } else {
                $registro->select('conta_categorias.*');
            }

            $registro = $registro->where('conta_categorias.active', '=', 'yes')->get();

            DB::commit();

            //dd( $registro);

            return view('admin.categoria_conta.index', compact('registro', 'consulta'));
        } catch (ExceptionsCategoriaContaException $e) {
            DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));

            // return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);

        } catch (\Exception $e) {
            DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));

            //return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }

    public function json(Request $request)
    {
        try {
            DB::beginTransaction();

            $consulta = $request->all();
            $campos =  null;
            $parse = [
                'categoria_conta' => 'conta_categorias.name'

            ];

            $registro = DB::table('conta_categorias');
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

                                $registro->whereIn('conta_categorias.id', $val);
                            }
                            break;
                        case 'name':
                            if (is_string($val)) {

                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }
                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('conta_categorias.name', 'like', '%' . $val . '%');
                            }
                            break;
                        case 'categoria_conta_id':
                            if (is_string($val)) {

                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }
                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('conta_categorias.id', '=', '' . $val . '');
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
                                //$campos = $this->montaCamposConsulta($registro, $val);

                            }
                            break;
                    }
                }
            }
            if ($campos) {
                $registro->select($campos);
            } else {
                $registro->select('conta_categorias.*');
            }

            $registro = $registro->where('conta_categorias.active', '=', 'yes')->get();

            DB::commit();

            //dd( $registro);

            return response()->json(['registro' => $registro, 'class' => 'sucess'], 201);
        } catch (ExceptionsCategoriaContaException $e) {
            DB::rollback();

            return response()->json(['mensagem' => $e->getMessage(), 'class' => 'warning'], 400);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['mensagem' => $e->getMessage(), 'class' => 'warning'], 400);

            //return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
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
        return view('admin.categoria_conta.create', compact('callBack', 'idAssistente'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $this->validaRequest($request);

            DB::beginTransaction();

            $dados = $request->all();

            $dadosRequest = [];

            $dadosRequest['name']                   = $dados['name'];
            $dadosRequest['user_id']                = Auth::User()->id;
            $dadosRequest['active']                 = 'yes';
            $registro = ContaCategoria::create($dadosRequest);
            DB::commit();

            if ($registro) {
                return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
            } else {
                throw new ExceptionsCategoriaContaException('Erro ao cadastrar');
            }
        } catch (ExceptionsCategoriaContaException $e) {
            DB::rollback();
            return response()->json(['errors' => ['error' => 'teste: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 400);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function info(Request $request, $id, $idAssistente)
    {

        try {

            $dados = $request->all();
            $id = $id ?? $dados['id'];
            $callBack = $dados['callBack'] ?? '';
            $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';

            if ($id <= 0) {
                throw new ExceptionsCategoriaContaException('Parâmetro ínválido');
            }

            DB::beginTransaction();

            $registro = ContaCategoria::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if ($registro == null) {
                throw new ExceptionsCategoriaContaException('Registro não encontrado');
            }

            DB::commit();

            //return view('admin.produto.info', compact('registro'));
            return view('admin.categoria_conta.info', compact('registro', 'idAssistente', 'callBack'));
        } catch (ExceptionsCategoriaContaException $e) {
            DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));
            //return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);

        } catch (\Exception $e) {

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));
            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

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
                throw new ExceptionsCategoriaContaException('Parâmetro ínválido');
            }

            DB::beginTransaction();

            $registro = ContaCategoria::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if ($registro == null) {
                throw new ExceptionsCategoriaContaException('Registro não encontrado');
            }

            DB::commit();

            return view('admin.categoria_conta.edit', compact('registro', 'idAssistente', 'callBack'));
        } catch (ExceptionsCategoriaContaException $e) {

            DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));

            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));
            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {


            $this->validaRequest($request);

            DB::beginTransaction();

            $dados = $request->all();

            $dadosRequest = [];
            $dadosRequest['user_update_id']         = Auth::User()->id;
            $dadosRequest['name']                   = $dados['name'];

            $categoria_conta = ContaCategoria::where('active', '=', 'yes')->where('id', '=', $id)->first();
            if (! $categoria_conta) {
                throw new ExceptionsCategoriaContaException('Registro não encontrado');
            }
            $categoria_conta->update($dadosRequest);

            DB::commit();

            return response()->json(['mensagem' => $categoria_conta, 'class' => 'sucess'], 200);
        } catch (ExceptionsCategoriaContaException $th) {

            DB::rollback();

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);

            //throw $th;
        } catch (\Exception $th) {
            DB::rollback();

            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor', 'class' => 'warning'], 500);
            //throw $th;
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

            DB::beginTransaction();

            $dadosRequest = [];

            $dadosRequest['user_update_id']     = Auth::User()->id; //trocar pelo id do usuario logado
            $dadosRequest['active']             = 'no';
            $categoriaConta = ContaCategoria::where('active', '=', 'yes')->where('id', '=', $id)->first();

            $categoriaConta->update($dadosRequest);
            $categoriaConta->delete();

            DB::commit();

            return response()->json(['mensagem' => [], 'class' => 'sucess'], 200);
        } catch (ExceptionsCategoriaContaException $th) {

            DB::rollback();

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);

            //throw $th;
        } catch (\Exception $th) {
            DB::rollback();

            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor', 'class' => 'warning'], 500);
            //throw $th;
        }
    }

    public function head(Request $request)
    {
        $dados = $request->all();

        $isReload           = isset($dados['isReload']) && $dados['isReload'] == true ? $dados['isReload'] : false;
        $pesquisar          = $dados['pesquisar'] ?? null;
        $calback_selected   = $dados['calback_selected'] ?? null;
        $url_pesquisa       = $dados['url_pesquisa'] ?? null;

        if ($isReload) {

            return view('admin.categoria_conta.head_refresh', compact('isReload', 'pesquisar', 'calback_selected', 'url_pesquisa'));
        } else {
            return view('admin.categoria_conta.head', compact('isReload', 'calback_selected', 'pesquisar', 'url_pesquisa'));
        }
    }

    protected function validaRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|min:2',
        ], [
            'name.required' => 'O campo "DESCRIÇÃO" é obrigatório.',
            'name.max' => 'O "DESCRIÇÃO" suporta até :max caracteres.',
            'name.min' => 'O "DESCRIÇÃO" deve conter pelo menos :min caracteres.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach ($errors->all() as $mensagem) {
                $msg .= $mensagem . '<br/>';
            }

            throw new ExceptionsCategoriaContaException($msg);
        }

        return true;
    }
}
