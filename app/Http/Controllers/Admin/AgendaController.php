<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exceptions\AgendaException;
use Illuminate\Support\Facades\Validator;
use App\Profissional;
use App\Agenda;

class AgendaController extends Controller
{
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

            $ordem = $consulta['ordem'] ?? 'id-desc';
            if (!(isset($consulta['ordem']) && strlen($consulta['ordem']) > 0)) {
                $ordem = $consulta['ordem'] = 'id-desc';
            }

            if (!isset($consulta['limite'])) {

                $consulta['limite'] =  500;
            }

            $tpUser     = \Auth::User()->type;
            $pessoaUser = \Auth::User()->pessoa;

            if ($tpUser == 'external') {
                $consulta['pessoa_atendimento_id'] = $pessoaUser->id;
            }

            $campos =  null;

            //$registro = Agenda::where('active', '=', 'yes');

            $parse = [
                'pessoa_name' => 'pessoas.name',
                'name' => 'pessoas.name',
                'id' => 'agendas.id',

            ];


            $registro = \DB::table('agendas')->join('pessoas', function ($join) {

                $join->on('agendas.pessoa_id', '=', 'pessoas.id');
            })->leftJoin("atendimentos as at", function ($join) {
                $join->on("at.id", '=', 'agendas.referencia_id')->where('referencia', '=', 'atendimentos');
            })->leftJoin("pessoas as pa", function ($join) {
                $join->on("pa.id", '=', 'at.pessoa_id');
            });
            //name_especialidade
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

                                $registro->whereIn('agendas.id', $val);
                            }
                            break;
                        case 'status':
                            if (is_string($val)) {

                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }
                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }
                                $val = explode(',', $val);

                                $registro->whereIn('agendas.status', $val);
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

                                $registro->where('pessoa.name', 'like', '%' . $val . '%');
                            }
                            break;

                        case 'pessoa_atendimento_id':
                            if (is_string($val)) {

                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }
                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }
                            }


                            $val = explode(',', $val);

                            $registro->whereIn('at.pessoa_id', $val);

                            break;
                        case 'description_to_search':
                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('name', 'like', '%' . $val . '%');

                            break;
                        case 'codigo_to_search':
                            if (is_string($val)) {

                                if ($val[0] == ',') {
                                    $val = substr($val, 1);
                                }
                                if ($val[strlen($val) - 1] == ',') {
                                    $val = substr($val, 0, -1);
                                }
                                $val = explode(',', $val);

                                $registro->whereIn('agendas.id', $val);
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
                $registro->select('agendas.id', 'agendas.pessoa_id', 'agendas.descricao', 'agendas.data', \DB::raw('DATE_FORMAT(agendas.data, \'%d-%m-%Y\') as data_format'), 'agendas.hora', 'agendas.status', 'pessoas.name as name_pessoa', 'pessoas.name_opcional',  'pessoas.sexo', 'pessoas.email', 'pa.name as  name_pessoa_atendimento', 'pa.id as pessoa_atendimento_id', 'at.historico as historico_atendimento');
            }

            /* $ordemArr   = explode('-', $ordem);
            $oremCampo  = $ordemArr[0];
            $oremTipo  = $ordemArr[1]; */

            $usePaginate = $consulta['usePaginate'] ?? 0;
            $usePaginate = (int) $usePaginate;
            $nrItensPerPage = isset($consulta['nr_itens_per_page']) && $consulta['nr_itens_per_page'] > 0 ? $consulta['nr_itens_per_page'] : 10;
            if ($usePaginate > 0) {
                $registro   = $registro->where('agendas.active', '=', 'yes')
                    ->where('pessoas.active', '=', 'yes')->paginate($nrItensPerPage);
            } else {
                $registro = $registro->where('agendas.active', '=', 'yes')
                    ->where('pessoas.active', '=', 'yes')->get();
            }

            if (isset($consulta['to_require']) && $consulta['to_require'] == true) {
                $dataToRequest = [];
                foreach ($registro as $reg) {
                    $dataToRequest[] = ['label' => $reg->name_pessoa, 'value' => $reg->id];
                }

                $registro = $dataToRequest;
            }


            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (AgendaException $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'teste: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 404);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 500);
        }
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


            $validator = $this->validaRequest($request);

            $registro = null;
            \DB::beginTransaction();

            $dados = $request->all();
            $user_id = \Auth::User()->id;

            $dadosEvento                        = [];
            $dadosEvento['pessoa_id']           = $dados['pessoa_id'];
            $dadosEvento['user_id']             = $user_id;
            $dadosEvento['active']              = 'yes';
            $dadosEvento['filial_id']           = $dados['filial_id'];
            $result = Agenda::create($dadosEvento);

            if (!$result) {

                throw new AgendaException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o supote.');
            }

            if (isset($dados['especialidade_id']) && $dados['especialidade_id'] > 0) {
                $especialidade   = Especialidade::where('active', '=', 'yes')->where('id', '=', $dados['especialidade_id'])->first();

                if (!$especialidade) {
                    throw new AgendaException('Não foi possível identificar a especialidade informada. Tente novamente ou entre em contato com o supote.');
                }

                $dadosEvento                        = [];
                $dadosEvento['especialidade_id']    = $especialidade->id;
                $dadosEvento['profissional_id']     = $result->id;
                $dadosEvento['dt_emiss_doc']        = $dados['dt_emiss_doc'];
                $dadosEvento['dt_vencimento_doc']   = $dados['dt_vencimento_doc'];
                $dadosEvento['nr_doc']              = $dados['nr_doc'];
                $dadosEvento['org_expedidor']       = $dados['org_expedidor'];
                $dadosEvento['user_id']             = $user_id;
                $result->adicionarEspecialidade($especialidade, $dadosEvento);
            }

            \DB::commit();

            return response()->json(['mensagem' => $result, 'class' => 'sucess'], 200);
        } catch (AgendaException $th) {

            \DB::rollback();

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);

            //throw $th;
        } catch (\Exception $th) {
            \DB::rollback();

            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor: ' . $th->getMessage(), 'class' => 'warning'], 500);
            //throw $th;
        }
    }



    public function info(Request $request, $id)
    {

        try {

            $dados = $request->all();
            $id = $id ?? $dados['id'];
            \DB::beginTransaction();

            if ($id <= 0) {

                throw new AgendaException('Parâmetro inválido. Entre em contato com o supote.');
            }

            $registro = null;

            $registro = Agenda::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if ($registro == null) {

                throw new AgendaException('Registro não encontrado.');
            }

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (AgendaException $e) {
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

            if ($id <= 0) {
                throw new AgendaException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = Agenda::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if (!$registro) {
                throw new AgendaException('Registro não encontrado');
            }

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (AgendaException $e) {

            \DB::rollback();

            return response()->json(['errors' => ['error' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 400);
        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 500);
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



            $user_id    = \Auth::User()->id;
            $erros      = [];

            $dados = $request->all();

            $dadosEvento                        = [];
            $dadosEvento['user_update_id']      = $user_id;

            $profissional = Agenda::where('id', '=', $id)->where('active', '=', 'yes')->first();
            if (!$profissional) {
                throw new AgendaException('Evento não identificado');
            }

            $profissional->update($dadosEvento);

            if (isset($dados['especialidade_id']) && $dados['especialidade_id'] > 0) {
                $especialidade   = Especialidade::where('active', '=', 'yes')->where('id', '=', $dados['especialidade_id'])->first();

                if (!$especialidade) {
                    throw new AgendaException('Não foi possível identificar a especialidade informada. Tente novamente ou entre em contato com o supote.');
                }

                $profissional->removeEspecialidade($especialidade);

                $dadosEvento                        = [];
                $dadosEvento['especialidade_id']    = $especialidade->id;
                $dadosEvento['profissional_id']     = $profissional->id;
                $dadosEvento['dt_emiss_doc']        = $dados['dt_emiss_doc'];
                $dadosEvento['dt_vencimento_doc']   = $dados['dt_vencimento_doc'];
                $dadosEvento['nr_doc']              = $dados['nr_doc'];
                $dadosEvento['org_expedidor']       = $dados['org_expedidor'];
                $dadosEvento['user_id']             = $user_id;
                $profissional->adicionarEspecialidade($especialidade, $dadosEvento);
            }

            \DB::commit();
            return response()->json(['mensagem' => $profissional, 'class' => 'success'], 200);
        } catch (AgendaException $e) {
            \DB::rollback();

            return response()->json(['mensagem' => $e->getMessage(), 'class' => 'warning'], 400);

            // return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);

        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['mensagem' => $e->getMessage(), 'class' => 'warning'], 500);

            //return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
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

                // \Session::flash('mensagem', ['msg'=>'Parâmetro ínválido', 'class'=>'alert alert-danger']);

                //return redirect()->route('pessoa.index');
                return response()->json(['mensagem' => 'Erro ao deletar registro', 'class' => 'warning'], 400);
            }

            \DB::beginTransaction();

            $eventoAgenda = Agenda::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();
            if (!$eventoAgenda) {
                throw new AgendaException('Registro não encontrado');
            }

            $eventoAgenda->update(['active' => 'no']);
            $eventoAgenda->delete();

            \DB::commit();
            return response()->json(['mensagem' => 'Registro atulizado com sucesso', 'class' => 'success']);
        } catch (AgendaException $e) {
            \DB::rollback();

            return response()->json(['mensagem' => $e->getMessage(), 'class' => 'warning'], 400);

            // return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);

        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['mensagem' => $e->getMessage(), 'class' => 'warning'], 500);

            //return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }

    protected function validaRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pessoa_id' => 'required|min:1',
        ], [
            'pessoa_id.required' => 'O campo "PROFISSIONAL" é obrigatório.',
            'pessoa_id.min' => 'O "PROFISSIONAL" deve ser maior ou igual a :min.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach ($errors->all() as $mensagem) {
                $msg .= $mensagem . '<br/>';
            }

            throw new AgendaException($msg);
        }

        return true;
    }
}
