<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Http\Requests\PessoaRequest;
use \App\Pessoa;
use \App\Grupo;
use \App\Telefone;
use \App\Logradouro;
use \App\Utilitarios;
use \App\CobrancaReceber;
use \App\FormaPagamento;
use \App\PlanoPagamento;
use \App\OperadorFinanceiro;
use \App\OrdemServico;
use \App\Filial;
use \App\VendaItem;
use \App\Venda;
use \App\ServicoItem;
use \App\Servico;
use \App\Plano;
use App\Exceptions\PessoaException;
use App\Helpers\PessoaHelper;

class PessoaController extends Controller
{
    protected function requestPessoa(Request $request)
    {
        $validador = Validator::make($request->all(), [

            'name'          => 'required|max:255|min:3',
            'documento'     => 'required|max:14'

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
    }

    public function json(Request $request)
    {

        try {
            \DB::beginTransaction();

            $consulta = $request->all();

            $objPessHelper = new PessoaHelper();
            $registro = $objPessHelper->json($consulta);
            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (PessoaException $e) {
            \DB::rollback();
            return response()->json(['errors' => ['error' => 'teste: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 404);
        } catch (\Exception $e) {
            \DB::rollback();
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
        try {

            $dadosRequest = $request->all();

            $callBack = $dadosRequest['callBack'] ?? '';
            $idAssistente =  $idAssistente ?? $dadosRequest['idAssistente'] ?? '';

            $grupos = Grupo::where('active', '=', 'yes')->get();

            return view('admin.pessoa.create', compact('grupos', 'callBack', 'idAssistente'));
        } catch (PessoaException $e) {
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

            $dadosPessoa     = $request->only(
                'name',
                'name_opcional',
                'documento',
                'documento_complementar',
                'nascimento_fundacao',
                'sexo',
                'email'
            );

            $cpf = preg_replace("/[^0-9]/", '', trim($dadosPessoa['documento']));
            $dadosPessoa['documento'] = $cpf;
            if (Pessoa::where('documento', '=', $cpf)->first()) {

                throw new PessoaException('Pessoa já se encontra cadastrada.');
            } else {

                $dadosPessoa['user_id']     = \Auth::User()->id;
                $dadosPessoa['tipo']        = 'fisica';
                $dadosPessoa['active']      = 'yes';

                $grupo = Grupo::where('id', '=', $dados['groupo_id'])
                    ->where('active', '=', 'yes')->first();


                $dadosLogradoruo = $request->only(
                    'cep',
                    'logradouro',
                    'numero',
                    'tipo',
                    'complemento',
                    'bairro',
                    'cidade',
                    'estado',
                    'bloco'
                );
                $dadosLogradoruo['user_id']  = $user_id;
                $dadosLogradoruo['active']   = 'yes';
                $dadosLogradoruo['importancia']   = 'principal';


                $dadosContato       = $request->only('celular_1', 'celular_2', 'telefone');

                $pessoa             = Pessoa::create($dadosPessoa);
                $logradouro         = Logradouro::create($dadosLogradoruo);
                $resultLogradouro   = $pessoa->adicionarLogradouro($logradouro, ['active' => 'yes', 'user_id' => $user_id]);
                $resultGrupoPessoa  = $pessoa->adicionarGrupo($grupo, ['active' => 'yes', 'user_id' => $user_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);

                foreach ($dadosContato as $key => $value) {
                    $tipo = $key == 'telefone' ? 'fixo' : 'celular';
                    $contato        = Telefone::create([
                        'numero' => $value ?? '00000000000', 'tipo' => $tipo, 'user_id' => $user_id,
                        'active' => 'yes', 'pessoa_id' => $pessoa->id
                    ]);
                }

                if (
                    $pessoa
                    && $logradouro
                    && $contato
                ) {
                    $registro = $pessoa;
                }
            }
            if (!$registro) {

                //\Session::flash('mensagem', ['msg'=>'Registro salvo com sucesso', 'class'=>'alert alert-success']);
                //return redirect()->route('marca.head');

                throw new PessoaException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o supote.');
            }

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (PessoaException $th) {

            \DB::rollback();

            return response()->json(['mensagem' => $th->getMessage(), 'class' => 'warning'], 400);

            //throw $th;
        } catch (\Exception $th) {
            \DB::rollback();

            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor: ' . $th->getMessage(), 'class' => 'warning'], 500);
            //throw $th;
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
        try {


            if ($id <= 0) {

                throw new PessoaException('Parâmetro inválido. Entre em contato com o supote.');
            }

            \DB::beginTransaction();

            $registro = Pessoa::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            //dd($registro);

            if (!$registro) {

                throw new PessoaException('Registro não encontrado.');
            }

            \DB::commit();

            //return view('admin.produto.info', compact('registro'));
            return view('admin.pessoa.show', compact('registro'));
        } catch (PessoaException $e) {
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


    public function info(Request $request, $id)
    {

        try {

            $dados = $request->all();
            $id = $id ?? $dados['id'];
            \DB::beginTransaction();

            $objPessHelper = new PessoaHelper();

            $registro = $objPessHelper->info($dados, $id);

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (PessoaException $e) {
            \DB::rollback();

            //$msg = $e->getMessage();
            //return view('layouts._admin._error', compact('msg'));

            return response()->json(['mensagem' => $this->getMessage(), 'class' => 'warning'], 400);
        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 500);
        }
    }


    public function lastFichaInfo(Request $request, $id)
    {

        try {

            $dados = $request->all();
            $id = $id ?? $dados['id'];
            \DB::beginTransaction();

            if ($id <= 0) {

                throw new PessoaException('Parâmetro inválido. Entre em contato com o supote.');
            }

            $registro = null;

            $registro = Pessoa::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if ($registro == null) {

                throw new PessoaException('Registro não encontrado.');
            }
            /*
            if($logr = $registro->logradouro->where('importancia', '=', 'principal')->first()){
                $registro->logradouro = $logr->estado_logradouro->pais;
            }
            
            $registro->grupo;
            $registro->telefone;*/
            if ($logr = $registro->logradouro->where('importancia', '=', 'principal')->first()) {
                //return response()->json(['mensagem' => $logr, 'class' => 'sucess'], 200);
                $registro->logradouro = $logr->estado_logradouro->pais;
            }

            $resultForm = $registro->formulario()->where('active', '=', 'yes')->orderBy('pessoa_formularios.id', 'desc')->offset(0)->limit(1)->first();
            if ($resultForm) {
                $resposta = $resultForm->resposta()->orderBy('nr_linha', 'asc')->orderBy('nr_coluna', 'asc')->orderBy('form_item_id', 'asc')->orderBy('pessoa_formulario_respostas.id', 'asc')->get();
                if ($resposta) {
                    foreach ($resposta as $val) {
                        $val->formitem;
                    }
                }
                //$resposta->formitem;
                $resultForm->resposta = $resposta;
            }
            $registro->formulario = $resultForm;
            //dd($registro);

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (PessoaException $e) {
            \DB::rollback();

            //$msg = $e->getMessage();
            //return view('layouts._admin._error', compact('msg'));

            return response()->json(['mensagem' => $this->getMessage(), 'class' => 'warning'], 400);
        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['errors' => ['error' => 'Algo errado aconteceu no servidor: ' . $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()]], 500);
        }
    }
    /*
        {"mensagem":{"id":1,"name":"Jos\u00e9 Pedro","name_opcional":"Ferreira","documento":"61224450370","documento_complementar":"123456","email":"phedroclooney@gmail.com","nascimento_fundacao":null,"sexo":"m","tipo":"fisica","user_id":1,"user_update_id":1,"active":"yes","created_at":"2022-07-19T02:12:31.000000Z","updated_at":"2022-10-08T23:46:26.000000Z","logradouro":[{"id":1,"cep":"65061-220","cidade":"S\u00e3o luis","logradouro":"Rua S\u00e3o Sebasti\u00e3o","bairro":"Ipase","estado":"1","complemento":"teste","numero":"123","bloco":null,"tipo":"casa","importancia":"principal","user_id":1,"user_update_id":null,"active":"yes","deleted_at":null,"created_at":"2022-07-19T02:12:31.000000Z","updated_at":"2022-07-19T02:12:31.000000Z","pivot":{"pessoa_id":1,"logradouro_id":1},"estado_logradouro":{"id":1,"nmEStado":"Maranh\u00e3o","codEstado":"98","sigla":"MA","padrao":"yes","pais_id":1,"user_id":1,"user_update_id":1,"active":"yes","deleted_at":null,"created_at":"2022-07-19T02:08:36.000000Z","updated_at":"2022-07-19T02:08:36.000000Z","pais":{"id":1,"nmPais":"BRASIL","cdPais":"55","padrao":"yes","user_id":1,"user_update_id":1,"active":"yes","deleted_at":null,"created_at":"2022-07-19T02:07:34.000000Z","updated_at":"2022-07-19T02:07:34.000000Z"}}}],"grupo":[{"id":1,"name":"Cliente","descricao":"Cliente","user_id":1,"user_update_id":null,"active":"yes","deleted_at":null,"created_at":"2022-07-19T02:11:11.000000Z","updated_at":"2022-07-19T02:11:11.000000Z","pivot":{"pessoa_id":1,"groupo_id":1}}],"telefone":[{"id":1,"numero":"(98) 98425-7623","tipo":"celular","whatsapp":"nao","importancia":"principal","pessoa_id":1,"user_id":1,"user_update_id":null,"active":"yes","deleted_at":null,"created_at":"2022-07-19T02:12:31.000000Z","updated_at":"2022-07-19T02:12:31.000000Z"},{"id":2,"numero":"(98) 98425-7623","tipo":"celular","whatsapp":"nao","importancia":"principal","pessoa_id":1,"user_id":1,"user_update_id":null,"active":"yes","deleted_at":null,"created_at":"2022-07-19T02:12:31.000000Z","updated_at":"2022-07-19T02:12:31.000000Z"},{"id":3,"numero":"9894239891","tipo":"fixo","whatsapp":"nao","importancia":"principal","pessoa_id":1,"user_id":1,"user_update_id":null,"active":"yes","deleted_at":null,"created_at":"2022-07-19T02:12:31.000000Z","updated_at":"2022-07-19T02:12:31.000000Z"}]},"class":"sucess"}
    */
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
                throw new PessoaException('Parâmetro ínválido');
            }

            \DB::beginTransaction();

            $registro = Pessoa::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();

            if (!$registro) {
                throw new PessoaException('Registro não encontrado');
            }

            \DB::commit();

            return response()->json(['mensagem' => $registro, 'class' => 'sucess'], 200);
        } catch (PessoaException $e) {

            \DB::rollback();

            $msg = $e->getMessage();
            return view('layouts._admin._error', compact('msg'));

            // return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);

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



            $registro   = null;
            $user_id    = \Auth::User()->id;
            $erros      = [];

            $dados = $request->all();

            $dadosPessoa     = $request->only(
                'name',
                'name_opcional',
                'documento',
                'documento_complementar',
                'nascimento_fundacao',
                'sexo',
                'email'
            );

            $dadosPessoa['user_update_id']      = $user_id;
            $dadosPessoa['tipo']                = 'fisica';
            $dadosPessoa['active']              = 'yes';
            if (!Utilitarios::validaCpf($dadosPessoa['documento'])) {
                $erros['documento'] = 'Cpf inválido';
                //return false;
            }

            $pessoa = Pessoa::where('id', '=', $id)->where('active', '=', 'yes')->first();
            if ($pessoa) {

                $resultPessoa = $pessoa->update($dadosPessoa);
                if ($resultPessoa) {

                    $newGrupo = Grupo::where('id', '=', $dados['groupo_id'])->where('active', '=', 'yes')->first();
                    if ($newGrupo) {
                        $grupo = $pessoa->grupo->where('active', '=', 'yes')->first();
                        if ($grupo) {
                            $pessoa->removerGrupo($grupo);
                        }

                        $resultGrupoPessoa  = $pessoa->adicionarGrupo($newGrupo, ['active' => 'yes', 'user_id' => $user_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
                        $registro = $pessoa;
                    } else {
                        $erros[] = 'Grupo não identificado';
                    }
                } else {
                    $erros[] = 'Erro ao atualizar registo';
                }
            } else {

                $erros[] = 'Pessoa não identificada';
            }

            if ($erros) {

                throw new PessoaException(implode("<br/><br/>", $erros));
            }

            \DB::commit();
            return response()->json(['mensagem' => $registro, 'class' => 'success'], 200);
        } catch (PessoaException $e) {
            \DB::rollback();

            return response()->json(['mensagem' => $e->getMessage(), 'class' => 'warning'], 500);

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

            $pessoa = Pessoa::where('active', '=', 'yes')
                ->where('id', '=', $id)->first();
            if (!$pessoa) {
                throw new PessoaException('Registro não encontrado');
            }

            $pessoa->update(['active' => 'no']);
            $pessoa->delete();

            \DB::commit();
            return response()->json(['mensagem' => 'Registro atulizado com sucesso', 'class' => 'success']);
        } catch (PessoaException $e) {
            \DB::rollback();

            return response()->json(['mensagem' => $e->getMessage(), 'class' => 'warning'], 500);

            // return response()->json(['errors'=>['error'=>'teste: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 404);

        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['mensagem' => $e->getMessage(), 'class' => 'warning'], 500);

            //return response()->json(['errors'=>['error'=>'Algo errado aconteceu no servidor: '.$e->getMessage(). ' '.$e->getLine(). ' '.$e->getFile() ]], 500);
        }
    }

    public function head(Request $request)
    {
        $dados = $request->all();

        $isReload = isset($dados['isReload']) && $dados['isReload'] == true ? $dados['isReload'] : false;
        if ($isReload) {

            return view('admin.pessoa.head_refresh', compact('isReload'));
        } else {
            return view('admin.pessoa.head', compact('isReload'));
        }
    }


    public function validarCpf($cpf)
    {
        $result = Utilitarios::validaCpf($cpf);

        if ($result == true) {
            return response()->json(['mensagem' => 'Cpf ok', 'class' => 'success'], 200);
        }

        return response()->json(['mensagem' => 'Cpf inválido', 'class' => 'warning'], 400);
    }


    public function adicionarPlano($id)
    {
        try {

            if ((!isset($id)) || ($id <= 0)) {
                return response()->json(['errors' => ['params' => 'Parametro inválido']], 400);
            }

            $registro           = null;
            $formaPagamento     = null;
            $planoPagamento     = null;
            $operadorFinanceiro = null;
            $plano              = null;
            \DB::transaction(function () use (&$id, &$registro, &$formaPagamento, &$planoPagamento, &$operadorFinanceiro, &$plano) {
                $registro = Pessoa::where('active', '=', 'yes')->where('id', '=', $id)->first();

                $formaPagamento         = FormaPagamento::where('active', '=', 'yes')->get();
                $planoPagamento         = PlanoPagamento::where('active', '=', 'yes')->get();
                $operadorFinanceiro     = OperadorFinanceiro::where('active', '=', 'yes')->get();
                $plano                  = Plano::where('active', '=', 'yes')->get();
            });

            if (($registro == null) || ($formaPagamento == null) || ($plano == null)) {
                return response()->json(['errors' => ['erro' => 'Erro ao carregar o registro'], 'class' => 'warning'], 400);
            }
            return view('admin.plano.painelVenda', compact('registro', 'formaPagamento', 'planoPagamento', 'operadorFinanceiro', 'plano'));
        } catch (\Exception $e) {
            return response()->json(['mensagem' => 'Algo errado aconteceu no servidor ' . $e->getMessage() . ' > ' . $e->getFile() . ' > ' . $e->getLine(), 'class' => 'warning'], 500);
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

            throw new PessoaException($msg);
        }

        return true;
    }
}
