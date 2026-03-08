<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\FormularioException;
use App\Formulario;
use App\FormularioGrupo;
use App\Helpers\FormularioHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormularioController extends Controller
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

            $objFormularioHelper = new FormularioHelper();
            $registro = $objFormularioHelper->load($consulta);

            \DB::commit();

            return view('admin.formulario.index', compact('registro', 'consulta'));
        } catch (FormularioException $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);

        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
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

            $dados = $request->all();
            $objFormularioHelper = new FormularioHelper();
            $registro = $objFormularioHelper->store($dados);

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);

        } catch (FormularioException $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage()], 404);
        } catch (\Error $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
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

            \DB::beginTransaction();

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

            $registro = Formulario::where('active', '=', 'yes')->where('id', '=', $id)->first();
            if (! $registro) {
                throw new FormularioException('Registro não encontrado');
            }
            \DB::commit();

            return view('admin.formulario.container', compact('registro', 'idAssistente', 'callBack'));

        } catch (FormularioException $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);

        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }


    public function info(Request $request, $id)
    {

        try {


            $dados = $request->all();
            $id = $id ?? $dados['id'];
            $callBack = $dados['callBack'] ?? '';
            if ($id <= 0) {
                throw new FormularioException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = Formulario::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

            if ($registro == null) {
                throw new FormularioException(' não encontrado');
            }
            $registro->grupo;

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);

        } catch (FormularioException $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 404);

        } catch (\Error $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 404);

        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ], 500);
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
            $dataGrupos     = $dados['grupos'] ?? [];

            if ((!isset($id)) || ($id <= 0)) {
                return response()->json(['errors' => ['error' => 'Parâmetro inválido']], 400);
            }

            $registro = Formulario::where('active', '=', 'yes')->where('id', '=', $id)->first();

            $dadosRequest = [];
            $dadosRequest['name']               = $dados['name'];
            $dadosRequest['user_update_id']     = \Auth::User()->id;
            $registro->update($dadosRequest);


            if (! $registro) {
                throw new FormularioException('Registro não encontrado');
            }
            $gruposForm = $registro->grupo;

            $idGruposUpdated = [];
            foreach ($dataGrupos as $key => $val) {
                if (isset($val['id']) && $val['id'] > 0) {
                    $grupo = FormularioGrupo::where('active', '=', 'yes')->where('id', '=', $val['id'])->first();
                    if ($grupo) {
                        $idGruposUpdated[$val['id']] = $val['id'];
                        $dadosRequest = [];
                        $dadosRequest['name']               = $val['name'];
                        $dadosRequest['nr_ordem']           = $val['nr_ordem'];
                        $dadosRequest['props_grupo']        = $val['props_grupo'] ?? null;
                        $dadosRequest['user_update_id']     = \Auth::User()->id;
                        $grupo->update($dadosRequest);
                    }
                } else {

                    $dadosRequest = [];
                    $dadosRequest['name']               = $val['name'];
                    $dadosRequest['nr_ordem']           = $val['nr_ordem'];
                    $dadosRequest['formulario_id']      = $registro->id;
                    $dadosRequest['props_grupo']        = $val['props_grupo'] ?? null;
                    $dadosRequest['user_id']            = \Auth::User()->id;//trocar pelo id do usuario logado
                    $dadosRequest['active']             = 'yes';

                    $formGroup                          = FormularioGrupo::create($dadosRequest);
                    if (! $formGroup) {
                        throw new FormularioException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o suporte.');
                    }

                }

            }

            if ($gruposForm) {
                foreach ($gruposForm as $grupo) {
                    if (isset($grupo->id) && $grupo->id > 0 && !in_array($grupo->id, $idGruposUpdated)) {
                        $grupo->update(['active' => 'no']);
                    }
                }
            }

            \DB::commit();
            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);

        } catch (FormularioException $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);

        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
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

            $registro = Formulario::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();
            if (! $registro) {
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

        } catch (FormularioException $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage()], 404);
        } catch (\Error $e) {
            \DB::rollback();
            return response()->json(['mensagem' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
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
            $objFormularioHelper = new FormularioHelper();
            $registro = $objFormularioHelper->load($consulta);

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'success'], 201);

        } catch (FormularioException $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);

        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
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
                $msg .= $mensagem.'<br/>';
            }

            throw new FormularioException($msg);
        }

        return true;
    }
}
