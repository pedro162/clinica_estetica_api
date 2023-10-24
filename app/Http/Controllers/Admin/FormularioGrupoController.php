<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Formulario;
use \App\Marca;
use \App\Categoria;
use \App\Exceptions\FormularioGrupoException;
use \App\FormularioGrupo;
use \App\FormularioItem;
use Illuminate\Support\Facades\Auth;
use App\Helpers\FormularioGrupoHelper;


class FormularioGrupoController extends Controller
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

            $dataItems = $dados['items'] ?? [];

            if (is_array($dataItems) && count($dataItems) > 0) {
                foreach ($dataItems as $datIt) {
                    $this->validaDadosItemRequest($datIt);
                }
            } else {
                throw new FormularioGrupoException("Informe os campos do formulário, por favor.");
            }

            $dadosRequest = [];

            $dadosRequest['name']               = $dados['name'];
            $dadosRequest['user_id']            = \Auth::User()->id; //trocar pelo id do usuario logado
            $dadosRequest['active']             = 'yes';

            $form = FormularioGrupo::create($dadosRequest);

            foreach ($dataItems as $key => $val) {
                $dadosRequest                           = [];
                $dadosRequest['name']                   = $val['name'];
                $dadosRequest['type']                   = $val['type'];
                $dadosRequest['options']                = $val['options']       ?? null;
                $dadosRequest['default_value']          = $val['default_value'] ?? null;
                $dadosRequest['props']                  = $val['props']         ?? null;
                $dadosRequest['label']                  = $val['label'];
                $dadosRequest['props_label']            = $val['props_label']   ?? null;
                $dadosRequest['nr_linha']               = $val['nr_linha']      ?? null;
                $dadosRequest['nr_coluna']              = $val['nr_coluna']     ?? null;
                $dadosRequest['formulario_grupo_id']    = $form->id;
                $dadosRequest['formulario_id']          = $form->formulario->id;
                $dadosRequest['user_id']                = \Auth::User()->id; //trocar pelo id do usuario logado
                $dadosRequest['active']                 = 'yes';

                $formGroup                          = FormularioItem::create($dadosRequest);
                if (!$formGroup) {
                    throw new FormularioGrupoException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o suporte.');
                }
            }


            \DB::commit();

            if (!$form) {
                throw new FormularioGrupoException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o suporte.');
            }

            return response()->json(['mensagem' => $form, 'class' => 'success'], 200);
        } catch (FormularioGrupoException $e) {
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
                throw new FormularioGrupoException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = FormularioGrupo::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if ($registro == null) {
                throw new FormularioGrupoException(' não encontrado');
            }
            $itens = $registro->item()->where('active', '=', 'yes')->get();
            $registro->item = $itens;

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);
        } catch (FormularioGrupoException $e) {
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
            $dataItems      = $dados['items'] ?? [];

            if ((!isset($id)) || ($id <= 0)) {
                return response()->json(['errors' => ['error' => 'Parâmetro inválido']], 400);
            }
            if (is_array($dataItems) && count($dataItems) > 0) {
                foreach ($dataItems as $datIt) {
                    $this->validaDadosItemRequest($datIt);
                }
            } else {
                throw new FormularioGrupoException("Informe os campos do formulário, por favor.");
            }


            $registro = FormularioGrupo::where('active', '=', 'yes')->where('id', '=', $id)->first();

            $dadosRequest = [];
            $dadosRequest['name']               = $dados['name'];
            $dadosRequest['user_update_id']     = \Auth::User()->id;
            $registro->update($dadosRequest);


            if (!$registro) {
                throw new FormularioGrupoException('Registro não encontrado');
            }
            $itensForm = $registro->item;

            $idItensUpdated = [];
            foreach ($dataItems as $key => $val) {
                if (isset($val['id']) && $val['id'] > 0) {
                    $grupo = FormularioItem::where('active', '=', 'yes')->where('id', '=', $val['id'])->first();
                    if ($grupo) {
                        $idItensUpdated[$val['id']] = $val['id'];
                        $dadosRequest = [];
                        $dadosRequest['name']                   = $val['name'];
                        $dadosRequest['type']                   = $val['type'];
                        $dadosRequest['options']                = $val['options']       ?? null;
                        $dadosRequest['default_value']          = $val['default_value'] ?? null;
                        $dadosRequest['props']                  = $val['props']         ?? null;
                        $dadosRequest['label']                  = $val['label'];
                        $dadosRequest['props_label']            = $val['props_label']   ?? null;
                        $dadosRequest['nr_linha']               = $val['nr_linha']      ?? null;
                        $dadosRequest['nr_coluna']              = $val['nr_coluna']     ?? null;
                        $dadosRequest['user_update_id']     = \Auth::User()->id;
                        $grupo->update($dadosRequest);
                    }
                } else {
                    $dadosRequest                           = [];
                    $dadosRequest['name']                   = $val['name'];
                    $dadosRequest['type']                   = $val['type'];
                    $dadosRequest['options']                = $val['options']       ?? null;
                    $dadosRequest['default_value']          = $val['default_value'] ?? null;
                    $dadosRequest['props']                  = $val['props']         ?? null;
                    $dadosRequest['label']                  = $val['label'];
                    $dadosRequest['props_label']            = $val['props_label']   ?? null;
                    $dadosRequest['nr_linha']               = $val['nr_linha']      ?? null;
                    $dadosRequest['nr_coluna']              = $val['nr_coluna']     ?? null;
                    $dadosRequest['formulario_grupo_id']    = $registro->id;
                    $dadosRequest['formulario_id']          = $registro->formulario->id;
                    $dadosRequest['user_id']                = \Auth::User()->id; //trocar pelo id do usuario logado
                    $dadosRequest['active']                 = 'yes';

                    $formGroup                          = FormularioItem::create($dadosRequest);
                    if (!$formGroup) {
                        throw new FormularioGrupoException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o suporte.');
                    }
                }
            }

            if ($itensForm) {
                foreach ($itensForm as $item) {
                    if (isset($item->id) && $item->id > 0 && !in_array($item->id, $idItensUpdated)) {
                        $item->update(['active' => 'no']);
                    }
                }
            }

            \DB::commit();
            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);
        } catch (FormularioGrupoException $e) {
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

            $registro = FormularioGrupo::where('active', '=', 'yes')
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
        } catch (FormularioGrupoException $e) {
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
        $dados = $request->all();

        $isReload = isset($dados['isReload']) && $dados['isReload'] == true ? $dados['isReload'] : false;
        if ($isReload) {

            return view('admin.formulario.head_refresh', compact('isReload'));
        } else {
            return view('admin.formulario.head', compact('isReload'));
        }
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

            $data = $request->all();
            $objFormGrupoHelper = new FormularioGrupoHelper();
            $registro = $objFormGrupoHelper->listar($data);

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'success'], 201);
        } catch (FormularioGrupoException $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'teste: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 500);
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

            throw new FormularioGrupoException($msg);
        }

        return true;
    }

    protected function validaDadosItemRequest(array $dados)
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

            throw new FormularioGrupoException($msg);
        }

        return true;
    }
}
