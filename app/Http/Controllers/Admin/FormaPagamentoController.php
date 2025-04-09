<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\FormaPagamento;
use App\Exception\FormaPagamentoException;
use Illuminate\Support\Facades\Validator;

class FormaPagamentoController extends Controller
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
            $campos =  null;
            $parse = [
                'forma_name' => 'forma_pagamentos.name'

            ];

            $registro = \DB::table('forma_pagamentos');
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

                                $registro->whereIn('forma_pagamentos.id', $val);
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

                                $registro->where('forma_pagamentos.name', 'like', '%' . $val . '%');
                            }
                            break;
                        case 'forma_pagamento_id':
                            if (is_string($val)) {

                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }
                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('forma_pagamentos.id', '=', '' . $val . '');
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
                $registro->select('forma_pagamentos.*');
            }

            $registro = $registro->where('forma_pagamentos.active', '=', 'yes')->get();

            \DB::commit();

            //dd( $registro);

            return view('admin.forma_pagamento.index', compact('registro', 'consulta'));
        } catch (FormaPagamentoException $e) {
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

    public function json(Request $request)
    {
        try {
            \DB::beginTransaction();

            $consulta = $request->all();
            $campos =  null;
            $parse = [
                'forma_name' => 'forma_pagamentos.name'

            ];

            $registro = \DB::table('forma_pagamentos');
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

                                $registro->whereIn('forma_pagamentos.id', $val);
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

                                $registro->where('forma_pagamentos.name', 'like', '%' . $val . '%');
                            }
                            break;
                        case 'forma_pagamento_id':
                            if (is_string($val)) {

                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }
                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('forma_pagamentos.id', '=', '' . $val . '');
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
                $registro->select('forma_pagamentos.*');
            }

            $registro = $registro->where('forma_pagamentos.active', '=', 'yes')->get();

            \DB::commit();

            if (isset($consulta['to_require']) && $consulta['to_require'] == true) {
                $dataToRequest = [];
                foreach ($registro as $reg) {
                    $dataToRequest[] = ['label' => $reg->name, 'value' => $reg->id];
                }

                $registro = $dataToRequest;
            }

            //dd( $registro);


            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (FormaPagamentoException $e) {
            \DB::rollback();

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);
        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);

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
        return view('admin.forma_pagamento.create', compact('callBack', 'idAssistente'));
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

            $dadosRequest = [];

            $dadosRequest['name']                   = $dados['name'];
            $dadosRequest['type']                   = $dados['type'];
            $dadosRequest['vrMin']                  = $dados['vrMin'];
            $dadosRequest['vrMax']                  = $dados['vrMax'];
            $dadosRequest['status_abertura']        = $dados['status_abertura'] ?? 'close';
            $dadosRequest['status_bloqueio']        = $dados['status_bloqueio'];
            $dadosRequest['aceita_transferencia']   = $dados['aceita_transferencia'];
            $dadosRequest['user_id']                = \Auth::User()->id;
            $dadosRequest['active']                 = 'yes';
            $registro = FormaPagamento::create($dadosRequest);


            if (! $registro) {
                throw new FormaPagamentoException('Erro ao cadastrar');
            }

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (FormaPagamentoException $e) {
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

    public function info(Request $request, $id, $idAssistente)
    {

        try {

            $dados = $request->all();
            $id = $id ?? $dados['id'];
            $callBack = $dados['callBack'] ?? '';
            $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';

            if ($id <= 0) {
                throw new FormaPagamentoException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = FormaPagamento::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if ($registro == null) {
                throw new FormaPagamentoException('Registro não encontrado');
            }

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (FilialException $e) {
            \DB::rollback();

            //$msg = $e->getMessage();
            //return view('layouts._admin._error', compact('msg'));

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);
        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 500);
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
                throw new FormaPagamentoException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = FormaPagamento::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if ($registro == null) {
                throw new FormaPagamentoException('Registro não encontrado');
            }

            \DB::commit();

            return view('admin.forma_pagamento.edit', compact('registro', 'idAssistente', 'callBack'));
        } catch (FormaPagamentoException $e) {

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

            $dadosRequest = [];
            $dadosRequest['user_update_id']         = \Auth::User()->id;
            $dadosRequest['name']                   = $dados['name'];
            $dadosRequest['type']                   = $dados['type'];
            $dadosRequest['vrMin']                  = $dados['vrMin'];
            $dadosRequest['vrMax']                  = $dados['vrMax'];
            // $dadosRequest['status_abertura']        = $dados['status_abertura'];
            $dadosRequest['status_bloqueio']        = $dados['status_bloqueio'];
            $dadosRequest['aceita_transferencia']   = $dados['aceita_transferencia'];

            $caixa = FormaPagamento::where('active', '=', 'yes')->where('id', '=', $id)->first();
            $caixa->update($dadosRequest);

            \DB::commit();

            return response()->json(['mensagem' => $caixa, 'class' => 'sucess'], 200);
        } catch (FormaPagamentoException $th) {

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
            $bairro = FormaPagamento::where('active', '=', 'yes')->where('id', '=', $id)->first();
            if ($bairro->vrSaldo == 0) {
                throw new FormaPagamentoException('Este caixa ainda possui saldo.');
            }
            $bairro->update($dadosRequest);
            $bairro->delete();

            \DB::commit();

            return response()->json(['mensagem' => [], 'class' => 'sucess'], 200);
        } catch (FormaPagamentoException $th) {

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

        $isReload           = isset($dados['isReload']) && $dados['isReload'] == true ? $dados['isReload'] : false;
        $pesquisar          = $dados['pesquisar'] ?? null;
        $calback_selected   = $dados['calback_selected'] ?? null;
        $url_pesquisa       = $dados['url_pesquisa'] ?? null;

        if ($isReload) {

            return view('admin.forma_pagamento.head_refresh', compact('isReload', 'pesquisar', 'calback_selected', 'url_pesquisa'));
        } else {
            return view('admin.forma_pagamento.head', compact('isReload', 'calback_selected', 'pesquisar', 'url_pesquisa'));
        }
    }

    protected function validaRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|min:2',
            'type' => 'required',
            'vrMin' => 'required|min:0',
            'vrMax' => 'required|min:0',
        ], [
            'name.required' => 'O campo "DESCRIÇÃO" é obrigatório.',
            'name.max' => 'O "DESCRIÇÃO" suporta até :max caracteres.',
            'name.min' => 'O "DESCRIÇÃO" deve conter pelo menos :min caracteres.',
            'type.required' => 'O campo "TIPO" é obrigatório.',
            'vrMin.min' => 'O "VALOR MÍNIMO" deve conter pelo meno :min caracteres.',
            'vrMax.min' => 'O "VALOR MÁXIMO" deve conter pelo meno :min caracteres.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach ($errors->all() as $mensagem) {
                $msg .= $mensagem . '<br/>';
            }

            throw new FormaPagamentoException($msg);
        }

        return true;
    }
}
