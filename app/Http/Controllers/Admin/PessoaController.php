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
                        'numero' => $value ?? '00000000000',
                        'tipo' => $tipo,
                        'user_id' => $user_id,
                        'active' => 'yes',
                        'pessoa_id' => $pessoa->id
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

            if ($logr = $registro->logradouro->where('importancia', '=', 'principal')->first()) {
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

                $resultForm->resposta = $resposta;
            }

            $registro->formulario = $resultForm;

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
