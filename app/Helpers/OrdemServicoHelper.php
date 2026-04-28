<?php

namespace App\Helpers;

use App\Application\Commands\WorkOrder\CreateWorkOrderCommand;
use App\Domain\WorkOrder\Entities\WorkOrder as WorkOrderEntity;
use App\Domain\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use App\Domain\WorkOrder\ValueObjects\WorkOrderId;
use App\Exceptions\OrdemServicoException;
use App\Filial;
use App\MotivoCancelamentoOrdemServico;
use App\OrdemServico;
use App\Pessoa;
use App\Profissional;
use App\Rca;
use App\Servico;
use App\ServicoItem;
use App\Utilitarios;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdemServicoHelper extends BaseHelper
{
    public function gerarFinanceiro(OrdemServico $ordemServico)
    {
        if (! $ordemServico) {
            throw new OrdemServicoException(__('work_order.not_found'));
        }

        $cobrancas = $ordemServico->cobranca;
        $pessoa    = $ordemServico->pessoa;

        if (! $cobrancas) {
            throw new OrdemServicoException(__('work_order.no_charges_found'));
        }

        // First loop: validations
        $vrTotalCobrancas = 0;

        foreach ($cobrancas as $obranca) {
            $formaPagamento     = $obranca->formaPgto;
            $planoPagamento     = $obranca->planoPgto;
            $operadorFinanceiro = $obranca->operadorFinanceiro;

            if (! $formaPagamento) {
                throw new OrdemServicoException(
                    __('work_order.payment_method_not_found', [
                        'id' => $obranca->forma_pagamento_id,
                    ])
                );
            }

            if (! $planoPagamento) {
                throw new OrdemServicoException(
                    __('work_order.payment_plan_not_found', [
                        'id' => $obranca->plano_pagamento_id,
                    ])
                );
            }

            // If there is no financial operator, check if payment method requires it
            if (! ($obranca->operador_financeiro_id > 0)) {
                if ($formaPagamento->hasOperadorFinanceiro === 'yes') {
                    if (! $operadorFinanceiro) {
                        throw new OrdemServicoException(
                            __('work_order.financial_operator_not_found', [
                                'id' => $obranca->operador_financeiro_id,
                            ])
                        );
                    }
                }
            }

            $vrTotalCobrancas += $obranca->vr_final;

            $cobRecebHelper = app(ContaReceberHelper::class);
            $erros          = $cobRecebHelper->validaGerCobranca(
                $pessoa->id,
                $obranca->vr_final,
                $formaPagamento->id,
                $planoPagamento->id,
                $operadorFinanceiro->id ?? 0,
                []
            );

            if (is_array($erros) && count($erros) > 0) {
                throw new OrdemServicoException(implode('<br/>', $erros));
            }
        }

        $difAbsCobOs = abs($ordemServico->vr_final - $vrTotalCobrancas);

        if ($ordemServico->vr_final > $vrTotalCobrancas && $difAbsCobOs > 0.02) {
            throw new OrdemServicoException(
                __('work_order.remaining_balance', [
                    'amount' => number_format($difAbsCobOs, 2, ',', '.'),
                ])
            );
        }

        if ($difAbsCobOs > 0.02) {
            throw new OrdemServicoException(__('work_order.charges_total_mismatch'));
        }

        foreach ($cobrancas as $obranca) {
            $formaPagamento     = $obranca->formaPgto;
            $planoPagamento     = $obranca->planoPgto;
            $operadorFinanceiro = $obranca->operadorFinanceiro;

            $cobRecebHelper = app(ContaReceberHelper::class);

            $dados = [
                'filial_id'      => $ordemServico->filial_id,
                'referencia'     => $ordemServico->getTable(),
                'referencia_id'  => $ordemServico->id,
                'documento'      => $obranca->nr_doc,
                'descricao'      => 'Conta a receber ordem de serviço nº ' . $ordemServico->id,
                'responsavel_id' => Auth::user()?->pessoa?->id,
            ];

            $cobRecebHelper->gerarCobranca(
                $pessoa->id,
                $obranca->vr_final,
                $formaPagamento->id,
                $planoPagamento->id,
                $operadorFinanceiro->id ?? 0,
                $dados
            );
        }

        return $ordemServico;
    }

    public function marcarComoFaturada(OrdemServico $ordemServico)
    {
        $dadosRequest = [];
        $dadosRequest['is_faturado']        = 'yes';
        $dadosRequest['type']               = 'pedido';
        $dadosRequest['td_faturamento']     = date('Y-m-d H:i:s');
        $dadosRequest['pess_fat_id']        = Auth::User()?->pessoa?->id;
        $dadosRequest['user_update_id']     = Auth::User()->id;
        $ordemServico->update($dadosRequest);

        return $ordemServico;
    }

    public function marcarComoOrcamento(OrdemServico $ordemServico)
    {
        $dadosRequest = [];
        $dadosRequest['is_faturado']        = 'no';
        $dadosRequest['is_orcamento']       = 'yes';
        $dadosRequest['type']               = 'orcamento';
        $dadosRequest['td_faturamento']     = null;
        $dadosRequest['pess_fat_id']        = null;
        $dadosRequest['user_update_id']     = Auth::User()->id;
        $ordemServico->update($dadosRequest);

        return $ordemServico;
    }

    public function marcarFinalizada(OrdemServico $ordemServico)
    {
        $dadosRequest = [];
        $dadosRequest['td_conclusao']       = date('Y-m-d H:i:s');
        $dadosRequest['status']             = 'concluido';
        $dadosRequest['user_update_id']     = Auth::User()->id;
        $ordemServico->update($dadosRequest);

        return $ordemServico;
    }

    public function cancelarOrdemServico(OrdemServico $ordemServico, int $idMotivo)
    {
        if (! $idMotivo) {
            throw new OrdemServicoException(__('work_order.cancel_reason_not_found'));
        }

        $objMotivoCancel = MotivoCancelamentoOrdemServico::where('active', '=', 'yes')
            ->where('id', '=', $idMotivo)
            ->first();

        if (! $objMotivoCancel) {
            throw new OrdemServicoException(__('work_order.cancel_reason_not_found'));
        }

        $dadosRequest = [];
        $dadosRequest['mt_calcel_id']      = $objMotivoCancel->id;
        $dadosRequest['status']            = 'cancelado';
        $dadosRequest['td_cancelamento']   = date('Y-m-d H:i:s');
        $dadosRequest['pess_cancel_id']    = Auth::User()->pessoa->id;
        $dadosRequest['user_update_id']    = Auth::User()->id;
        $ordemServico->update($dadosRequest);

        return $ordemServico;
    }

    public function store(array $dados)
    {
        $pessoas = Pessoa::where('active', '=', 'yes')
            ->where('id', '=', $dados['pessoa_id'])
            ->first();

        if (! $pessoas) {
            throw new OrdemServicoException(__('work_order.person_not_found'));
        }

        $profissional = Profissional::where('id', '=', $dados['profissional_id'])
            ->where('active', '=', 'yes')
            ->first();

        if (! $profissional) {
            throw new OrdemServicoException(__('work_order.professional_not_found'));
        }

        $filial = Filial::where('id', '=', $dados['filial_id'])
            ->where('active', '=', 'yes')
            ->first();

        if (! $filial) {
            throw new OrdemServicoException(__('work_order.branch_not_found'));
        }

        $pessoaRca = Rca::where('active', '=', 'yes')
            ->where('id', '=', $dados['rca_id'])
            ->first();

        if (! $pessoaRca) {
            throw new OrdemServicoException(__('work_order.seller_not_found'));
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
        $dadosRequest['user_id']          = Auth::User()->id; //trocar pelo id do usuario logado
        $dadosRequest['active']           = 'yes';

        $form = OrdemServico::create($dadosRequest);

        if (! $form) {
            throw new OrdemServicoException(__('work_order.operation_error'));
        }

        return $form;
    }

    public function concluir(array $dados, int $id = 0)
    {
        $id           = $id ?? $dados['id'];
        $callBack     = $dados['callBack'] ?? '';
        $idAssistente = $idAssistente ?? $dados['idAssistente'] ?? '';

        if (! isset($id) || $id <= 0) {
            throw new OrdemServicoException(__('work_order.invalid_parameter'));
        }

        $registro = OrdemServico::where('active', '=', 'yes')
            ->where('id', '=', $id)
            ->first();

        if (! $registro) {
            throw new OrdemServicoException(__('work_order.work_order_not_found'));
        }

        $servicosArr = $registro->servico()->where('active', '=', 'yes')->get();
        if (! $servicosArr) {
            throw new OrdemServicoException(__('work_order.services_not_found'));
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
        $dadosRequest['user_update_id']         = Auth::User()->id;
        $registro->update($dadosRequest);

        if (! $registro) {
            throw new OrdemServicoException(__('work_order.record_not_found'));
        }

        $datacobReceberObjArr = $this->gerarFinanceiro($registro);
        if (! $datacobReceberObjArr) {
            throw new OrdemServicoException(__('work_order.finance_generation_error'));
        }

        $this->marcarComoFaturada($registro);

        return $registro;
    }

    public function cancelar(array $dados, int $id = 0)
    {
        $id           = $id ?? $dados['id'];
        $callBack     = $dados['callBack'] ?? '';
        $idAssistente = $idAssistente ?? $dados['idAssistente'] ?? '';

        if (! isset($id) || $id <= 0) {
            throw new OrdemServicoException(__('work_order.invalid_parameter'));
        }

        $registro = OrdemServico::where('active', '=', 'yes')
            ->where('id', '=', $id)
            ->first();

        if (! $registro) {
            throw new OrdemServicoException(__('work_order.work_order_not_found'));
        }

        $idMotivoCancel = $dados['motivo_cancel_id'] ?? 0;

        $this->cancelarOrdemServico($registro, $idMotivoCancel);

        return $registro;
    }

    public function info(array $dados, int $id = 0)
    {
        $id       = $id ?? $dados['id'];

        if ($id <= 0) {
            throw new OrdemServicoException(__('work_order.invalid_parameter'));
        }

        return app(WorkOrderRepositoryInterface::class)
            ->findById(new WorkOrderId((string)$id));
    }

    public function update(array $dados, int $id = 0)
    {
        $id           = $id ?? $dados['id'];

        if (! isset($id) || $id <= 0) {
            throw new OrdemServicoException(__('work_order.invalid_parameter'));
        }

        app(WorkOrderRepositoryInterface::class)
            ->update(WorkOrderEntity::buildEntity(CreateWorkOrderCommand::build(
                [
                    'id' => $id,
                    'observacao' => $dados['observacao'] ?? null
                ]
            )->getDataProperties()));

        $registro = app(WorkOrderRepositoryInterface::class)
            ->findById(new WorkOrderId((string)$id));

        if (! $registro) {
            throw new OrdemServicoException(__('work_order.record_not_found'));
        }

        return $registro;
    }

    public function finalizar(array $dados, int $id = 0)
    {
        $id           = $id ?? $dados['id'];
        $isOrcamento  = $dados['is_orcamento'] ?? 'no';
        $idAssistente = $idAssistente ?? $dados['idAssistente'] ?? '';

        if (! isset($id) || $id <= 0) {
            throw new OrdemServicoException(__('work_order.invalid_parameter'));
        }

        $registro = app(WorkOrderRepositoryInterface::class)
            ->findById(new WorkOrderId((string)$id));

        if (! $registro) {
            throw new OrdemServicoException(__('work_order.record_not_found'));
        }

        if ($isOrcamento == 'yes' || trim($isOrcamento) == 'sim' || $isOrcamento === true) {
            $this->marcarComoOrcamento($registro);
        } else {
            $this->gerarFinanceiro($registro);
            $this->marcarComoFaturada($registro);
        }

        return app(WorkOrderRepositoryInterface::class)
            ->findById(new WorkOrderId((string)$id));
    }

    public function adicionarItem(array $dados, int $id = 0)
    {
        $id           = $id ?? $dados['id'];
        $idAssistente = $idAssistente ?? $dados['idAssistente'] ?? '';
        $idServico    = $dados['servico_id'] ?? 0;
        $vrItem         = $dados['vrItem']          ?? 0;
        $vrItemBruto    = $dados['vrItemBruto']     ?? 0;
        $qtd            = $dados['qtd']             ?? 0;
        $pct_desconto   = $dados['pct_desconto']    ?? 0;
        $vrDesconto     = 0;
        $vrAcrecimos    = 0;
        $pctAcrecimos   = 0;

        if (! isset($id) || $id <= 0) {
            throw new OrdemServicoException(__('work_order.invalid_work_order_parameter'));
        }

        $registro = app(WorkOrderRepositoryInterface::class)
            ->findById(new WorkOrderId((string)$id));

        if (! $registro) {
            throw new OrdemServicoException(__('work_order.record_not_found'));
        }

        $servico = Servico::where('active', '=', 'yes')
            ->where('id', '=', $idServico)
            ->first();

        if (! $servico) {
            throw new OrdemServicoException(__('work_order.service_not_found'));
        }

        if (! ($servico->vrServico > 0)) {
            throw new OrdemServicoException(
                __('work_order.service_without_price', ['id' => $servico->id])
            );
        }

        $servicoItem = null;

        if (isset($dados['os_item_id']) && $dados['os_item_id'] > 0) {
            $servicoItem = ServicoItem::where('id', '=', $dados['os_item_id'])->first();

            if (! $servicoItem) {
                throw new OrdemServicoException(__('work_order.record_not_found_to_update'));
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
        $dadosRequest['user_id']            = Auth::User()->id; //trocar pelo id do usuario logado
        $dadosRequest['active']             = 'yes';

        if ($servicoItem) {
            $dadosRequest['user_update_id']   = Auth::User()->id;
            $servicoItem->update($dadosRequest);
        } else {
            $servicoItem = ServicoItem::create($dadosRequest);
        }

        return $this->recalcularOrdemServico($registro->id);
    }

    public function removerItem(int $id)
    {
        if ($id <= 0) {
            throw new OrdemServicoException(__('work_order.invalid_parameter'));
        }

        $registro = ServicoItem::where('active', '=', 'yes')
            ->where('id', '=', $id)
            ->first();

        if (! $registro) {
            throw new OrdemServicoException(__('work_order.item_not_found'));
        }

        $ordem = $registro->ordem;

        if (! $ordem) {
            throw new OrdemServicoException(__('work_order.work_order_not_found'));
        }

        if (trim($ordem->is_faturado) === 'yes') {
            throw new OrdemServicoException(
                __('work_order.work_order_already_invoiced', ['id' => $ordem->id])
            );
        }

        if (! in_array($ordem->status, ['aberto'])) {
            throw new OrdemServicoException(
                __('work_order.work_order_status_not_modifiable', [
                    'id'     => $ordem->id,
                    'status' => $ordem->status,
                ])
            );
        }

        $response = $registro->update(['active' => 'no']);

        if (! $response) {
            throw new OrdemServicoException(__('work_order.delete_error'));
        }

        $registro = $registro->delete();
        $this->recalcularOrdemServico($ordem->id);

        return $registro;
    }

    public function recalcularOrdemServico(int $id)
    {
        if (! isset($id) || $id <= 0) {
            throw new OrdemServicoException(__('work_order.invalid_parameter'));
        }

        $registro = app(WorkOrderRepositoryInterface::class)
            ->findById(new WorkOrderId((string)$id));

        if (! $registro) {
            throw new OrdemServicoException(__('work_order.work_order_not_found'));
        }

        $servicosArr = $registro->item()->where('active', '=', 'yes')->get();

        if (! $servicosArr || $servicosArr->isEmpty()) {
            throw new OrdemServicoException(__('work_order.services_not_found'));
        }

        $vrTotSevicos      = 0;
        $vrTotDesconto     = 0;
        $vrTotServicoFinal = 0;

        foreach ($servicosArr as $item) {
            $vrTotSevicos      += $item->vrTotal;
            $vrTotDesconto     += $item->vr_desconto;
            $vrTotServicoFinal += $item->vr_final;
        }

        $dadosRequest                     = [];
        $dadosRequest['vrTotal']          = $vrTotSevicos;
        $dadosRequest['vr_final']         = $vrTotServicoFinal;
        $dadosRequest['vr_desconto']      = $vrTotDesconto;
        $dadosRequest['pct_desconto']     = $vrTotSevicos > 0
            ? ($vrTotDesconto / $vrTotSevicos) * 100
            : 0;
        $dadosRequest['pct_acrescimo']    = 0;
        $dadosRequest['vr_acrescimo']     = 0;
        $dadosRequest['id'] = $id;

        app(WorkOrderRepositoryInterface::class)
            ->update(WorkOrderEntity::buildEntity(CreateWorkOrderCommand::build(
                $dadosRequest
            )->getDataProperties()));

        return  app(WorkOrderRepositoryInterface::class)
            ->findById(new WorkOrderId((string)$id));
    }

    public function destroy(int $id)
    {

        if ($id <= 0) {
            throw new OrdemServicoException(__('work_order.invalid_parameter'));
        }

        $registro = app(WorkOrderRepositoryInterface::class)
            ->findById(new WorkOrderId((string)$id));

        if (!$registro) {
            throw new OrdemServicoException(__('work_order.delete_error_generic'));
        }

        app(WorkOrderRepositoryInterface::class)
            ->update(WorkOrderEntity::buildEntity(CreateWorkOrderCommand::build(
                ['active' => 'no', 'id' => $id]
            )->getDataProperties()));

        return app(WorkOrderRepositoryInterface::class)
            ->findById(new WorkOrderId((string)$id));
    }

    public function json(array $data, $usePaginate = false)
    {
        $consulta = $data;
        $ordem = $consulta['ordem'] ?? 'id-desc';

        $parse = [];

        $registro = DB::table('ordem_servicos as os')->join('pessoas as pes', function ($join) {

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

                        // no break
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

        $oremCampo      = $ordemArr[0];
        $oremTipo       = $ordemArr[1];
        $usePaginate    = $consulta['usePaginate'] ?? 0;
        $usePaginate    = (int) $usePaginate;
        $nrItensPerPage = isset($consulta['nr_itens_per_page']) && $consulta['nr_itens_per_page'] > 0 ? $consulta['nr_itens_per_page'] : self::PAGINACAO_ITENS_POR_PAGINA_PADRAO;
        $usePaginate    = (int) $usePaginate;

        if ($usePaginate > 0) {
            $registro   = $registro->where('os.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->paginate($nrItensPerPage);
        } else {
            $registro   = $registro->where('os.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->get();
        }

        return $registro;
    }
}
