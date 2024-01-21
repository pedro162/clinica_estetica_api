<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Formulario;
use \App\Marca;
use \App\Categoria;
use \App\Exceptions\PessoaFichaExcepton;
use \App\FormularioGrupo;
use \App\Servico;
use \App\PessoaFormulario;
use \App\Pessoa;
use \App\Filial;
use \App\Profissional;
use \App\Rca;
use \App\Utilitarios;
use \App\MotivoCancelamentoOrdemServico;
use \App\Helpers\PessoaFichaHelper;
use \App\Helpers\PessoaFichaRespostaHelper;
use Illuminate\Support\Facades\Auth;

class PessoaFichaController extends Controller
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

            $dados = $request->all();

            $pessoaFichaHelper = new PessoaFichaHelper();
            $form = $pessoaFichaHelper->create($dados);
            \DB::commit();

            if (!$form) {
                throw new PessoaFichaExcepton('Não foi possível concluir a operação. Tente novamente ou entre em contato com o suporte.');
            }

            return response()->json(['mensagem' => $form, 'class' => 'success'], 200);
        } catch (PessoaFichaExcepton $e) {
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cancelar(Request $request, $id)
    {

        try {


            $this->validaCancelarRequest($request);

            \DB::beginTransaction();

            $dados = $request->all();

            $id             = $id ?? $dados['id'];
            $callBack       = $dados['callBack'] ?? '';
            $idAssistente   =  $idAssistente ?? $dados['idAssistente'] ?? '';

            if ((!isset($id)) || ($id <= 0)) {
                throw new PessoaFichaExcepton('Parâmetro inválido');
            }

            $registro = PessoaFormulario::where('active', '=', 'yes')->where('id', '=', $id)->first();
            if (!$registro) {
                throw new PessoaFichaExcepton('Ordem de serviço não identificada. Tente novamente ou entre em contato com o suporte.');
            }

            $idMotivoCancel = $dados['motivo_cancel_id'] ?? 0;

            $objOrdemHelper = new PessoaFichaHelper();
            $registro       = $objOrdemHelper->cancelar($registro);

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);
        } catch (PessoaFichaExcepton $e) {
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

            \DB::beginTransaction();

            $objPessoaFichaHelper = new PessoaFichaHelper();
            $registro = $objPessoaFichaHelper->info($dados, $id);

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);
        } catch (PessoaFichaExcepton $e) {
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

            //$this->validaRequest($request);

            \DB::beginTransaction();

            $dados = $request->all();

            $id             = $id ?? $dados['id'];
            $callBack       = $dados['callBack'] ?? '';
            $idAssistente   =  $idAssistente ?? $dados['idAssistente'] ?? '';

            if ((!isset($id)) || ($id <= 0)) {
                throw new PessoaFichaExcepton('Parâmetro inválido');
            }

            $dados = $request->all();

            $pessoaFichaHelper = new PessoaFichaHelper();
            $registro = $pessoaFichaHelper->create($dados, $id);
            if (!$registro) {
                throw new PessoaFichaExcepton('Registro não encontrado');
            }


            \DB::commit();
            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);
        } catch (PessoaFichaExcepton $e) {
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
                throw new PessoaFichaExcepton('Parâmetro inválido');
            }

            $registro = PessoaFormulario::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();
            if (!$registro) {
                throw new PessoaFichaExcepton('Erro ao exclir registro');
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
        } catch (PessoaFichaExcepton $e) {
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

            if (!(isset($consulta['ordem']) && strlen($consulta['ordem']) > 0)) {
                $consulta['ordem'] = 'id-desc';
            }

            $tpUser     = \Auth::User()->type;
            $pessoaUser = \Auth::User()->pessoa;

            if($tpUser == 'external'){
                $consulta['pessoa_id'] = $pessoaUser->id;
            }


            $parse = [];

            $registro = \DB::table('pessoa_formularios as pf')->join('pessoas as pes', function ($join) {

                $join->on('pf.pessoa_id', '=', 'pes.id');
            })->join('filials as fl', function ($join) {

                $join->on('pf.filial_id', '=', 'fl.id');
            })->join('pessoas as pesfl', function ($join) {

                $join->on('fl.pessoa_id', '=', 'pesfl.id');
            })->join('profissionals as prf', function ($join) {

                $join->on('pf.profissional_id', '=', 'prf.id');
            })->join('pessoas as pesprf', function ($join) {

                $join->on('prf.pessoa_id', '=', 'pesprf.id');
            })->join('formularios as form', function ($join) {

                $join->on('form.id', '=', 'pf.formulario_id');
            });

            $campos =  null;
            if (is_array($consulta) && count($consulta) > 0) {
                foreach ($consulta as $key => $val) {

                    switch (trim($key)) {
                        case 'id':

                            $val = trim($val, ',');
                            $val = explode(',', $val);

                            $registro->whereIn('pf.id', $val);
                            break;
                        case 'name_pessoa':
                            if (is_string($val)) {

                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }
                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('pes.name', 'like', '%' . $val . '%');
                            }
                            break;
                        case 'pessoa_id':

                            $val = trim($val, ',');
                            $val = explode(',', $val);

                            $registro->whereIn('pf.pessoa_id', $val);
                            break;

                        case 'name_form':
                            if (is_string($val)) {

                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }
                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('form.name', 'like', '%' . $val . '%');
                            }
                            break;
                        case 'sigiloso':
                            if (is_string($val)) {

                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }
                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }

                                $registro->where('pf.sigiloso', '=', $val);
                            }
                            break;
                        case 'status':

                            $val = trim($val, ',');
                            $val = explode(',', $val);

                            $registro->whereIn('pf.status', $val);
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
                                } else {
                                    $registro->orderBy($atual[0], $atual[1]);
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
                $registro->select('pf.*', 'pes.name', 'pesfl.name as name_filial', 'pesprf.name as name_profissional', 'form.name as name_form');
            }
            //$registro = \App\::where('active', '=', 'yes')->get();
            /* $ordemArr   = explode('-', $ordem);

            $oremCampo  = $ordemArr[0];
            $oremTipo  = $ordemArr[1]; */

            //$registro   = $registro->where('pf.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->get();

            $registro   = $registro->where('pf.active', '=', 'yes')->get();


            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'success'], 201);
        } catch (PessoaFichaExcepton $e) {
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
            'filial_id' => 'required|min:1',
            'pessoa_id' => 'required|min:1',
        ], [
            'filial_id.required' => 'O campo "Filial" é obrigatório.',
            'filial_id.min' => 'O "Filial" deve conter pelo menos :min caracteres.',
            'pessoa_id.required' => 'O campo "Pessoa" é obrigatório.',
            'pessoa_id.min' => 'O "Pessoa" deve conter pelo menos :min caracteres.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach ($errors->all() as $mensagem) {
                $msg .= $mensagem . '<br/>';
            }

            throw new PessoaFichaExcepton($msg);
        }

        return true;
    }



    protected function validaCancelarRequest(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'motivo_cancel_id' => 'required|min:',
        ], [
            'motivo_cancel_id.required' => 'O campo "Motivo de cancelamento" é obrigatório.',
            'motivo_cancel_id.min' => 'O "Motivo de cancelamento" deve ser maior ou igual a :min.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach ($errors->all() as $mensagem) {
                $msg .= $mensagem . '<br/>';
            }

            throw new PessoaFichaExcepton($msg);
        }

        return true;
    }
}
