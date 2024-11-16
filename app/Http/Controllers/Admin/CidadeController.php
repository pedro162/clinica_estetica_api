<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cidade;
use App\Estado;
use App\Exceptions\CidadeException;
use Illuminate\Support\Facades\Validator;

class CidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            \DB::beginTransaction();

            $consulta = $request->all();

            if (! isset($consulta['ordem'])) {

                $consulta['ordem'] =  'id-desc';
            }

            if (! isset($consulta['limite'])) {

                $consulta['limite'] =  500;
            }

            $campos =  null;
            $parse = [
                'name_cidade' => 'cidades.dsIpi',
                'id' => 'cidades.id'

            ];

            $registro = \DB::table('cidades');
            $registro->join('estadoss', function ($join) {

                $join->on('estadoss.id', '=', 'cidades.estado_id');
            });

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

                                $registro->whereIn('cidades.id', $val);
                            }
                            break;
                        case 'nmCidade':
                            if (is_string($val)) {

                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }
                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('cidades.nmCidade', 'like', '%' . $val . '%');
                            }
                            break;
                        case 'cdCidade':
                            if (is_string($val)) {

                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }
                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('cidades.cdCidade', '=', '' . $val . '');
                            }
                            break;
                        case 'sigla':
                            if (is_string($val)) {

                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }
                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('cidades.sigla', '=', '' . $val . '');
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
                $registro->select('cidades.*', 'estadoss.nmEStado');
            }

            $registro = $registro->where('cidades.active', '=', 'yes')
                ->where('estadoss.active', '=', 'yes')->get();

            \DB::commit();

            //dd( $registro);

            return view('admin.cidade.index', compact('registro', 'consulta'));
        } catch (CidadeException $e) {
            \DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));

            // return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);

        } catch (\Exception $e) {
            \DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));

            //return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function json(Request $request)
    {
        try {
            \DB::beginTransaction();



            $consulta = $request->all();

            if (! isset($consulta['ordem'])) {

                $consulta['ordem'] =  'id-desc';
            }

            if (! isset($consulta['limite'])) {

                $consulta['limite'] =  500;
            }

            $campos =  null;
            $parse = [
                'name_cidade' => 'cidades.dsIpi',
                'id' => 'cidades.id'

            ];

            $registro = \DB::table('cidades');
            $registro->join('estadoss', function ($join) {

                $join->on('estadoss.id', '=', 'cidades.estado_id');
            });

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

                                $registro->whereIn('cidades.id', $val);
                            }
                            break;
                        case 'nmCidade':
                        case 'name_nome_cidade':
                        case 'name':
                            if (is_string($val)) {

                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }
                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('cidades.nmCidade', 'like', '%' . $val . '%');
                            }
                            break;
                        case 'cdCidade':
                            if (is_string($val)) {

                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }
                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('cidades.cdCidade', '=', '' . $val . '');
                            }
                            break;
                        case 'sigla':
                            if (is_string($val)) {

                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }
                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('cidades.sigla', '=', '' . $val . '');
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
                $registro->select('cidades.*', 'estadoss.nmEStado');
            }

            $registro = $registro->where('cidades.active', '=', 'yes')
                ->where('estadoss.active', '=', 'yes')->get();

            \DB::commit();

            return response()->json(['registro' => $registro, 'class' => 'sucess'], 201);
        } catch (CidadeException $e) {
            \DB::rollback();

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);
        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 500);
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
        return view('admin.cidade.create', compact('callBack', 'idAssistente'));
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

            \DB::beginTransaction();

            $dados = $request->all();

            $estado = Estado::where('active', '=', 'yes')->where('id', '=', $dados['estado_id'])->first();
            if (! $estado) {
                throw new CidadeException('Estado não identificado. Tente novamente ou entre em contato com o suporte.');
            }

            $dadosRequest = [];

            $dadosRequest['user_id']            = \Auth::User()->id;
            $dadosRequest['user_update_id']     = \Auth::User()->id;
            $dadosRequest['nmCidade']           = $dados['nmCidade'];
            $dadosRequest['cdCidade']           = $dados['cdCidade'];
            $dadosRequest['sigla']              = $dados['sigla'] ?? null;
            $dadosRequest['estado_id']          = $estado->id;
            $dadosRequest['active']             = 'yes';

            $registro = Cidade::create($dadosRequest);
            \DB::commit();

            if ($registro) {
                return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
            } else {
                throw new CidadeException('Erro ao cadastrar');
            }
        } catch (CidadeException $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'teste: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 400);
        } catch (\Exception $e) {
            \DB::rollback();
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

    public function info(Request $request, $id, $idAssistente = 0)
    {

        try {

            $dados = $request->all();
            $id = $id ?? $dados['id'];
            $callBack = $dados['callBack'] ?? '';
            $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';

            if ($id <= 0) {
                throw new CidadeException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = Cidade::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if ($registro == null) {
                throw new CidadeException('Registro não encontrado');
            }

            \DB::commit();

            //return view('admin.produto.info', compact('registro'));
            return response()->json(['registro' => $registro, 'class' => 'sucess'], 201);
        } catch (CidadeException $e) {
            \DB::rollback();

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);

            // return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);

        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 500);

            //return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
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
                throw new CidadeException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = Cidade::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if ($registro == null) {
                throw new CidadeException('Registro não encontrado');
            }

            $estados = Estado::where('active', '=', 'yes')->get();

            \DB::commit();

            return view('admin.cidade.edit', compact('registro', 'idAssistente', 'callBack', 'estados'));
        } catch (CidadeException $e) {

            \DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));

            //\Session::flash('mensagem', ['msg'=>'Ocorreum um erro no servidor: '.$e->getMessage(), 'class'=>'alert alert-warning']);
            //return redirect()->back();

        } catch (\Exception $e) {
            \DB::rollback();

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

            \DB::beginTransaction();

            $dados = $request->all();

            $estado = Estado::where('active', '=', 'yes')->where('id', '=', $dados['estado_id'])->first();

            if (! $estado) {
                throw new CidadeException('País não identificado. Tente novamente ou entre em contato com o suporte.');
            }
            $dadosRequest = [];

            $dadosRequest['user_update_id']     = \Auth::User()->id;
            $dadosRequest['nmCidade']           = $dados['nmCidade'];
            $dadosRequest['cdCidade']           = $dados['cdCidade'];
            $dadosRequest['sigla']              = $dados['sigla'] ?? null;
            $dadosRequest['estado_id']          = $estado->id;
            $dadosRequest['active']             = 'yes';

            $Cidade = Cidade::where('active', '=', 'yes')->where('id', '=', $id)->first();
            $Cidade->update($dadosRequest);

            \DB::commit();

            return response()->json(['mensagem' => $Cidade, 'class' => 'sucess'], 200);
        } catch (CidadeException $th) {

            \DB::rollback();

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);

            //throw $th;
        } catch (\Exception $th) {
            \DB::rollback();

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

            \DB::beginTransaction();

            $dadosRequest = [];

            $dadosRequest['user_update_id']     = \Auth::User()->id; //trocar pelo id do usuario logado
            $dadosRequest['active']             = 'no';
            $piscofins = Cidade::where('active', '=', 'yes')->where('id', '=', $id)->first();
            $piscofins->update($dadosRequest);
            $piscofins->delete();

            \DB::commit();

            return response()->json(['mensagem' => [], 'class' => 'sucess'], 200);
        } catch (CidadeException $th) {

            \DB::rollback();

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);

            //throw $th;
        } catch (\Exception $th) {
            \DB::rollback();

            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor', 'class' => 'warning'], 500);
            //throw $th;
        }
    }

    public function head(Request $request)
    {
        $dados = $request->all();

        $isReload = isset($dados['isReload']) && $dados['isReload'] == true ? $dados['isReload'] : false;
        if ($isReload) {

            return view('admin.cidade.head_refresh', compact('isReload'));
        } else {
            return view('admin.cidade.head', compact('isReload'));
        }
    }

    protected function validaRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nmCidade' => 'required|max:255|min:2',
            'cdCidade' => 'required|max:100',
            'sigla' => 'max:100|min:2',
            'estado_id' => 'required|min:1'
        ], [
            'nmCidade.required' => 'O campo "DESCRIÇÃO" é obrigatório.',
            'nmCidade.max' => 'O "DESCRIÇÃO" suporta até :max caracteres.',
            'nmCidade.min' => 'O "DESCRIÇÃO" deve conter pelo menos :min caracteres.',
            'cdCidade.required' => 'O campo "CÓDIGO DA CIDADE" é obrigatório.',
            'cdCidade.max' => 'O campo "CÓDIGO DA CIDADE" deve ter até :max caracteres.',
            'estado_id.required' => 'O campo "CÓDIGO DO ESTADO" é obrigatório.',
            'estado_id.min' => 'O campo "CÓDIGO DO ESTADO" deve ser um número positivo.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach ($errors->all() as $mensagem) {
                $msg .= $mensagem . '<br/>';
            }

            throw new CidadeException($msg);
        }

        return true;
    }
}
