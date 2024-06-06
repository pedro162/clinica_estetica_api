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
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Helpers\BaseHelper;

class PessoaFichaHelper extends BaseHelper
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
            // throw new \Exception('teste');
            $formPessoa = PessoaFormulario::where('active', '=', 'yes')->where('id', '=', $id)->first();

            if (!$formulario) {
                throw new PessoaFichaExcepton('Ficha não identificada');
            }

            $dadosRequest['user_update_id']     = \Auth::User()->id;
            $formPessoa->update($dadosRequest);

            $respostas = $formPessoa->resposta()->where('active', '=', 'yes')->get();
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

    public function json(array $dados)
    {

        $consulta = $dados;

        if (!(isset($consulta['ordem']) && strlen($consulta['ordem']) > 0)) {
            $consulta['ordem'] = 'id-desc';
        }
        $ordem      = $consulta['ordem'] ?? 'id-desc';

        $tpUser     = \Auth::User()->type;
        $pessoaUser = \Auth::User()->pessoa;

        if ($tpUser == 'external') {
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
                            //$campos = $this->montaCamposConsulta($registro, $val);
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

        //----
        $ordemArr   = explode('-', $ordem);
        $oremCampo  = $ordemArr[0];
        $oremTipo  = $ordemArr[1];

        $usePaginate = $consulta['usePaginate'] ?? 0;
        $usePaginate = (int) $usePaginate;
        $nrItensPerPage = isset($consulta['nr_itens_per_page']) && $consulta['nr_itens_per_page'] > 0 ? $consulta['nr_itens_per_page'] : self::PAGINACAO_ITENS_POR_PAGINA_PADRAO;
        if ($usePaginate > 0) {
            $registro   = $registro->where('pf.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->paginate($nrItensPerPage);
        } else {
            $registro = $registro->where('pf.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->get();
        }

        if (isset($consulta['to_require']) && $consulta['to_require'] == true) {
            $dataToRequest = [];
            foreach ($registro as $reg) {
                $dataToRequest[] = ['label' => $reg->name, 'value' => $reg->id];
            }

            $registro = $dataToRequest;
        }
        return $registro;
    }
}
