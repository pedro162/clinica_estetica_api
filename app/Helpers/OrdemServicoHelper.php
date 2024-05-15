<?php

namespace App\Helpers;

use \App\Utilitarios;
use \App\OrdemServico;
use \App\Helpers\ContaReceberHelper;
use \App\FormaPagamento;
use \App\PlanoPagamento;
use \App\OperadorFinanceiro;
use \App\MotivoCancelamentoOrdemServico;

use \App\Formulario;
use \App\Marca;
use \App\Categoria;
use \App\FormularioGrupo;
use \App\Servico;
use \App\ServicoItem;
use \App\Pessoa;
use \App\Filial;
use \App\Profissional;
use \App\Rca;

use \App\Exceptions\OrdemServicoException;

class OrdemServicoHelper
{

    public function gerarFinanceiro(OrdemServico $ordemServico)
    {

        if (!$ordemServico) {
            throw new OrdemServicoException('Registro não encontrado');
        }

        $cobrancas  = $ordemServico->cobranca;
        $pessoa     = $ordemServico->pessoa;

        if (!$cobrancas) {
            throw new OrdemServicoException('Nenhuma cobrança foi encontrada pra a ordem de serviço informada');
        }

        //---- Primerio loop só para validações
        $vrTotalCobrancas = 0;
        foreach ($cobrancas as $obranca) {
            $formaPagamento     = $obranca->formaPgto;
            $planoPagamento     = $obranca->planoPgto;
            $operadorFinanceiro = $obranca->operadorFinanceiro;

            if (!$formaPagamento) {
                throw new OrdemServicoException('A forma de pagamento de código nº ' . $obranca->forma_pagamento_id . ' não foi identificada.');
            }

            if (!$planoPagamento) {
                throw new OrdemServicoException('O plano de pagamento de código nº ' . $obranca->plano_pagamento_id . ' não foi identificado.');
            }

            //---Se não tiver operador financeiro, verifico se a forma de pagamento exige
            if (!($obranca->operador_financeiro_id > 0)) {

                if ($formaPagamento->hasOperadorFinanceiro == 'yes') {
                    if (!$operadorFinanceiro) {
                        throw new OrdemServicoException('O operador financeiro de código nº ' . $obranca->operador_financeiro_id . ' não foi identificado.');
                    }
                }
            }

            $vrTotalCobrancas += $obranca->vr_final;

            $cobRecebHelper = new ContaReceberHelper();
            $erros = $cobRecebHelper->validaGerCobranca($pessoa->id, $obranca->vr_final, $formaPagamento->id, $planoPagamento->id, $operadorFinanceiro->id ?? 0, []);

            if ((is_array($erros) && count($erros) > 0)) {
                throw new OrdemServicoException(implode('<br/>', $erros));
            }
        }

        $difAbsCobOs = $ordemServico->vr_final - $vrTotalCobrancas;
        $difAbsCobOs = abs($difAbsCobOs);

        if ($ordemServico->vr_final > $vrTotalCobrancas) {
            if ($difAbsCobOs > 0.02) {
                throw new OrdemServicoException('Informe, por favor, o saldo restante das cobranças. O saldo restante é de : ' . (number_format($difAbsCobOs, 2, ',', '.')));
            }
        }

        if ($difAbsCobOs > 0.02) {
            throw new OrdemServicoException('O total das cobraças é diferente do todal da ordem de serviço');
        }

        //--Second loop to data commit
        foreach ($cobrancas as $obranca) {
            $formaPagamento     = $obranca->formaPgto;
            $planoPagamento     = $obranca->planoPgto;
            $operadorFinanceiro = $obranca->operadorFinanceiro;

            $cobRecebHelper = new ContaReceberHelper();

            $dados = [
                'filial_id' => $ordemServico->filial_id,
                'referencia' => $ordemServico->getTable(),
                'referencia_id' => $ordemServico->id,
                'documento' => $obranca->nr_doc,
                'descricao' => 'Conta a receber ordem de serviço nº ' . $ordemServico->id,
                'responsavel_id' => \Auth::User()->pessoa->id,

            ];
            $cobRecebHelper->gerarCobranca($pessoa->id, $obranca->vr_final, $formaPagamento->id, $planoPagamento->id, $operadorFinanceiro->id ?? 0, $dados);
        }

        return $ordemServico;
    }

    public function marcarComoFaturada(OrdemServico $ordemServico)
    {

        $dadosRequest = [];
        $dadosRequest['is_faturado']        = 'yes';
        $dadosRequest['type']               = 'pedido';
        $dadosRequest['td_faturamento']     = date('Y-m-d H:i:s');
        $dadosRequest['pess_fat_id']        = \Auth::User()->pessoa->id;
        $dadosRequest['user_update_id']     = \Auth::User()->id;
        $ordemServico->update($dadosRequest);

        return $ordemServico;
        //
    }

    public function marcarComoOrcamento(OrdemServico $ordemServico)
    {

        $dadosRequest = [];
        $dadosRequest['is_faturado']        = 'no';
        $dadosRequest['is_orcamento']       = 'yes';
        $dadosRequest['type']               = 'orcamento';
        $dadosRequest['td_faturamento']     = null;
        $dadosRequest['pess_fat_id']        = null;
        $dadosRequest['user_update_id']     = \Auth::User()->id;
        $ordemServico->update($dadosRequest);

        return $ordemServico;
        //
    }

    public function marcarFinalizada(OrdemServico $ordemServico)
    {

        $dadosRequest = [];
        $dadosRequest['td_conclusao']       = date('Y-m-d H:i:s');
        $dadosRequest['status']             = 'concluido';
        $dadosRequest['user_update_id']     = \Auth::User()->id;
        $ordemServico->update($dadosRequest);

        return $ordemServico;
        //'type',
        //'is_orcamento'
    }

    public function cancelarOrdemServico(OrdemServico $ordemServico, int $idMotivo)
    {
        if (!$idMotivo) {
            throw new OrdemServicoException('Motivo de cancelamento não identificado. Tente novamente ou entre em contato com o suporte.');
        }
        $objMotivoCancel = MotivoCancelamentoOrdemServico::where('active', '=', 'yes')->where('id', '=', $idMotivo)->first();
        if (!$objMotivoCancel) {
            throw new OrdemServicoException('Motivo de cancelamento não identificado. Tente novamente ou entre em contato com o suporte.');
        }

        $dadosRequest = [];
        $dadosRequest['motivo']             = $objMotivoCancel->id;
        $dadosRequest['status']             = 'cancelado';
        $dadosRequest['td_cancelamento']    = date('Y-m-d H:i:s');
        $dadosRequest['pess_cancel_id']     = \Auth::User()->pessoa->id;
        $dadosRequest['user_update_id']     = \Auth::User()->id;
        $ordemServico->update($dadosRequest);

        return $ordemServico;
    }

    public function store(array $dados)
    {
        $pessoas = Pessoa::where('active', '=', 'yes')->where('id', '=', $dados['pessoa_id'])->first();
        if (!$pessoas) {
            throw new OrdemServicoException('Pessoa não identificada. Tente novamente ou entre em contato com o suporte.');
        }

        $profissional = Profissional::where('id', '=', $dados['profissional_id'])->where('active', '=', 'yes')->first();
        if (!$profissional) {
            throw new OrdemServicoException('Profissional não identificado');
        }

        $filial = Filial::where('id', '=', $dados['filial_id'])->where('active', '=', 'yes')->first();
        if (!$filial) {
            throw new OrdemServicoException('Filial não identificada');
        }

        $pessoaRca = Rca::where('active', '=', 'yes')->where('id', '=', $dados['rca_id'])->first();
        if (!$pessoaRca) {
            throw new OrdemServicoException('Vendedor não identificado. Tente novamente ou entre em contato com o suporte.');
        }

        $dadosRequest = [];

        $dadosRequest['status']           = $dados['status'] ?? 'aberto';
        $dadosRequest['pessoa_id']        = $pessoas->id;
        $dadosRequest['pessoa_rca_id']    = $pessoaRca->pessoa_id;
        $dadosRequest['profissional_id']  = $profissional->id;
        $dadosRequest['filial_id']        = $filial->id;
        $dadosRequest['vrTotal']          = 0;
        $dadosRequest['vr_final']         = 0;
        $dadosRequest['vr_desconto']      = 0;
        $dadosRequest['pct_acrescimo']    = 0;
        $dadosRequest['vr_acrescimo']     = 0;
        $dadosRequest['user_id']          = \Auth::User()->id; //trocar pelo id do usuario logado
        $dadosRequest['active']           = 'yes';

        $form = OrdemServico::create($dadosRequest);

        if (!$form) {
            throw new OrdemServicoException('Não foi possível concluir a operação. Tente novamente ou entre em contato com o suporte.');
        }

        return $form;
    }

    public function concluir(array $dados, int $id = 0)
    {

        $id             = $id ?? $dados['id'];
        $callBack       = $dados['callBack'] ?? '';
        $idAssistente   =  $idAssistente ?? $dados['idAssistente'] ?? '';

        if ((!isset($id)) || ($id <= 0)) {
            throw new OrdemServicoException('Parâmetro inválido');
        }

        $registro = OrdemServico::where('active', '=', 'yes')->where('id', '=', $id)->first();
        if (!$registro) {
            throw new OrdemServicoException('Ordem de serviço não identificada. Tente novamente ou entre em contato com o suporte.');
        }

        $servicosArr = $registro->servico()->where('active', '=', 'yes')->get();
        if (!$servicosArr) {
            throw new OrdemServicoException('Servições não identificados. Tente novamente ou entre em contato com o suporte.');
        }
        $vrTotSevicos       = 0;
        $vrTotDesconto      = 0;
        $vrTotServicoFinal  = 0;

        foreach ($servicosArr as $item) {

            $vrTotSevicos       += $item->vrTotal;
            $vrTotDesconto      += $item->vr_desconto;
            $vrTotServicoFinal  += $item->vr_final;
        }


        $dadosRequest = [];
        $dadosRequest['vrTotal']          = $vrTotSevicos;
        $dadosRequest['vr_final']         = $vrTotServicoFinal;
        $dadosRequest['vr_desconto']      = $vrTotDesconto;
        $dadosRequest['pct_desconto']     = ($vrTotDesconto / $vrTotSevicos) * 100;
        $dadosRequest['status']           = 'aberto';
        $dadosRequest['pct_acrescimo']    = 0;
        $dadosRequest['vr_acrescimo']     = 0;
        $dadosRequest['user_update_id']         = \Auth::User()->id;
        $registro->update($dadosRequest);


        if (!$registro) {
            throw new OrdemServicoException('Registro não encontrado');
        }

        $datacobReceberObjArr = $this->gerarFinanceiro($registro);
        if (!$datacobReceberObjArr) {
            throw new OrdemServicoException('Não foi possível gerar o financeiro da ordem de serviço. Tente novamente ou entre em contato com o suporte.');
        }

        $this->marcarComoFaturada($registro);

        return $registro;
    }

    public function cancelar(array $dados, int $id = 0)
    {

        $id             = $id ?? $dados['id'];
        $callBack       = $dados['callBack'] ?? '';
        $idAssistente   =  $idAssistente ?? $dados['idAssistente'] ?? '';

        if ((!isset($id)) || ($id <= 0)) {
            throw new OrdemServicoException('Parâmetro inválido');
        }

        $registro = OrdemServico::where('active', '=', 'yes')->where('id', '=', $id)->first();
        if (!$registro) {
            throw new OrdemServicoException('Ordem de serviço não identificada. Tente novamente ou entre em contato com o suporte.');
        }

        $idMotivoCancel = $dados['motivo_cancel_id'] ?? 0;

        $this->cancelarOrdemServico($registro, $idMotivoCancel);

        return $registro;
    }

    public function info(array $dados, int $id = 0)
    {

        $id         = $id ?? $dados['id'];
        $callBack   = $dados['callBack'] ?? '';

        if ($id <= 0) {
            throw new OrdemServicoException('Parâmetro ínválido');
        }

        $registro = OrdemServico::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();
        $registro->pessoa;
        $dataItens = [];
        if ($registro->item) {
            foreach ($registro->item as $key => $item) {
                $item->servico;
                //$dataItens[] = $item->servico;
            }
        }
        $dataCobrancas = [];
        if ($registro->cobranca) {
            foreach ($registro->cobranca as $key => $cobranca) {
                $cobranca->formaPgto;
                $cobranca->planoPgto;

                //$dataCobrancas[] = $cobranca->formaPgto;


            }
        }

        $registro->cobranca; // = $dataCobrancas;
        $registro->item; // = $dataItens;
        //$registro->item;
        $registro->rca;
        $registro->filial;

        return $registro;
    }


    public function update(array $dados, int $id = 0)
    {

        $id             = $id ?? $dados['id'];
        $callBack       = $dados['callBack'] ?? '';
        $idAssistente   =  $idAssistente ?? $dados['idAssistente'] ?? '';

        if ((!isset($id)) || ($id <= 0)) {
            throw new OrdemServicoException('Parâmetro inválido');
        }

        $registro = OrdemServico::where('active', '=', 'yes')->where('id', '=', $id)->first();

        $dadosRequest = [];
        $dadosRequest['observacao']         = $dados['observacao'] ?? null;
        $dadosRequest['user_update_id']     = \Auth::User()->id;
        $registro->update($dadosRequest);


        if (!$registro) {
            throw new OrdemServicoException('Registro não encontrado');
        }

        return $registro;
    }

    public function finalizar(array $dados, int $id = 0)
    {

        $id             = $id ?? $dados['id'];
        $callBack       = $dados['callBack'] ?? '';
        $isOrcamento    = $dados['is_orcamento'] ?? 'no';
        $idAssistente   =  $idAssistente ?? $dados['idAssistente'] ?? '';

        if ((!isset($id)) || ($id <= 0)) {
            throw new OrdemServicoException('Parâmetro inválido');
        }

        $registro = OrdemServico::where('active', '=', 'yes')->where('id', '=', $id)->first();
        if (!$registro) {
            throw new OrdemServicoException('Registro não encontrado');
        }


        if ($isOrcamento == 'yes' || trim($isOrcamento) == 'sim' || $isOrcamento === true) {
            $this->marcarComoOrcamento($registro);
        } else {

            $this->gerarFinanceiro($registro);
            $this->marcarComoFaturada($registro);
        }

        if (!$registro) {
            throw new OrdemServicoException('Registro não encontrado');
        }

        return $registro;
    }

    public function adicionarItem(array $dados, int $id = 0)
    {

        $id             = $id ?? $dados['id'];
        $callBack       = $dados['callBack'] ?? '';
        $idAssistente   = $idAssistente ?? $dados['idAssistente'] ?? '';
        $idServico      = $dados['servico_id'] ?? 0;
        $erros          = [];
        $vrItem         = $dados['vrItem']          ?? 0;
        $vrItemBruto    = $dados['vrItemBruto']     ?? 0;
        $qtd            = $dados['qtd']             ?? 0;
        $pct_desconto   = $dados['pct_desconto']    ?? 0;
        $vrDesconto     = 0;
        $vrAcrecimos    = 0;
        $pctAcrecimos   = 0;

        if ((!isset($id)) || ($id <= 0)) {
            throw new OrdemServicoException('Parâmetro para ordem de serviço inválido. Tente novamente ou entre em contato com o suporte');
        }

        $registro = OrdemServico::where('active', '=', 'yes')->where('id', '=', $id)->first();

        /* $dadosRequest = [];
        $dadosRequest['name']                   = $dados['name'];
        $dadosRequest['descricao']              = $dados['descricao']       ?? null;
        $dadosRequest['vrServico']              = $dados['vrServico']       ?? null;
        $dadosRequest['user_update_id']         = \Auth::User()->id;
        $registro->update($dadosRequest); */


        if (!$registro) {
            throw new OrdemServicoException('Registro não encontrado');
        }

        $servico = Servico::where('active', '=', 'yes')->where('id', '=', $idServico)->first();
        if (!$servico) {
            throw new OrdemServicoException('Serviço não encontrado');
        }

        if (!($servico->vrServico > 0)) {
            throw new OrdemServicoException('O serviço de código nº ' . $servico->id . ' está sem preço de venda válido. Entre em contato com o gerente ou administrador.');
        }
        $servicoItem = null;
        if (isset($dados['os_item_id']) && $dados['os_item_id'] > 0) {

            $servicoItem = ServicoItem::where('id', '=', $dados['os_item_id'])->first();
            if (!$servicoItem) {
                throw new OrdemServicoException('Registro não encontrado para atualizar.');
            }
        }



        $vrItem         = Utilitarios::removeMaskMoney($vrItem);
        $vrItemBruto    = Utilitarios::removeMaskMoney($vrItemBruto);
        $pct_desconto   = Utilitarios::removeMaskMoney($pct_desconto);
        if ($pct_desconto > 100) {
            $pct_desconto = 100;
        } elseif ($pct_desconto < 0) {
            $pct_desconto = 0;
        }

        $vrDesconto     = $vrItemBruto * ($pct_desconto / 100);
        $dadosRequest   = [];

        $dadosRequest['qtd']                = $qtd;
        $dadosRequest['servico_id']         = $servico->id;
        $dadosRequest['vrItemBruto']        = $vrItemBruto;
        $dadosRequest['vrItem']             = $vrItem;
        $dadosRequest['vrTotal']            = $vrItemBruto * $qtd;
        $dadosRequest['ordem_servico_id']   = $registro->id;
        $dadosRequest['pct_acrescimo']      = $pctAcrecimos;
        $dadosRequest['vr_acrescimo']       = $vrAcrecimos;
        $dadosRequest['pct_desconto']       = $pct_desconto;
        $dadosRequest['vr_desconto']        = $vrDesconto; //--- Valor de desconto unitário
        $dadosRequest['vr_final']           = $dadosRequest['vrItem'] * $dadosRequest['qtd'];
        $dadosRequest['user_id']            = \Auth::User()->id; //trocar pelo id do usuario logado
        $dadosRequest['active']             = 'yes';

        if ($servicoItem) {
            $dadosRequest['user_update_id']   = \Auth::User()->id;
            $servicoItem->update($dadosRequest);
        } else {
            $servicoItem = ServicoItem::create($dadosRequest);
        }

        //---Recalcula a ordem de serviço
        $registro = $this->recalcularOrdemServico($registro->id);

        return $registro;
    }

    public function removerItem(int $id)
    {
        if ($id <= 0) {
            throw new OrdemServicoException("Parâmetro inválido.");
        }

        $registro = ServicoItem::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        if (!$registro) {
            throw new OrdemServicoException("Item não identificado.");
        }

        $ordem = $registro->ordem;
        if (!$ordem) {
            throw new OrdemServicoException("Ordem d serviço não identificada.");
        }

        if (trim($ordem->is_faturado) == 'yes') {
            throw new OrdemServicoException("A ordem de serviço de código nº {$ordem->id} encontra-se faturada e não poderá ser modificada.");
        }

        if (!in_array($ordem->status, ['aberto'])) {
            throw new OrdemServicoException("A ordem de serviço de código nº {$ordem->id} encontra-se \"{$ordem->status}\" e não poderá ser modificada.");
        }

        $response = $registro->update(['active' => 'no']);

        if (!$response) {
            throw new OrdemServicoException("Erro ao exclir registro.");
        }
        $registro = $registro->delete();
        $this->recalcularOrdemServico($ordem->id);

        return $registro;
    }

    public function recalcularOrdemServico(int $id)
    {


        if ((!isset($id)) || ($id <= 0)) {
            throw new OrdemServicoException('Parâmetro inválido');
        }

        $registro = OrdemServico::where('active', '=', 'yes')->where('id', '=', $id)->first();
        if (!$registro) {
            throw new OrdemServicoException('Ordem de serviço não identificada. Tente novamente ou entre em contato com o suporte.');
        }

        $servicosArr = $registro->item()->where('active', '=', 'yes')->get();
        if (!$servicosArr) {
            throw new OrdemServicoException('Servições não identificados. Tente novamente ou entre em contato com o suporte.');
        }
        $vrTotSevicos       = 0;
        $vrTotDesconto      = 0;
        $vrTotServicoFinal  = 0;

        foreach ($servicosArr as $item) {

            $vrTotSevicos       += $item->vrTotal;
            $vrTotDesconto      += $item->vr_desconto;
            $vrTotServicoFinal  += $item->vr_final;
        }


        $dadosRequest = [];
        $dadosRequest['vrTotal']          = $vrTotSevicos;
        $dadosRequest['vr_final']         = $vrTotServicoFinal;
        $dadosRequest['vr_desconto']      = $vrTotDesconto;
        $dadosRequest['pct_desconto']     = ($vrTotDesconto / $vrTotSevicos) * 100;
        $dadosRequest['pct_acrescimo']    = 0;
        $dadosRequest['vr_acrescimo']     = 0;
        $dadosRequest['user_update_id']         = \Auth::User()->id;
        $registro->update($dadosRequest);


        if (!$registro) {
            throw new OrdemServicoException('Registro não encontrado');
        }

        return $registro;
    }

    public function destroy(int $id)
    {

        if ($id <= 0) {
            throw new OrdemServicoException('Parâmetro inválido');
        }

        $registro = OrdemServico::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();
        if (!$registro) {
            throw new OrdemServicoException('Erro ao exclir registro');
        } else {

            $registro = $registro->update(['active' => 'no']);
        }

        if ($registro == null) {

            //\Session::flash('mensagem', ['msg'=>' não encontrado', 'class'=>'alert alert-danger']);
            //return redirect()->back();
            throw new OrdemServicoException('Erro ao exclir registro');
        }

        return $registro;
    }

    public function json(array $data, $usePaginate = false)
    {


        $consulta = $data;
        //dd($consulta);
        $ordem = $consulta['ordem'] ?? 'id-desc';

        $parse = [];

        $registro = \DB::table('ordem_servicos as os')->join('pessoas as pes', function ($join) {

            $join->on('os.pessoa_id', '=', 'pes.id');
        })->join('pessoas as pesrc', function ($join) {

            $join->on('os.pessoa_rca_id', '=', 'pesrc.id');
        })->join('filials as fl', function ($join) {

            $join->on('os.filial_id', '=', 'fl.id');
        })->join('pessoas as pesfl', function ($join) {

            $join->on('fl.pessoa_id', '=', 'pesfl.id');
        })->join('profissionals as pf', function ($join) {

            $join->on('os.profissional_id', '=', 'pf.id');
        })->join('pessoas as pesprf', function ($join) {

            $join->on('pf.pessoa_id', '=', 'pesprf.id');
        });

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

                            $registro->whereIn('os.id', $val);
                        }
                        break;
                    case 'status': //'aberto','cancelado','aguardando','concluido'
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);

                            $registro->whereIn('os.status', $val);
                        }
                        break;
                    case 'nome_pessoa':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('pes.name', 'like', '%' . $val . '%');
                        }

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
            $registro->select('os.*', 'pes.name', 'pesrc.name as name_rca', 'pesfl.name as name_filial', 'pesprf.name as name_profissional');
        }
        //$registro = \App\::where('active', '=', 'yes')->get();
        $ordemArr   = explode('-', $ordem);

        $oremCampo  = $ordemArr[0];
        $oremTipo  = $ordemArr[1];
        $usePaginate = true;
        if ($usePaginate) {
            $registro   = $registro->where('os.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->paginate(10);
        } else {
            $registro   = $registro->where('os.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->get();
        }



        return $registro;
    }
}
