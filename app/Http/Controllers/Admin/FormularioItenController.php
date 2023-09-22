<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Formulario;
use \App\Marca;
use \App\Categoria;
use \App\Exceptions\FormularioItenException;
use \App\FormularioGrupo;
use \App\FormularioItem;
use Illuminate\Support\Facades\Auth;

class FormularioItenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $idAssistente)
    {
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


            set_time_limit(9000000);

            \DB::beginTransaction();

            $this->validaRequest($request);

            $sentinela = null;
            $dados = $request->all();

            $dadosRequest = [];

            $dadosRequest                           = [];
            $dadosRequest['name']                   = $dados['name'];
            $dadosRequest['type']                   = $dados['type'];
            $dadosRequest['options']                = $dados['options']       ?? null;
            $dadosRequest['default_value']          = $dados['default_value'] ?? null;
            $dadosRequest['props']                  = $dados['props']         ?? null;
            $dadosRequest['label']                  = $dados['label'];
            $dadosRequest['props_label']            = $dados['props_label']   ?? null;
            $dadosRequest['nr_linha']               = $dados['nr_linha']      ?? null;
            $dadosRequest['nr_coluna']              = $dados['nr_coluna']     ?? null;
            $dadosRequest['formulario_grupo_id']    = $form->id;
            $dadosRequest['formulario_id']          = $form->formulario->id;
            $dadosRequest['user_id']                = \Auth::User()->id; //trocar pelo id do usuario logado
            $dadosRequest['active']                 = 'yes';

            $form = FormularioGrupo::create($dadosRequest);

            \DB::commit();

            if (!$form) {
                throw new FormularioItenException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o suporte.');
            }

            return response()->json(['mensagem' => $form, 'class' => 'success'], 200);
        } catch (FormularioItenException $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 404);
        } catch (\Error $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 500);
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
    }


    public function info(Request $request, $id)
    {

        try {


            $dados = $request->all();
            $id = $id ?? $dados['id'];
            $callBack = $dados['callBack'] ?? '';
            if ($id <= 0) {
                throw new FormularioItenException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = FormularioGrupo::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if ($registro == null) {
                throw new FormularioItenException(' não encontrado');
            }
            $itens = $registro->item()->where('active', '=', 'yes')->get();
            $registro->item = $itens;

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);
        } catch (FormularioItenException $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 404);
        } catch (\Error $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 500);
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
            if (!isset($id)) {
                $id = isset($dadosRequest['id']) ? $dadosRequest['id'] : 0;
            }

            if ($id <= 0) {
            }
        } catch (\Exception $e) {

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

            $id             = $id ?? $dados['id'];
            $callBack       = $dados['callBack'] ?? '';
            $idAssistente   =  $idAssistente ?? $dados['idAssistente'] ?? '';

            if ((!isset($id)) || ($id <= 0)) {
                return response()->json(['errors' => ['error' => 'Parâmetro inválido']], 400);
            }

            $registro = FormularioItem::where('active', '=', 'yes')->where('id', '=', $id)->first();

            $dadosRequest = [];
            $dadosRequest['name']                   = $dados['name'];
            $dadosRequest['type']                   = $dados['type'];
            $dadosRequest['options']                = $dados['options']       ?? null;
            $dadosRequest['default_value']          = $dados['default_value'] ?? null;
            $dadosRequest['props']                  = $dados['props']         ?? null;
            $dadosRequest['label']                  = $dados['label'];
            $dadosRequest['props_label']            = $dados['props_label']   ?? null;
            $dadosRequest['nr_linha']               = $dados['nr_linha']      ?? null;
            $dadosRequest['nr_coluna']              = $dados['nr_coluna']     ?? null;
            $dadosRequest['user_update_id']         = \Auth::User()->id;
            $registro->update($dadosRequest);


            if (!$registro) {
                throw new FormularioItenException('Registro não encontrado');
            }


            \DB::commit();
            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);
        } catch (FormularioItenException $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 404);
        } catch (\Error $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 500);
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

            if ($id <= 0) {
                return response()->json([['mensagem' => 'Parâmetro inválido', 'class' => 'warning'], 400]);
            }

            $registro = FormularioItem::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();
            if (!$registro) {
                return response()->json(['mensagem' => 'Erro ao exclir registro', 'class' => 'warning'], 400);
            } else {

                $registro = $registro->update(['active' => 'no']);
            }

            if ($registro == null) {

                //\Session::flash('mensagem', ['msg'=>' não encontrado', 'class'=>'alert alert-danger']);
                //return redirect()->back();
                return response()->json(['mensagem' => 'Erro ao exclir registro', 'class' => 'warning'], 400);
            }

            \DB::commit();
            return response()->json(['mensagem' => 'Registro deletado com sucesso', 'class' => 'success'], 200);
        } catch (FormularioItenException $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 404);
        } catch (\Error $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()], 500);
        }
    }

    public function head(Request $request)
    {
    }


    /**
     * Return a listing of the resource in json.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function json(Request $request)
    {
        try {

            //$this->validaRequest($request);

            \DB::beginTransaction();

            $consulta = $request->all();
            //dd($consulta);
            $ordem = $consulta['ordem'] ?? 'formg.id-desc';
            $parse = [];

            $registro = \DB::table('formulario_items as formit')
                ->join('formulario_grupos as formg', function ($join) {
                    $join->on('formg.id', '=', 'formit.formulario_id');
                });

            /**
             * ->join('forma_pagamentos as fp', function($join){                
                $join->on('fp.id', '=', 'conta_recebers.forma_pagamento_id');

            });
             */

            $campos =  null;
            if (is_array($consulta) && count($consulta) > 0) {
                foreach ($consulta as $key => $val) {

                    switch (trim($key)) {
                        case 'id':
                            $val = explode(',', trim($val, ','));

                            $registro->whereIn('formit.id', $val);
                            break;
                        case 'formulario_grupo_id':

                            $val = explode(',', trim($val, ','));
                            $registro->whereIn('formit.formulario_grupo_id', $val);

                            break;
                        case 'nome_item':
                            if (is_string($val)) {

                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }
                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('formit.name', 'like', '%' . $val . '%');
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
                $registro->select('formit.*', 'formg.name as name_form');
            }

            $registro = $registro->where('formit.active', '=', 'yes')->where('formg.active', '=', 'yes');

            //---Ordenação dos dados
            $ordemArr   = explode(',', $ordem);
            if (is_array($ordemArr) && count($ordemArr) > 0) {
                foreach ($ordemArr as $val) {
                    $ordemFieldArr   = explode('-', $val);
                    if (is_array($ordemFieldArr) && count($ordemFieldArr) > 0) {
                        $ordemCampo  = $ordemFieldArr[0];
                        $ordemTipo  = $ordemFieldArr[1];
                        switch (trim($ordemCampo)) {
                            case 'id':
                                $ordemCampo  = 'formit.id';
                                break;
                            default:
                                $ordemCampo  = $ordemFieldArr[0];
                        }

                        $registro->orderBy($ordemCampo, $ordemTipo);
                    }
                }
            }




            //$registro = \App\::where('active', '=', 'yes')->get();
            $registro = $registro->get();


            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'success'], 201);
        } catch (FormularioItenException $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'teste: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 500);
        }
    }



    protected function validaRequest(array $dados)
    {
        $validator = Validator::make($dados, [
            'name' => 'required|max:255|min:2',
            'type' => 'required|max:255|min:2',
            'label' => 'required|max:255|min:2',
        ], [
            'name.required' => 'O campo "DESCRIÇÃO" é obrigatório.',
            'name.max' => 'O "DESCRIÇÃO" suporta até :max caracteres.',
            'name.min' => 'O "DESCRIÇÃO" deve conter pelo menos :min caracteres.',
            'type.required' => 'O campo "TIPO" dos itens do formulário é obrigatório.',
            'type.max' => 'O "TIPO" dos itens do formulário suporta até :max caracteres.',
            'type.min' => 'O "TIPO" dos itens do formulário deve conter pelo menos :min caracteres.',
            'label.required' => 'O campo "LABEL" dos itens do formulário é obrigatório.',
            'label.max' => 'O "LABEL" dos itens do formulário suporta até :max caracteres.',
            'label.min' => 'O "LABEL" dos itens do formulário deve conter pelo menos :min caracteres.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach ($errors->all() as $mensagem) {
                $msg .= $mensagem . '<br/>';
            }

            throw new FormularioItenException($msg);
        }

        return true;
    }
}
