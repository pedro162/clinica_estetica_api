<?php

namespace App\Helpers;

use App\Application\Commands\AccountReceivable\CreateAccountReceivableCommand;
use App\Application\Handlers\AccountReceivable\CreateAccountReceivableHandler;
use App\Application\Handlers\AccountReceivable\GetAccountReceivableByIdHandler;
use App\Application\Handlers\AccountReceivable\GetAllAccountReceivableHandler;
use App\Application\Handlers\AccountReceivable\UpdateAccountReceivableHandler;
use App\Application\Handlers\AccountReceivableItem\CreateAccountReceivableItemHandler;
use App\ContaReceber;
use App\ContaReceber as CobrancaReceber;
use App\Exceptions\CobrancaReceberException;
use App\FormaPagamento;
use App\OrdemServico;
use App\Pessoa;
use App\Utilitarios;
use App\Validators\AccountReceivable\AccountReceivableValidator;

class ContaReceberHelper extends BaseHelper
{
    private CreateAccountReceivableHandler $createAccountReceivableHandler;
    protected GetAllAccountReceivableHandler $getAllAccountReceivableHandler;
    protected UpdateAccountReceivableHandler $updateAccountReceivableHandler;
    protected GetAccountReceivableByIdHandler $getAccountReceivableByIdHandler;
    protected AccountReceivableValidator $accountReceivableValidator;
    private CreateAccountReceivableItemHandler $createAccountReceivableItemHandler;
    protected ContaReceberItemHelper $accountReceivableItemHelp;

    public function __construct(
        CreateAccountReceivableHandler $createAccountReceivableHandler,
        GetAllAccountReceivableHandler $getAllAccountReceivableHandler,
        UpdateAccountReceivableHandler $updateAccountReceivableHandler,
        GetAccountReceivableByIdHandler $getAccountReceivableByIdHandler,
        AccountReceivableValidator $accountReceivableValidator,
        CreateAccountReceivableItemHandler $createAccountReceivableItemHandler,
        ContaReceberItemHelper $accountReceivableItemHelp
    ) {
        $this->createAccountReceivableHandler = $createAccountReceivableHandler;
        $this->getAllAccountReceivableHandler = $getAllAccountReceivableHandler;
        $this->updateAccountReceivableHandler = $updateAccountReceivableHandler;
        $this->getAccountReceivableByIdHandler = $getAccountReceivableByIdHandler;
        $this->accountReceivableValidator = $accountReceivableValidator;
        $this->createAccountReceivableItemHandler = $createAccountReceivableItemHandler;
        $this->accountReceivableItemHelp = $accountReceivableItemHelp;
    }

    public function validaGerCobranca(int $idPessoa, float $paidValue, int $idFormaPagamento, int $idPlanoPagamento, $idOperadorFinanceiro = null, array $dados = []): array
    {
        $erros = [];

        $paymentMethodObject      = FormaPagamento::where('active', '=', 'yes')->where('id', '=', $idFormaPagamento)->first();
        $paymentPlanObject = $paymentMethodObject
            ? $paymentMethodObject->planoPagamento()->where('plano_pagamentos.active', '=', 'yes')->where('plano_pagamentos.id', '=', $idPlanoPagamento)->first()
            : null; //PlanoPagamento::where('active','=', 'yes')->where('id', '=' $idPlanoPagamento)->first();
        $operatorFainantialObject = $paymentMethodObject
            ? $paymentMethodObject->operadorFinanceiro()->where('operador_financeiros.active', '=', 'yes')->where('operador_financeiros.id', '=', $idOperadorFinanceiro)->first()
            : null;
        $personObject              = Pessoa::where('active', '=', 'yes')->where('id', '=', $idPessoa)->first();
        $paidValue   = Utilitarios::removeMaskMoney($paidValue);

        if (!$personObject) {
            $erros[] = 'A pessoa de código nº ' . $idPessoa . ' não foi identificada.';
        }

        if (!$paymentMethodObject) {
            $erros[] = 'A forma de pagamento de código nº ' . $idFormaPagamento . ' não foi identificada.';
        }

        if (!$paymentPlanObject) {
            $erros[] = 'O plano de pagamento de código nº ' . $idPlanoPagamento . ' não foi identificado.';
        }

        if (!$operatorFainantialObject) {
            if ($paymentMethodObject && $paymentMethodObject->hasOperadorFinanceiro == 'yes') {
                $erros[] = 'O operador financeiro de código nº ' . $idOperadorFinanceiro . ' não foi identificado.';
            }
        }

        if (!$paidValue) {
            $erros[] = 'O valor da cobrança informado é inválido.';
        }

        return $erros;
    }

    protected function accountReceivableParseData(array $data)
    {
        return [
            'pessoa_id' => $data['pessoa_id'] ?? null,
            'descricao' => $data['descricao'] ?? 'Recita financeira',
            'documento' => $data['documento'] ?? null,
            'dtVencimentoOriginal' => $data['dtVencimentoOriginal'],
            'dtVencimento' => $data['dtVencimento'] ?? null,
            'vrPago' => $data['vrPago'] ?? 0,
            'vrBruto' => $data['vrBruto'] ?? 0,
            'vrLiquido' => $data['vrLiquido'] ?? 0,
            'vrDevolvido' => $data['vrDevolvido'] ?? 0,
            'vrTaxa' => $data['vrTaxa'] ?? 0,
            'vrDesconto' => $data['vrDesconto'] ?? 0,
            'vrJuros' => $data['vrJuros'] ?? 0,
            'importacao_dados' => $data['importacao_dados'] ?? 'no',
            'referencia_id' => $data['referencia_id'] ?? null,
            'referencia' => $data['referencia'] ?? null,
            'filial_id' => $data['filial_id'] ?? null,
            'responsavel_id' => $data['responsavel_id'] ?? null,
            'forma_pagamento_id' => $data['forma_pagamento_id'] ?? null,
            'plano_pagamento_id' => $data['plano_pagamento_id'] ?? null,
            'operador_financeiro_id' => $data['operador_financeiro_id'] ?? null,
            'status' => $data['status'] ?? 'aberto',
        ];
    }

    public function gerarCobranca(
        int $idPessoa,
        float $paidValue,
        int $idFormaPagamento,
        int $idPlanoPagamento,
        $idOperadorFinanceiro = null,
        array $dados = []
    ) {
        $paymentMethodObject      = FormaPagamento::where('active', '=', 'yes')
            ->where('id', '=', $idFormaPagamento)->first();
        $paymentPlanObject = $paymentMethodObject
            ? $paymentMethodObject->planoPagamento()->where('plano_pagamentos.active', '=', 'yes')
            ->where('plano_pagamentos.id', '=', $idPlanoPagamento)->first()
            : null;
        $operatorFainantialObject = $paymentMethodObject
            ? $paymentMethodObject->operadorFinanceiro()->where('operador_financeiros.active', '=', 'yes')
            ->where('operador_financeiros.id', '=', $idOperadorFinanceiro)->first()
            : null;
        $personObject              = Pessoa::where('active', '=', 'yes')->where('id', '=', $idPessoa)->first();

        $paidValue   = Utilitarios::removeMaskMoney($paidValue);
        $erros = $this->validaGerCobranca(
            $idPessoa,
            $paidValue,
            $idFormaPagamento,
            $idPlanoPagamento,
            $idOperadorFinanceiro,
            $dados
        );

        if ((is_array($erros) && count($erros) > 0)) {
            throw new CobrancaReceberException(implode('<br/>', $erros));
        }

        $installMentsQuantity = $paymentPlanObject->installMentsQuantitys ?? 1;
        $installMents       = [];
        $qtdDiasIntervalo   = $paymentPlanObject->qtdDiasIntervaloParcelas ?? 0;
        $qtdDiasPriParcela  = $paymentPlanObject->qtd_dias_pri_parcela ?? 0;
        $vrParcelaBase      = $paidValue / $installMentsQuantity;
        $vrParcelaBase      = (float) $vrParcelaBase;

        $objDtVencimento = new \DateTime();

        if ($qtdDiasPriParcela > 0) {
            $objDtVencimento->add(new \DateInterval('P' . $qtdDiasPriParcela . 'D'));
        }

        $vrTotalParelasGeradas = 0;
        $defaultReferenceId = date('ymdhis');
        $defaultReference = 'sem_referencia';
        $status = $dados['status'] ?? 'aberto';
        $isCardPayment = trim($paymentMethodObject->tipo) == 'cartao_credito'
            || trim($paymentMethodObject->tipo) == 'cartao_debito';
        $shouldSettleCashPayment = trim($paymentMethodObject->tipo) == 'dinheiro'
            && isset($dados['caixa_id'])
            && $dados['caixa_id'] > 0;

        if ($isCardPayment) {
            $installMentsQuantity = 1;

            if (isset($dados['document']) && strlen(trim($dados['document'])) >= 3) {
                $status    = 'pago';
            }
        }

        if ($shouldSettleCashPayment) {
            $installMentsQuantity = 1;
            $status = 'aberto';
        }

        for ($i = 0; !($i == $installMentsQuantity); $i++) {
            $dtVencimento = $objDtVencimento->format('Y-m-d H:i:s');
            $installMents[] = $this->accountReceivableParseData([
                'pessoa_id' => $personObject->id,
                'descricao' => $dados['descricao'] ?? $dados['description'] ?? 'Recita financeira',
                'documento' => $dados['documento'] ?? $dados['document'] ?? null,
                'dtVencimentoOriginal' => $dtVencimento,
                'dtVencimento' => $dtVencimento,
                'vrBruto' => $vrParcelaBase,
                'vrLiquido' => $vrParcelaBase,
                'importacao_dados' => 'no',
                'referencia_id' => $dados['referencia_id'] ?? $dados['referenceId'] ?? $defaultReferenceId,
                'referencia' => $dados['referencia'] ?? $dados['reference'] ?? $defaultReference,
                'filial_id' => $dados['filial_id'] ?? $dados['branchId'] ?? null,
                'responsavel_id' => $dados['responsavel_id'] ?? $dados['responsibleId'] ?? null,
                'forma_pagamento_id' => $paymentMethodObject->id,
                'plano_pagamento_id' => $paymentPlanObject->id,
                'operador_financeiro_id' => $operatorFainantialObject->id ?? null,
                'status' => $status,
                'caixa_id' => $dados['caixa_id'] ?? null,
            ]);

            if ($qtdDiasIntervalo > 0) {
                $objDtVencimento->add(new \DateInterval('P' . $qtdDiasIntervalo . 'D'));
            }

            $vrTotalParelasGeradas += $vrParcelaBase;
        }

        $installMentsDiff    = $vrParcelaBase - $vrTotalParelasGeradas;
        $installMentsDiffAbs = abs($installMentsDiff);

        if ($installMentsDiffAbs > 0.02 && is_array($installMents) && count($installMents) > 0) {
            $installMents[0]['vrPago']      += 0;
            $installMents[0]['vrBruto']     += $installMentsDiff;
            $installMents[0]['vrLiquido']   += $installMentsDiff;
        }

        $datacobReceberObjArr = [
            'data_cob_receber' => [],
            'data_cob_receber_cartoes' => [],
            'data_cob_receber_boletos' => [],
        ];

        $itens = [];

        if (is_array($installMents) && count($installMents) > 0) {
            foreach ($installMents as $key => $val) {

                $accountReceivable = $this->createAccountReceivableHandler->handler(
                    CreateAccountReceivableCommand::build($val)
                );

                if (!$accountReceivable) {
                    throw new CobrancaReceberException('Não foi possível gerar os contas a receber.'
                        . 'Tente novamente ou entre em contato com o suporte.');
                }

                if ($accountReceivable->status == 'pago' || $shouldSettleCashPayment) {
                    $val['qtdParcelas'] = 1;
                    $itemData = $val;

                    if ($shouldSettleCashPayment) {
                        $itemData['status'] = 'aberto';
                        unset($itemData['caixa_id']);
                    }

                    $errosEncontrados = $this->accountReceivableItemHelp->validaGerCobrancaItem(
                        $accountReceivable,
                        (float)$accountReceivable->vrLiquido,
                        $paymentMethodObject->id,
                        $paymentPlanObject->id,
                        $operatorFainantialObject->id ?? null,
                        $itemData,
                    );

                    if (is_array($errosEncontrados) && count($errosEncontrados) > 0) {
                        throw new CobrancaReceberException(implode('<br/>', $errosEncontrados));
                    }

                    $responseHelper = $this->accountReceivableItemHelp->gerarCobrancaItem(
                        $accountReceivable,
                        (float)$accountReceivable->vrLiquido,
                        $paymentMethodObject->id,
                        $paymentPlanObject->id,
                        $operatorFainantialObject->id ?? 0,
                        $itemData
                    );

                    if (!$responseHelper) {
                        throw new CobrancaReceberException('Não foi possível realizar a baixa do contas '
                            . 'a receber vinculado ao cartão informado. Tente novamente ou entre em contato com o suporte.');
                    }

                    $dataCartoes = $responseHelper['data_cob_receber_cartoes'] ??  [];
                    $datacobReceberObjArr['data_cob_receber_cartoes'][] = $dataCartoes;
                    $itens[] = $responseHelper['data_cob_receber_item'] ?? [];
                }

                $datacobReceberObjArr['data_cob_receber'][] = $accountReceivable;
            }
        } else {
            throw new CobrancaReceberException('Não foi possível identificar quantas parcelas deveriam ser geradas.'
                . ' Tente novamente ou entre em contato com o suporte.');
        }

        if ($shouldSettleCashPayment && $itens) {
            foreach ($itens as $key => $val) {
                foreach ($val as $keyItem => $valItem) {
                    if ($valItem->status == 'aberto' && $valItem->vrLiquido > 0) {
                        $this->accountReceivableItemHelp->baixar([
                            'caixa_id' => $dados['caixa_id'],
                            'vr_pago' => $valItem->vrLiquido,
                            'ds_observacao' => $valItem->descricao ?? 'Baixa automática gerada na criação da cobrança.',
                        ], $valItem->id);
                    }
                }
            }
        }

        return $datacobReceberObjArr;
    }

    public function baixar(array $dados, int $id): ContaReceber
    {
        $id = $id ?? $dados['id'];
        $callBack = $dados['callBack'] ?? '';
        $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';

        if ($id <= 0) {
            throw new CobrancaReceberException('Parâmetro ínválido');
        }

        $paidValue = $dados['vr_final'] ?? 0;
        $paidValue   = (float)Utilitarios::removeMaskMoney($paidValue);

        $interestValue = $dados['vr_juros'] ?? 0;
        $interestValue   = (float)Utilitarios::removeMaskMoney($interestValue);

        $feeValue = $dados['vr_multa'] ?? 0;
        $feeValue   = (float)Utilitarios::removeMaskMoney($feeValue);

        $discountValue = $dados['vr_desconto'] ?? 0;
        $discountValue   = (float)Utilitarios::removeMaskMoney($discountValue);

        if (!($paidValue > 0)) {
            throw new CobrancaReceberException('O valor para baixa é inválido');
        }

        if ($interestValue < 0) {
            throw new CobrancaReceberException('O valor para juros é inválido');
        }

        if ($feeValue < 0) {
            throw new CobrancaReceberException('O valor para multa é inválido');
        }

        if ($discountValue < 0) {
            throw new CobrancaReceberException('O valor para desconto é inválido');
        }

        $registro = $this->getAccountReceivableByIdHandler->handler(CreateAccountReceivableCommand::build(['id' => $id]));

        if (!$registro) {
            throw new CobrancaReceberException('Registro não identificado. Tentenovamente ou entre em contato com o suporte');
        }

        $dataParcela = [
            'pessoa_id' => $registro->pessoa->id,
            'descricao' => $dados['descricao'] ?? 'Recita financeira',
            'documento' => $dados['documento'] ?? null,
            'dtVencimentoOriginal' => $registro->dtVencimentoOriginal,
            'dtVencimento' => $registro->dtVencimento,
            'vrPago' => 0,
            'vrBruto' => $paidValue,
            'vrLiquido' => $paidValue,
            'vrDevolvido' => 0,
            'vrTaxa' => $feeValue,
            'vrDesconto' => $discountValue,
            'vrJuros' => $interestValue,
            'active' => 'yes',
            'importacao_dados' => 'no',
            'referencia_id' => $registro->referencia_id ?? date('ymdhis'),
            'referencia' => $registro->referencia ?? 'sem_referencia',
            'filial_id' => $registro->filial_id ?? null,
            'responsavel_id' => $registro->responsavel_id ?? null,
            'qtd_parcelas' => 1,
            'nr_parcela' => 1,
            'forma_pagamento_id' => $registro->formaPagamento->id,
            'plano_pagamento_id' => $registro->planoPagamento->id,
            'operador_financeiro_id' => $registro->operadorFinanceiro->id ?? null,
            'status' => 'aberto',
        ];

        $dataResponse = $this->accountReceivableItemHelp->gerarCobrancaItem(
            $registro,
            $paidValue,
            $registro->formaPagamento->id,
            $registro->planoPagamento->id,
            $registro->operadorFinanceiro->id ?? 0,
            $dataParcela
        );

        if (!(is_array($dataResponse) && count($dataResponse) > 0)) {
            throw new CobrancaReceberException('Não foi possível concluir a operação. Tentenovamente ou entre em contato com o suporte');
        }

        $dataItens = $dataResponse['data_cob_receber_item'] ?? [];

        if (!(is_array($dataItens) && count($dataItens) > 0)) {
            throw new CobrancaReceberException('Não foi possível concluir a operação. Tentenovamente ou entre em contato com o suporte');
        }

        foreach ($dataItens as $key => $contaRecebrItem) {
            if (!($contaRecebrItem)) {
                throw new CobrancaReceberException('Não foi possível concluir a operação. Tentenovamente ou entre em contato com o suporte');
            }

            $this->accountReceivableItemHelp->baixar($dados, $contaRecebrItem->id);
        }

        return $registro->refresh();
    }

    public function update(array $data, int $id)
    {
        $dadosRequest = [];
        $dadosRequest['descricao']                  = $data['descricao'];
        $dadosRequest['user_update_id']             = \Auth::User()->id;
        $dadosRequest['active']                     =  'yes';

        $registro = CobrancaReceber::where('active', '=', 'yes')->where('id', '=', $id)->first();

        if (!$registro) {
            throw new CobrancaReceberException('Registro não identificado');
        }

        $registro->update($dadosRequest);

        return $registro;
    }

    public function info(array $data, $id, $idAssistente = 0)
    {

        $dados = $data;
        $id = $id ?? $dados['id'];
        $callBack = $dados['callBack'] ?? '';
        $idAssistente =  $idAssistente ?? $dados['idAssistente'] ?? '';

        if ($id <= 0) {
            throw new CobrancaReceberException('Parâmetro ínválido');
        }

        $registro = CobrancaReceber::where('active', '=', 'yes')
            ->where('id', '=', $id)->first();

        if ($registro == null) {
            throw new CobrancaReceberException('Registro não encontrado');
        }

        if ($registro->pessoa) {
            $registro->pessoa->logradouro;
            $registro->pessoa->telefone;
        }

        if ($registro->referencia_id > 0 && $registro->referencia == 'ordem_servicos') {
            $registro->data_referencia = OrdemServico::find($registro->referencia_id);
        }
        $registro->contaReceberItem;

        return $registro;
    }

    public function faturamentoLiquidezMesAnoWidgetJson(array $data)
    {
        $rawSqlYear = \DB::raw('YEAR(cr.created_at)');
        $rawSqlMes = \DB::raw('MONTH(cr.created_at)');
        $rawSqlDia = \DB::raw('DAY(cr.created_at)');
        $rawSqlFilial = \DB::raw('cr.filial_id');

        $data['campos'] = [
            \DB::raw('SUM(IFNULL(cr.vrLiquido, 0)) as vrFaturamentoLiquidez'),
            \DB::raw('YEAR(cr.created_at) as anoFaturamentoLiquidez'),
            \DB::raw('MONTH(cr.created_at) as mesFaturamentoLiquidez'),
            //\DB::raw('DAY(cr.created_at) as diaFaturamentoLiquidez'),
            \DB::raw('cr.filial_id as filial_id'),
        ];

        $data['raw_grop_by'] = "{$rawSqlFilial},{$rawSqlYear},{$rawSqlMes}";

        return $this->json($data);
    }

    public function faturamentoLiquidezFilialWidgetJson(array $data)
    {
        $rawSqlYear = \DB::raw('YEAR(cr.created_at)');
        $rawSqlMes = \DB::raw('MONTH(cr.created_at)');
        $rawSqlDia = \DB::raw('DAY(cr.created_at)');
        $rawSqlFilial = \DB::raw('cr.filial_id');

        $data['campos'] = [
            \DB::raw('SUM(IFNULL(cr.vrLiquido, 0)) as vrFaturamentoLiquidez'),
            \DB::raw('cr.filial_id as filial_id'),
        ];

        $data['raw_grop_by'] = "{$rawSqlFilial}";

        return $this->json($data);
    }


    public function faturamentoLiquidezProfissionallWidgetJson(array $data)
    {
        $rawSqlYear         = \DB::raw('YEAR(cr.created_at)');
        $rawSqlProfi        = \DB::raw('IFNULL(os.profissional_id, "000000")');
        $rawSqlProfiNome   = \DB::raw('IFNULL(pprof.name, "Sem profissíonal")');

        $data['campos'] = [
            \DB::raw('SUM(IFNULL(cr.vrLiquido, 0)) as vrFaturamentoLiquidez'),
            \DB::raw('IFNULL(os.profissional_id, "000000") as profissional_id'),
            \DB::raw('IFNULL(pprof.name, "Sem profissíonal") as name_profissional'),
        ];

        $data['raw_grop_by']        = "{$rawSqlProfi},{$rawSqlProfiNome}";
        $data['com_ordem_servico']  = true;

        return $this->json($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function json(array $data)
    {
        $consulta = $data;

        if (!isset($consulta['ordem'])) {
            $consulta['ordem'] =  'id-desc';
        }
        $ordem = $consulta['ordem'] ?? 'id-desc';

        $campos =  $data['campos'] ?? [];
        $parse = [
            'id' => 'cr.id',
            'name' => 'pessoas.name',
            'filial_id' => 'cr.filial_id',
        ];

        $registro = \DB::table('conta_recebers as cr');
        $registro->join('pessoas', function ($join) {
            $join->on('pessoas.id', '=', 'cr.pessoa_id');
        })->join('filials as fl', function ($join) {

            $join->on('cr.filial_id', '=', 'fl.id');
        })->join('pessoas as pesfl', function ($join) {

            $join->on('fl.pessoa_id', '=', 'pesfl.id');
        })->join('forma_pagamentos as fp', function ($join) {
            $join->on('fp.id', '=', 'cr.forma_pagamento_id');
        });

        if (isset($data['com_ordem_servico'])) {
            $registro->leftJoin('ordem_servicos as os', function ($join) {
                $join->on('os.id', '=', 'cr.referencia_id')->on('cr.referencia', '=', \DB::raw('"ordem_servicos"'));
            })->join('profissionals as prof', function ($join) {
                $join->on('prof.id', '=', 'os.profissional_id');
            })->join('pessoas as pprof', function ($join) {
                $join->on('pprof.id', '=', 'prof.pessoa_id');
            });
            //echo $registro->toSql();
        }

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
                        }

                        $val = explode(',', $val);
                        $registro->whereIn('cr.id', $val);
                        break;
                    case 'nmPessoa':
                    case 'pessoa_name':
                    case 'name_pessoa':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }

                            $registro->where('pessoas.name', 'like', '%' . $val . '%');
                        }
                        break; //
                    case 'vencido':

                        if (is_string($val)) {
                            $registro->whereIn('cr.status', ['aberto']);

                            if (trim($val) == 'yes') {
                                $registro->where('cr.dtVencimento', '<', date('Y-m-d'));
                            } elseif (trim($val) == 'no') {
                                $registro->where('cr.dtVencimento', '>=', date('Y-m-d'));
                            }
                        }

                        break;
                    case 'dt_exercicio':
                        $tpExercicio = 'dtVencimento';

                        if (isset($consulta['tp_exercicio'])) {
                            switch ($consulta['tp_exercicio']) {
                                case 'created_at':
                                case 'criacao':
                                    $tpExercicio = 'created_at';
                                    break;
                                case 'vencimento':
                                    $tpExercicio = 'dtVencimento';
                                    break;

                                default:
                                    $tpExercicio = 'dtVencimento';
                                    break;
                            }
                            $tpExercicio = 'dtVencimento';
                        }
                        if (is_string($val) && strpos($val, ',') > -1) {
                            $val = explode(',', $val);
                            $registro->where('cr.' . $tpExercicio, '>=', date($val[0]));
                            $registro->where('cr.' . $tpExercicio, '<=', date($val[1]));
                        }

                        break;

                    case 'pessoa_id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);

                            $registro->whereIn('pessoas.id', $val);
                        }
                        break;
                    case 'filial_id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                        }

                        $val = explode(',', $val);

                        $registro->whereIn('cr.filial_id', $val);
                        break;
                    case 'referencia_id':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                        }

                        $val = explode(',', $val);

                        $registro->whereIn('cr.referencia_id', $val);
                        break;

                    case 'referencia':
                        if (is_string($val)) {

                            if ($val[0] == ',') {
                                $val = substr($val, 1);
                            }
                            if ($val[strlen($val) - 1] == ',') {
                                $val = substr($val, 0, -1);
                            }
                            $val = explode(',', $val);

                            $registro->whereIn('cr.referencia', $val);
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

                            $registro->whereIn('cr.status', $val);
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
                            //$campos = $this->montaCamposConsulta($registro, $val);

                        }
                        break;
                    case 'grop_by':
                        $registro->groupBy($val);
                        break;
                    case 'raw_grop_by':
                        $registro->groupByRaw($val);
                        break;
                }
            }
        }
        $sqlDsReferencia = '(
                    CASE 
                        WHEN cr.referencia = "ordem_servicos" THEN "Ordem de serviço"
                        ELSE "Referência não mapeada"
                    END
                )
                as dsReferencia
            ';
        if ($campos) {
            $registro->select($campos);
        } else {
            $registro->select('cr.*', \DB::raw('(IFNULL(cr.vrLiquido, 0) - (IFNULL(cr.vrPago, 0) + IFNULL(cr.vrDevolvido, 0)))  vrAberto'), \DB::raw($sqlDsReferencia), 'fp.cdCobrancaTipo', 'fp.name as name_cob_tp', 'pessoas.name', 'pesfl.name as name_filial');
        }


        //----
        $ordemArr   = explode('-', $ordem);
        $oremCampo  = $ordemArr[0];
        $oremTipo  = $ordemArr[1];

        $usePaginate = $consulta['usePaginate'] ?? 0;
        $usePaginate = (int) $usePaginate;
        $nrItensPerPage = isset($consulta['nr_itens_per_page']) && $consulta['nr_itens_per_page'] > 0 ? $consulta['nr_itens_per_page'] : self::PAGINACAO_ITENS_POR_PAGINA_PADRAO;
        if ($usePaginate > 0) {
            $registro   = $registro->where('cr.active', '=', 'yes')
                ->where('pessoas.active', '=', 'yes')->orderBy($oremCampo, $oremTipo)->paginate($nrItensPerPage);
        } else {
            $registro = $registro->where('cr.active', '=', 'yes')
                ->where('pessoas.active', '=', 'yes')->get();
        }

        if (isset($consulta['to_require']) && $consulta['to_require'] == true) {
            $dataToRequest = [];
            foreach ($registro as $reg) {
                $dataToRequest[] = ['label' => $reg->name, 'value' => $reg->id];
            }

            $registro = $dataToRequest;
        }
        //---

        return  $registro;
    }
}
