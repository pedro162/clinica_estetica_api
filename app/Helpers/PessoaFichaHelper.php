<?php

namespace App\Helpers;

use \App\Utilitarios;
use \App\PessoaFormularioResposta;
use \App\Helpers\ContaReceberHelper;
use \App\FormaPagamento;
use \App\PlanoPagamento;
use \App\OperadorFinanceiro;
use \App\MotivoCancelamentoOrdemServico;
use \App\PessoaFormulario;
use \App\Filial;
use \App\Pessoa;
use \App\Profissional;
use \App\Formulario;
use \App\Helpers\PessoaFichaRespostaHelper;
use \App\Exceptions\PessoaFichaExcepton;
use Illuminate\Support\Facades\Auth;

class PessoaFichaHelper
{

    /**
     * Update the specified resource in storage.
     *
     * @param  array  $dados
     * @param  int  $id
     * @return \App\PessoaFormulario
     */
    public function create(array $dados, int $id = null)
    {

        //------Salve the form header ----------------------------------------
        $pessoas = Pessoa::where('active', '=', 'yes')->where('id', '=', $dados['pessoa_id'])->first();
        if (!$pessoas) {
            throw new PessoaFichaExcepton('Pessoa não identificada. Tente novamente ou entre em contato com o suporte.');
        }

        $profissional = Profissional::where('id', '=', $dados['profissional_id'])->where('active', '=', 'yes')->first();
        if (!$profissional) {
            throw new PessoaFichaExcepton('Profissional não identificado');
        }

        $filial = Filial::where('id', '=', $dados['filial_id'])->where('active', '=', 'yes')->first();
        if (!$filial) {
            throw new PessoaFichaExcepton('Filial não identificada');
        }

        $formulario = Formulario::where('id', '=', $dados['formulario_id'])->where('active', '=', 'yes')->first();
        if (!$formulario) {
            throw new PessoaFichaExcepton('Formuláiro não identificado');
        }


        $dadosRequest = [];

        $dadosRequest['observacao']       = $dados['observacao'] ?? null;
        $dadosRequest['status']           = $dados['status'] ?? 'aberto';
        $dadosRequest['pessoa_id']        = $pessoas->id;
        $dadosRequest['profissional_id']  = $profissional->id;
        $dadosRequest['filial_id']        = $filial->id;
        $dadosRequest['formulario_id']    = $formulario->id;
        $dadosRequest['sigiloso']         = $dados['sigiloso'] ?? 'no';
        $dadosRequest['user_id']          = \Auth::User()->id; //trocar pelo id do usuario logado
        $dadosRequest['active']           = 'yes';

        //---Se tiver uma ficha informada, tento carregar e atualizar
        if ($id > 0) {
            $formPessoa = PessoaFormulario::where('active', '=', 'yes')->where('id', '=', $id)->first();

            if (!$formulario) {
                throw new PessoaFichaExcepton('Ficha não identificada');
            }

            $dadosRequest['user_update_id']     = \Auth::User()->id;
            $formPessoa->update($dadosRequest);

            $respostas = $formPessoa->resposta();
            //---- Pego todas as respostas anteriores e excluo para que as novas fiquem no lugar
            if ($respostas) {
                foreach ($respostas as $resposta) {
                    if ($resposta) {
                        $resposta->update(['active' => 'no']);
                        $resposta->delete();
                    }
                }
            }
        } else {
            $formPessoa = PessoaFormulario::create($dadosRequest);
        }


        $dataQuestionario = $dados['questionario'] ?? [];
        //------Save the response item from form ----------------------------------------
        $gropo = $formulario->grupo()->where('active', '=', 'yes')->get();
        if ($gropo) {
            foreach ($gropo as $gropoItem) {
                $itens   = $gropoItem->item()->where('active', '=', 'yes')->get();
                if ($itens) {
                    foreach ($itens as $item) {
                        if (!$item) {
                            continue;
                        }

                        $dataRespostaItem   = [];
                        if (key_exists($item->name, $dataQuestionario)) {
                            $dataRespostaItem = $dataQuestionario[$item->name];
                        }

                        $dataItem = [];
                        $dataItem['resposta']       = $dataRespostaItem['value'] ?? null;
                        $pessoFichaItemHelper = new PessoaFichaRespostaHelper();

                        $pessoFichaItemHelper->create($formPessoa, $item->id, $dataItem);
                    }
                }
            }
        }


        return $formPessoa;
        //
    }

    public function atualizar(PessoaFormulario $formPessoa, array $dados)
    {
        $pessoas = Pessoa::where('active', '=', 'yes')->where('id', '=', $dados['pessoa_id'])->first();
        if (!$pessoas) {
            throw new PessoaFichaExcepton('Pessoa não identificada. Tente novamente ou entre em contato com o suporte.');
        }

        $profissional = Profissional::where('id', '=', $dados['profissional_id'])->where('active', '=', 'yes')->first();
        if (!$profissional) {
            throw new PessoaFichaExcepton('Profissional não identificado');
        }

        $filial = Filial::where('id', '=', $dados['filial_id'])->where('active', '=', 'yes')->first();
        if (!$filial) {
            throw new PessoaFichaExcepton('Filial não identificada');
        }

        $formulario = Formulario::where('id', '=', $dados['formulario_id'])->where('active', '=', 'yes')->first();
        if (!$formulario) {
            throw new PessoaFichaExcepton('Formuláiro não identificado');
        }

        $dadosRequest = [];
        $dadosRequest['observacao']         = $dados['observacao'] ?? null;
        $dadosRequest['status']             = $dados['status'] ?? 'aberto';
        $dadosRequest['pessoa_id']          = $pessoas->id;
        $dadosRequest['profissional_id']    = $profissional->id;
        $dadosRequest['filial_id']          = $filial->id;
        $dadosRequest['formulario_id']      = $formulario->id;
        $dadosRequest['sigiloso']           = $dados['sigiloso'] ?? 'no';
        $dadosRequest['user_update_id']     = \Auth::User()->id;
        $formPessoa->update($dadosRequest);

        return $formPessoa;
    }

    public function cancelar(PessoaFormulario $formPessoa)
    {

        $dadosRequest = [];
        $dadosRequest['status']             = 'cancelado';
        $dadosRequest['dt_cancelamento']    = date('Y-m-d H:i:s');
        $dadosRequest['pess_cancel_id']     = \Auth::User()->pessoa->id;
        $dadosRequest['user_update_id']     = \Auth::User()->id;
        $formPessoa->update($dadosRequest);

        return $formPessoa;
    }

    public function info($dados, $id)
    {
        if (!($id > 0)) {
            throw new PessoaFichaExcepton('Parâmetro ínválido');
        }

        $registro = PessoaFormulario::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();
        $registro->pessoa;
        $logradouros = $registro->pessoa->logradouro;
        if ($logradouros) {
            foreach ($logradouros as $logradouro) {
                $logradouro->estado_logradouro;
            }
        }
        $registro->resposta = $registro->resposta()->where('active', '=', 'yes')->get();
        $registro->profissional;
        $registro->formulario;
        if ($registro->resposta) {
            foreach ($registro->resposta as $resposta) {
                $resposta->formitem;
            }
        }

        if ($registro == null) {
            throw new PessoaFichaExcepton(' não encontrado');
        }

        return $registro;
    }
}
